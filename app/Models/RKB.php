<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RKB extends Model
{
    use HasFactory;

    protected $table = 'rkb';
    protected $primaryKey = 'id_rkb';
    protected $fillable = ['tahun_anggaran', 'jumlah_anggaran', 'user_id'];

    public function items()
    {
        return $this->hasMany(RKBItem::class, 'rkb_id', 'id_rkb');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
