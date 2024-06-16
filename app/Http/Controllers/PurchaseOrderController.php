<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\RushOrderItem;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequestItem;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::when(request('search') ?? false, function ($query, $search) {
                return $query->where('name', 'LIKE', "%$search%");
            })
            ->with('items')
            ->paginate(10)
            ->withQueryString();

        $totalpo = PurchaseOrder::count();

        return view('PurchaseOrder.index', [
            'purchaseOrders' => $purchaseOrders,
            'totalpo' => $totalpo,
        ]);
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('PurchaseOrder.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|in:purchase_request,rush_order',
            'methode' => 'required',
            'state' => 'required',
            'date' => 'required|date',
            'vendor_id' => 'required|exists:vendors,id',
            'items' => 'required|array',
            'items.*' => 'required|integer', // Item ID validation
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'order_date' => $validated['date'],
            'vendor_id' => $validated['vendor_id'],
            'total_amount' => 0,
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $itemId) {
            if ($validated['source'] == 'purchase_request') {
                $item = PurchaseRequestItem::findOrFail($itemId);
            } else {
                $item = RushOrderItem::findOrFail($itemId);
            }

            $purchaseOrderItem = new PurchaseOrderItem([
                'nama_barang' => $item->nama_barang,
                'satuan' => $item->satuan,
                'quantity' => $item->rencana_beli,
                'harga_satuan' => $item->harga_satuan,
                'total' => ($item->rencana_beli * $item->harga_satuan),
            ]);

            $purchaseOrder->items()->save($purchaseOrderItem);
            $totalAmount += $item->harga_satuan;
            $item->update(['inPO' => 'yes']);
        }

        $purchaseOrder->update(['total_amount' => $totalAmount]);

        Alert::success('Success', 'Purchase Order created successfully.');
        return redirect()->route('purchase_orders.index');
    }

    public function filterItems(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|in:purchase_request,rush_order',
            'methode' => 'required',
            'state' => 'required',
        ]);

        if ($validated['source'] == 'purchase_request') {
            $items = PurchaseRequestItem::where('methode', $validated['methode'])
                ->where('state', $validated['state'])
                ->where('inPO', 'no')
                ->get();
        } else {
            $items = RushOrderItem::where('methode', $validated['methode'])
                ->where('state', $validated['state'])
                ->where('inPO', 'no')
                ->get();
        }

        return response()->json($items);
    }
}

