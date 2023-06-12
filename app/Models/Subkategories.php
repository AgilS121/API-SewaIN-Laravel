<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subkategories extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kategori', 'nama_subkategori'
    ];

    /**
     * Get the user that owns the SubKategories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nkategori(): BelongsTo
    {
        return $this->belongsTo(Kategories::class, 'id_kategori');
    }
}
