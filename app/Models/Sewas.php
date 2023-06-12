<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sewas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang', 'id_penyewa', 'durasi_sewa', 'jumlah_sewa'
    ];

    public function sewa_barang(): BelongsTo
    {
        return $this->belongsTo(Barangs::class, 'id_barang');
    }

    public function sewa_users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penyewa');
    }
}
