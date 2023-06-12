<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Midtranstransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_sewa',
        'status',
        'payment_type',
        'transaction_time',
        'amount',
        'transaction_id',
        'va_number',
        'bank',
    ];

    public function midtrans_sewa(): BelongsTo
    {
        return $this->belongsTo(Sewas::class, 'id_sewa');
    }
}
