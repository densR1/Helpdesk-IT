<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    protected $table = 'ticket_comments';

    protected $fillable = [
        'tiket_id',
        'user_id',
        'komentar',
        'attachment',
    ];

    public function ticket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'id_tiket');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
