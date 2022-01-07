<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $date = [
        'created_at',
        'update_at'
    ];

    protected $fillable = [
        'name',
        'price',
        'original_img',
        'original_img_url',
        'large_img',
        'large_img_url',
        'medium_img',
        'medium_img_url',
        'small_img',
        'small_img_url',

    ];

    public function productTransaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
