<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RKBItem extends Model
{
    use HasFactory;
    protected $table = 'rkb_items';

    protected $fillable = [
        'rkb_id',
        'nama_barang',
        'satuan',
        'rencana_pakai',
        'rencana_beli',
        'mata_uang',
        'harga_satuan',
        'keterangan',
    ];

    public function rkb()
    {
        return $this->belongsTo(RKB::class, 'rkb_id');
    }
}
