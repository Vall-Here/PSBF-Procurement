<?php

namespace App\Http\Controllers;

use App\Models\RKB;
use Illuminate\Http\Request;

class RKBController extends Controller
{

    public function index()
    {
        $rkbs = RKB::when(request('search') ?? false, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })  ->with('items')
            ->with('user')
            ->paginate(10)
            ->withQueryString();    
        
            $totalrkbs = RKB::count();

        return view('Requisitions.rkb', [
            'rkbs' => $rkbs,
            'totalrkbs' => $totalrkbs,

        ]);
    }

    public function create()
    {
        return view('Requisitions.addRkb');
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

        $rkb = RKB::create([
            'tahun_anggaran' => $request->tahun_anggaran,
            'jumlah_anggaran' => $request->jumlah_anggaran,
            'user_id' => auth()->id(),
        ]);

        foreach ($request->items['nama_barang'] as $index => $nama_barang) {
            $rkb->items()->create([
                'nama_barang' => $nama_barang,
                'satuan' => $request->items['satuan'][$index],
                'rencana_pakai' => $request->items['rencana_pakai'][$index],
                'rencana_beli' => $request->items['rencana_beli'][$index],
                'mata_uang' => $request->items['mata_uang'][$index],
                'harga_satuan' => $request->items['harga_satuan'][$index],
                'keterangan' => $request->items['keterangan'][$index] ?? null,
            ]);
        }

        return redirect()->route('rkbs.index')->with('success', 'RKB created successfully.');
    }


}
