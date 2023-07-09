<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => PaymentStatus::class,
        'method' => PaymentMethodEnum::class,
    ];

    protected $attributes = [
        //'status' => PaymentStatus::PENDING,
    ];

    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function canCancel()
    {
        $max_days = 30;

        $can = $this->created_at->diff(now())->days < $max_days;

        $status = $this->status == PaymentStatus::SUCCESSFUL;
        // dd($this->created_at->diff(now())->days);
        return $can && $status;
    }
}
