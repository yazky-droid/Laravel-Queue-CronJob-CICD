<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use App\Mail\SendMailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdatePendingToNotPaid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user_id, $transaction_id;
    public function __construct($user_id,$transaction_id)
    {
        $this->user_id = $user_id;
        $this->transaction_id = $transaction_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $expiredOrder = Carbon::now()->format('Y-m-d H:i:s');
        // $user = User::find($this->user_id);
        // $transaction = Transaction::find($this->transaction_id)->get();

    $transaction = Transaction::find($this->transaction_id);
    if ($transaction->status == 'Pending'){
        Transaction::find($this->transaction_id)->update([
            'status' => 'Not Paid'
        ]);
            $user = User::find($this->user_id);
            $details = [
                'email' => $user->email,
                'name' => $user->name,
                'subject' => 'Order Expired',
                'header' => '# Your order expired',
                'content' => '<p> We are sorry, your order already expired now.<br>Please, re-order the product do you want to buy.<br>So we can process it soon.</p>',
            ];
            Mail::to($details['email'])->send(new SendMailNotification($details));
            return 'email sended';
    }
    }
}
