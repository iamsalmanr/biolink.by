<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_UNPAID = 'UNPAID';
    const STATUS_PENDING = 'PENDING';
    const STATUS_PAID = 'PAID';
    const STATUS_CANCELLED = 'CANCELLED';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'plan_id',
        'details',
        'total',
        'coupon',
        'taxes',
        'fees',
        'customer',
        'seller',
        'gateway',
        'payment_id',
        'status',
        'is_viewed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'object',
        'coupon' => 'object',
        'taxes' => 'object',
        'customer' => 'object',
        'seller' => 'object',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway', 'id');
    }
}
