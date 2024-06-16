<?php

namespace App\Http\Controllers;

use App\Models\RushOrder;
use Illuminate\Http\Request;

class RushOrderController extends Controller
{   

    public function index()
    {
        $rushorders = RushOrder::when(request('search') ?? false, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->with('items')
            ->with('user')
            ->paginate(10)
            ->withQueryString();    
        
        $totalrushorders = RushOrder::count();

        return view('Requisitions.RO.RushOrder', [
            'rushorders' => $rushorders,
            'totalrushorders' => $totalrushorders,
        ]);
    }

    public function create()
    {
        return view('Requisitions.RO.addRO');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_anggaran' => 'required|integer',
            'jumlah_anggaran' => 'required|numeric',
            'items.nama_barang.*' => 'required|string',
            'items.satuan.*' => 'required|string',
            'items.rencana_pakai.*' => 'required|integer',
            'items.rencana_beli.*' => 'required|integer',
            'items.mata_uang.*' => 'required|string',
            'items.harga_satuan.*' => 'required|numeric',
        ]);

        $ro = RushOrder::create([
            'tahun_anggaran' => $request->tahun_anggaran,
            'jumlah_anggaran' => $request->jumlah_anggaran,
            // 'user_id' => auth()->id(),
            'user_id' =>1,
        ]);

        foreach ($request->items['nama_barang'] as $index => $nama_barang) {
            $ro->items()->create([
                'nama_barang' => $nama_barang,
                'satuan' => $request->items['satuan'][$index],
                'rencana_pakai' => $request->items['rencana_pakai'][$index],
                'rencana_beli' => $request->items['rencana_beli'][$index],
                'mata_uang' => $request->items['mata_uang'][$index],
                'harga_satuan' => $request->items['harga_satuan'][$index],
                'keterangan' => $request->items['keterangan'][$index] ?? null,
            ]);
        }

        return redirect()->route('rush_order.index')->with('success', 'RKB created successfully.');
    }

    public function edit($id)
    {
        $ro = RushOrder::with('items')->findOrFail($id);
        return view('rush_orders.edit', compact('ro'));
    }

    public function update(Request $request, $id)
    {
        $ro = RushOrder::findOrFail($id);
        $ro->update($request->all());

        return redirect()->route('rush_orders.index')->with('success', 'Rush Order updated successfully.');
    }

    public function submitForReview($id)
    {
        $ro = RushOrder::findOrFail($id);
        $ro->update(['status' => 'pending']);

        return redirect()->route('rush_orders.index')->with('success', 'Rush Order submitted for review.');
    }

    public function review(Request $request, $id)
    {
        $ro = RushOrder::findOrFail($id);
        $userRole = auth()->user()->role; // Assuming you have roles for users

        $reviewStatus = $ro->review_status;
        $reviewStatus[$userRole] = $request->input('status');
        $ro->review_status = $reviewStatus;

        if ($ro->isApprovedByAll()) {
            $ro->status = 'approved';
        }

        $ro->save();

        return redirect()->route('rush_orders.index')->with('success', 'Rush Order review status updated.');
    }
}
