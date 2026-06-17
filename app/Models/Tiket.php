<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';
    protected $primaryKey = 'id_tiket';

    protected $fillable = [
        'id_user_create',
        'id_kategori',
        'kode_tiket',
        'judul',
        'attachment',
        'deskripsi',
        'status',
        'id_agent',
        'id_admin',
        'note',
        'date_selesai',
    ];

    protected $casts = [
        'date_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_create', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'id_agent', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }

    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_CONFIRM = 3;
    public const STATUS_COMPLETED = 4;


    // Helper methods cek status
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isInProgress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isConfirm()
    {
        return $this->status === self::STATUS_CONFIRM;
    }
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-secondary',
            self::STATUS_APPROVED => 'bg-info',
            self::STATUS_IN_PROGRESS => 'bg-primary',
            self::STATUS_CONFIRM => 'bg-warning',
            self::STATUS_COMPLETED => 'bg-success',
            default => 'bg-secondary',
        };
    }

    public function getStatusLabel()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_CONFIRM => 'User Mengonfirmasi Tiket',
            self::STATUS_COMPLETED => 'Selesai',
            default => 'Unknown',
        };
    }


    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'tiket_id', 'id_tiket')
            ->orderBy('created_at', 'asc');
    }


}
