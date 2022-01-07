<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\SendMailNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function expiredDate($id)
    {
        // $email = User::find($id)->email;
        // $name = User::find($id)->name;
        $expire = Transaction::orderBy('created_at', 'desc')->where('user_id', $id)->first()->expired_at;
        // Mail::to($email)->send(new SendMailNotification('newOrder', $email, $name, $expire));
        $user = User::with('userTransaction')->find($id);
        $details = [
            'email' => $user->email,
            'name' => $user->name,
            'subject' => 'Order Created',
            'header' => '# Your order has been created',
            'content' => '<p> We have been receive your order. <br>Please, finish your payment before <b>'.$expire.'</b><br>So that we process immediately.</p>',
            'expire' => $expire,
        ];
        Mail::to($details['email'])->send(new SendMailNotification($details));
        }

    public static function paid($id)
    {
        $user = User::with('userTransaction')->find($id);
        $details = [
            'email' => $user->email,
            'name' => $user->name,
            'subject' => 'Order Paid',
            'header' => '# Your order payment is success',
            'content' => '<p> Thanks, your payment order is success. <br>Please wait, your order is processing.<br>And, we will send it immediately to you.</p>',
        ];
        Mail::to($details['email'])->send(new SendMailNotification($details));
    }
    }
