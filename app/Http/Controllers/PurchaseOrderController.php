<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Requisition;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::all();
        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $requisitions = Requisition::where('status', 'approved')->get();
        $vendors = Vendor::all();
        return view('purchase_orders.create', compact('requisitions', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'requisition_id' => 'required|exists:requisitions,id',
            'vendor_id' => 'required|exists:vendors,id',
            'details' => 'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'requisition_id' => $request->requisition_id,
            'vendor_id' => $request->vendor_id,
            'status' => 'pending',
            'details' => $request->details,
        ]);

        foreach ($request->products as $product) {
            $purchaseOrder->products()->attach($product['id'], ['quantity' => $product['quantity'], 'price' => $product['price']]);
        }

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $requisitions = Requisition::where('status', 'approved')->get();
        $vendors = Vendor::all();
        return view('purchase_orders.edit', compact('purchaseOrder', 'requisitions', 'vendors'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'requisition_id' => 'required|exists:requisitions,id',
            'vendor_id' => 'required|exists:vendors,id',
            'details' => 'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $purchaseOrder->update([
            'requisition_id' => $request->requisition_id,
            'vendor_id' => $request->vendor_id,
            'status' => 'pending',
            'details' => $request->details,
        ]);

        $purchaseOrder->products()->detach();
        foreach ($request->products as $product) {
            $purchaseOrder->products()->attach($product['id'], ['quantity' => $product['quantity'], 'price' => $product['price']]);
        }

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();
        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order deleted successfully.');
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => 'approved']);
        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order approved successfully.');
    }
}

