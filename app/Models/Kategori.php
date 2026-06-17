<?php

namespace App\Models;

use App\Models\Tiket;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model

{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori'];

    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'id_kategori');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class,'Kategori_id, id');
    }

}
