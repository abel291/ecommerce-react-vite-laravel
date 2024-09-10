<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $casts = [
        'method' => PaymentMethodEnum::class,
    ];

    protected $attributes = [
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

        // $status = $this->status == PaymentStatus::SUCCESSFUL;
        // dd($this->created_at->diff(now())->days);
        return $can;
    }
}
