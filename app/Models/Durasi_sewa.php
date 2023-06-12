<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Durasi_sewa extends Model
{
    protected $table = 'durasi_sewa';

    public function barang()
    {
        return $this->hasMany(Barang::class, 'durasi_id');
    }
}
