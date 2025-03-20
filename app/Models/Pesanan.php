<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    protected $fillable = [
        'user_id',
        'daftar_menu',
        'total_harga',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
