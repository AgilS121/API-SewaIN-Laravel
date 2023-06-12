<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Barangs extends Model
{
    use HasFactory;

    // protected $table = 'barangs';

    protected $fillable= [
        'id_kategori', 'id_subkategori','id_member',  'durasi_sewa', 'nama_barang', 'deskripsi', 'image', 'harga', 'stok'
    ];

    public function barang_kategori(): BelongsTo
    {
        return $this->belongsTo(Kategories::class, 'id_kategori');
    }

    public function barang_subkategori(): BelongsTo
    {
        return $this->belongsTo(Subkategories::class, 'id_subkategori');
    }

    public function barang_member(): BelongsTo
    {
        return $this->belongsTo(Members::class, 'id_member');
    }

    public function getDurasiSewaAttribute($value)
    {
        return explode(',', $value);
    }


    protected $casts = [
        'durasi_sewa' => 'array',

    ];

    // protected $attributes = [
    //     'durasi_sewa' => '[]'
    // ];

}
