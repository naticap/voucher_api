<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_id',
        'photo',
        'reserved_datetime',
        'max_upload_datetime',
        'redeemable', 
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'reserved_datetime' => 'datetime',
        'max_upload_datetime' => 'datetime',
        'redeemable' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
