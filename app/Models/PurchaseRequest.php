<?php

// app/Models/PurchaseRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'rkb_id',
        'user_id',
        'tahun_anggaran',
        'jumlah_anggaran',
        'status',
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
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function rkb()
    {
        return $this->belongsTo(RKB::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
