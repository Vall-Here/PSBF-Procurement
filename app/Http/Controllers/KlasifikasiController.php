<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RushOrderItem;
use App\Models\PurchaseRequestItem;
use RealRashid\SweetAlert\Facades\Alert;

class KlasifikasiController extends Controller
{
    public function index()
    {
        $purchaseRequestItems = PurchaseRequestItem::whereHas('purchaseRequest', function($query) {
            $query->where('status', 'approved');
        })->get();

        $rushOrderItems = RushOrderItem::whereHas('rush_order', function($query) {
            $query->where('status', 'approved');
        })->get();

        return view('Requisitions.Klasifikasi.klasifikasiPPRO', compact('purchaseRequestItems', 'rushOrderItems'));
    }

    public function update(Request $request, $id, $type)
    {
        if ($type === 'purchase_request') {
            $item = PurchaseRequestItem::findOrFail($id);
        } else {
            $item = RushOrderItem::findOrFail($id);
        }

        $item->methode = $request->input('methode');
        $item->state = $request->input('state');
        $item->save();

        Alert :: success('Success', 'Berhasil Update');
        return redirect()->route('klasifikasi.index');
    }
}
