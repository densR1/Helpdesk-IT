<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Faq extends Model
{
    protected $fillable = [
        'kategori_id',
        'question',
        'answer',
        'file',
        'is_active',
    ];

    public function kategori()
{
    return $this->belongsTo(kategori::class,);
}
}
