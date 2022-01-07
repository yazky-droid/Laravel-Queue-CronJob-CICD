<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Jobs\UpdatePendingToNotPaid;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $message = [
            'user_id.required' => 'Kolom user ID harus diisi!',
            'user_id.numeric' => 'Kolom user ID harus angka!',
            'product_id.required' => 'Kolom product ID harus diisi!',
            'product_id.numeric' => 'Kolom product ID harus angka!',
            'product_qty.required' => 'Kolom product quantity harus diisi!',
            'product_qty.numeric' => 'Kolom product quantity harus angka!',
        ];
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'product_qty' => 'required|numeric',

        ], $message);

        if( $validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ]);
        }else {
            try {
                $product = Product::where('id', $request->product_id)->first();
                $dateNow = Carbon::create(now());
                $dateExpired = $dateNow->addHour(1)->format("Y-m-d H:i:s");
                $amount = $request->product_qty * $product->price;

                $transaction = Transaction::create([
                    'user_id' => $request->user_id,
                    'product_id' => $request->product_id,
                    'product_qty' => $request->product_qty,
                    'expired_at' => $dateExpired,
                    'amount' => $amount
                ]);
                MailController::expiredDate($request->user_id);
                dispatch(new UpdatePendingToNotPaid($request->user_id, $transaction->id))->delay(now()->addMinutes(60));
                return response()->json([
                    'message' => 'Checkout Product Success, You must pay it before ' . Carbon::create($dateExpired)->format("Y F d H:i:s"),
                    'status' => 200,
                ],200);
            } catch (\Throwable $th) {
                return $th;  //untuk cek errornya apa
                return response()->json([
                    'message' => 'Checkout Product Failed',
                ]);
            }
        }
    }

    public function userHistory($id)
    {
        try {
            $user = User::find($id);
            $transaction = Transaction::with('product')->where('user_id', $id)->orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Success',
                'data' => [
                    'user' => $user,
                    'transaction' => $transaction,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Get data history failed!'
            ], 400);
        }
    }
    public function paidOrder(Request $request, $id)
    {
        $transaction_paid = Transaction::where('status', 'Pending')->find($id);
        try {

            $transaction_paid->update([
                'status' => 'Process',
            ]);
            MailController::paid($request->user_id);
            return response()->json([
                'message' => 'Your order is confirmed paid'
            ],200);

        } catch (\Throwable $th) {
            return $th;
            return response()->json([
                'message' => 'Payment Failed',
            ],400);
        }

        }
}
