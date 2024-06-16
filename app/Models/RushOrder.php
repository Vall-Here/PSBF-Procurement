<?php

namespace App\Models;

use App\Models\RushOrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RushOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_anggaran',
        'jumlah_anggaran',
        'status',
        'review_status',
    ];

    protected $casts = [
        'review_status' => 'array',
    ];

    public function isApprovedByAll()
    {
        return collect($this->review_status)->every(function ($status) {
            return $status === 'approved';
        });
    }

    public function items()
    {
        return $this->hasMany(RushOrderItem::class);
    }
}
