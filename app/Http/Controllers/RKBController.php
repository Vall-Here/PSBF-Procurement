<?php

namespace App\Http\Controllers;

use App\Models\RKB;

use App\Models\RKBItem;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use RealRashid\SweetAlert\Facades\Alert;

class RKBController extends Controller
{
    // Rute resource yang ada
    public function index()
    {
        $rkbs = RKB::when(request('search') ?? false, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->with('items')
            ->with('user')
            ->paginate(10)
            ->withQueryString();    
        
        $totalrkbs = RKB::count();

        return view('Requisitions.RKB.rkb', [
            'rkbs' => $rkbs,
            'totalrkbs' => $totalrkbs,
        ]);
    }

    public function create()
    {
        return view('Requisitions.RKB.addRkb');
    }

    // RKBController.php
    


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tahun_anggaran' => 'required|integer',
            'jumlah_anggaran' => 'required|numeric',
        ]);

        // Buat RKB baru
        $rkb = RKB::create([
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'jumlah_anggaran' => $validated['jumlah_anggaran'],
             // 'user_id' => auth()->id(),
            'user_id' =>1,
        ]);

        // Simpan item ke database
        $items = session()->get('rkb_items', []);
        foreach ($items as $item) {
            $item['rkb_id'] = $rkb->id_rkb;
            RKBItem::create($item);
        }

        // Hapus sesi item
        session()->forget('rkb_items');
        session()->forget('total_budget');

        Alert::success('Success', 'RKB berhasil dibuat.');
        return redirect()->route('rkbs.index')->with('success', 'RKB berhasil dibuat.');
    }

    public function edit($id)
    {
        $rkb = RKB::with('items')->findOrFail($id);
        return view('Requisitions.RKB.editRkb', compact('rkb'));
    }

    public function update(Request $request, $id)
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

        $rkb = RKB::findOrFail($id);
        $rkb->update([
            'tahun_anggaran' => $request->tahun_anggaran,
            'jumlah_anggaran' => $request->jumlah_anggaran,
        ]);

        // Check if items array exists and has values
        if (isset($request->items) && is_array($request->items) && isset($request->items['nama_barang'])) {

            $rkb->items()->delete();
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
        } else {

            Alert::error('Tidak ada perubahan');
            return redirect()->route('rkbs.index', $id)->with('error', 'No items provided.');
        }

        return redirect()->route('rkbs.index')->with('success', 'RKB berhasil diupdate.');
    }

    public function destroy($id)
    {
        $rkb = RKB::findOrFail($id);
        $rkb->items()->delete();
        $rkb->delete();
        // Alert::success('success', 'RKB berhasil dihapus.');
        return redirect()->route('rkbs.index')->with('success', 'RKB berhasil dihapus.');
    }

    public function updateItem(Request $request, $id)
    {
        $item = RKBItem::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string',
            'satuan' => 'required|string',
            'rencana_pakai' => 'required|integer',
            'rencana_beli' => 'required|integer',
            'mata_uang' => 'required|string',
            'harga_satuan' => 'required|numeric',
        ]);

        $item->update($request->all());

        // Update total anggaran for RKB
        $rkb = $item->rkb;
        $rkb->jumlah_anggaran = $rkb->items->sum('harga_satuan');
        $rkb->save();
        Alert::success('Success', 'Item updated successfully.');
        return redirect()->route('rkbs.edit', $rkb->id_rkb)->with('success', 'Item updated successfully.');
    }

    public function deleteItem($id)
    {
        $item = RKBItem::findOrFail($id);
        $rkb = $item->rkb;
        $item->delete();

        // Update total anggaran for RKB
        $rkb->jumlah_anggaran = $rkb->items->sum('harga_satuan');
        $rkb->save();

        return redirect()->route('rkbs.edit', $rkb->id_rkb)->with('success', 'Item deleted successfully.');
    }
    
    public function editItem($id)
    {
        $item = RKBItem::findOrFail($id);
        return view('Requisitions.RKB.editItem', compact('item'));
    }

    public function createPurchaseRequest($id)
    {
        $rkb = RKB::with('items')->findOrFail($id);

        // Cek apakah PurchaseRequest dengan rkb_id yang sama sudah ada
        $existingPurchaseRequest = PurchaseRequest::where('rkb_id', $rkb->id_rkb)->first();
        if ($existingPurchaseRequest) {
            Alert::error('Error', 'Permintaan Pembelian sudah dibuat untuk RKB ini.');
            return redirect()->route('rkbs.index')->with('error', 'RKB has already been forwarded to Purchase Request.');
        }

        $purchaseRequest = PurchaseRequest::create([
            'rkb_id' => $rkb->id_rkb,
            // 'user_id' => auth()->id(),
            'user_id' => 1,
            'tahun_anggaran' => $rkb->tahun_anggaran,
            'jumlah_anggaran' => $rkb->jumlah_anggaran,
        ]);

        foreach ($rkb->items as $item) {
            PurchaseRequestItem::create([
                'purchase_request_id' => $purchaseRequest->id,
                'nama_barang' => $item->nama_barang,
                'satuan' => $item->satuan,
                'rencana_pakai' => $item->rencana_pakai,
                'rencana_beli' => $item->rencana_beli,
                'mata_uang' => $item->mata_uang,
                'harga_satuan' => $item->harga_satuan,
                'keterangan' => $item->keterangan,
            ]);
        }

        Alert::success('Success', 'Permintaan Pembelian Telah dibuat berdasarkan RKB.');
        return redirect()->route('rkbs.index')->with('success', 'RKB has been forwarded to Purchase Request successfully.');
    }

   
    public function addItem()
    {
        return view('Requisitions.RKB.addItemRkb');
    }  

    public function deleteItemOnAdd($index)
    {
        $items = session()->get('rkb_items', []);
        
        // Hapus item di index yang ditentukan
        if (isset($items[$index])) {
            unset($items[$index]);  
            session()->put('rkb_items', array_values($items)); // Reindex array
        }

        // Perbarui jumlah anggaran di session
        $totalBudget = 0;
        foreach ($items as $item) {
            $totalBudget += $item['harga_satuan'] * $item['rencana_beli'];
        }
        session()->put('total_budget', $totalBudget);

        return redirect()->route('rkbs.create')->with('success', 'Item berhasil dihapus.');
    }

    public function storeItem(Request $request)
    {
        // Validasi input item
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'satuan' => 'required|string',
            'rencana_pakai' => 'required|integer',
            'rencana_beli' => 'required|integer',
            'mata_uang' => 'required|string',
            'harga_satuan' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan item ke session
        $items = session()->get('rkb_items', []);
        $items[] = $validated;
        session()->put('rkb_items', $items);

        
        $totalBudget = 0;
        foreach ($items as $item) {
            $totalBudget += $item['harga_satuan'] * $item['rencana_beli'];
        }
        session()->put('total_budget', $totalBudget);

        return redirect()->route('rkbs.create');
    }

    
}
