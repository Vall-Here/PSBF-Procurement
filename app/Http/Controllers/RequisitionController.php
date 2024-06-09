<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitionController extends Controller
{
    public function index()
    {
        $requisitions = Requisition::all();
        return view('requisitions.index', compact('requisitions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('requisitions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $requisition = Requisition::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'status' => 'pending',
        ]);

        foreach ($request->products as $product) {
            $requisition->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition created successfully.');
    }

    public function show(Requisition $requisition)
    {
        return view('requisitions.show', compact('requisition'));
    }

    public function edit(Requisition $requisition)
    {
        $products = Product::all();
        return view('requisitions.edit', compact('requisition', 'products'));
    }

    public function update(Request $request, Requisition $requisition)
    {
        $request->validate([
            'description' => 'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $requisition->update([
            'description' => $request->description,
            'status' => 'pending',
        ]);

        $requisition->products()->detach();
        foreach ($request->products as $product) {
            $requisition->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition updated successfully.');
    }

    public function destroy(Requisition $requisition)
    {
        $requisition->delete();
        return redirect()->route('requisitions.index')->with('success', 'Requisition deleted successfully.');
    }

    public function approve(Requisition $requisition)
    {
        $requisition->update(['status' => 'approved']);
        return redirect()->route('requisitions.index')->with('success', 'Requisition approved successfully.');
    }
}
