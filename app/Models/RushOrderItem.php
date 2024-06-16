<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RushOrderItem extends Model
{
    use HasFactory;


    protected $fillable = [
        'rush_orders_id',
        'nama_barang',
        'satuan',
        'rencana_pakai',
        'rencana_beli',
        'mata_uang',
        'harga_satuan',
        'keterangan',
    ];

    public function rush_order()
    {
        return $this->belongsTo(RushOrder::class, 'rush_orders_id');
    }
}
