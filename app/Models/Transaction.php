<?php

namespace App\Models;

use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    const STATUS_PENDING = "Pending";
    const STATUS_NOT_PAID = "Not Paid";
    const STATUS_PROCESS = "Process";

    const STATUS = [
        self::STATUS_PENDING,
        self::STATUS_NOT_PAID,
        self::STATUS_PROCESS,
    ];


    protected $date = [
        'created_at',
        'update_at'
    ];
    protected $fillable = [
        'user_id',
        'product_id',
        'product_qty',
        'status',
        'amount',
        'expired_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
