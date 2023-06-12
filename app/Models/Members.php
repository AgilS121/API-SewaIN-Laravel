<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;


class Members extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable= [
        'id_users', 'nama_tempat', 'lokasi', 'no_wa'
    ];

    public function users_member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function isMember()
    {
        return true;
    }
}
