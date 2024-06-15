<?php

// app/Models/PurchaseRequestItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_request_id',
        'nama_barang',
        'satuan',
        'rencana_pakai',
        'rencana_beli',
        'mata_uang',
        'harga_satuan',
        'keterangan',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
}
