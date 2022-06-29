<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaidProduct extends Model
{
    use HasFactory;
    /* Get the user that owns the PaidProduct
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   
    protected $guard=[];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
