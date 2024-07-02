<?php

namespace App\Http\Controllers;

use App\Models\RushOrder;
use Illuminate\Http\Request;
use App\Models\RushOrderItem;
use RealRashid\SweetAlert\Facades\Alert;

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
        // Validasi input
        $validated = $request->validate([
            'tahun_anggaran' => 'required|integer',
            'jumlah_anggaran' => 'required|numeric',
        ]);

        // Buat RO baru
        $ro = RushOrder::create([
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'jumlah_anggaran' => $validated['jumlah_anggaran'],
             'user_id' => auth()->id(),
            // 'user_id' =>1,
        ]);

        // Simpan item ke database
        $items = session()->get('rush_order_items', []);
        foreach ($items as $item) {
            $item['rush_orders_id'] = $ro->id;
            RushOrderItem::create($item);
        }

        // Hapus sesi item
        session()->forget('rush_order_items');
        session()->forget('total_budget');

        Alert::success('Success', 'rush_order berhasil dibuat.');
        return redirect()->route('rush_orders.index')->with('success', 'rush_order berhasil dibuat.');
    }

    public function edit($id)
    {
        $rush_orders = RushOrder::with('items')->findOrFail($id);
        return view('Requisitions.RO.editRO', compact('rush_orders'));
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

        $pp = RushOrder::findOrFail($id);
        $pp->update([
            'tahun_anggaran' => $request->tahun_anggaran,
            'jumlah_anggaran' => $request->jumlah_anggaran,
        ]);

        // Check if items array exists and has values
        if (isset($request->items) && is_array($request->items) && isset($request->items['nama_barang'])) {

            $pp->items()->delete();
            foreach ($request->items['nama_barang'] as $index => $nama_barang) {
                $pp->items()->create([
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

            Alert::error('Tidak ada perubahan.');
            return redirect()->route('PP.index', $id)->with('error', 'No items provided.');
        }

        return redirect()->route('PP.index')->with('success', 'RKB updated successfully.');
    }

    public function submitForReview($id)
    {
        $ro = RushOrder::findOrFail($id);
        $ro->update(['status' => 'pending']);

        Alert::success('Success', 'Rush Order submitted for review.');
        return redirect()->route('rush_orders.index');
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

    public function addItem()
    {
        return view('Requisitions.RO.addItemRO');
    }  

    public function deleteItemOnAdd($index)
    {
        $items = session()->get('rush_order_items', []);
        
        // Hapus item di index yang ditentukan
        if (isset($items[$index])) {
            unset($items[$index]);  
            session()->put('rush_order_items', array_values($items)); // Reindex array
        }

        // Perbarui jumlah anggaran di session
        $totalBudget = 0;
        foreach ($items as $item) {
            $totalBudget += $item['harga_satuan'] * $item['rencana_beli'];
        }
        session()->put('total_budget', $totalBudget);

        return redirect()->route('rush_orders.create')->with('success', 'Item berhasil dihapus.');
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

        
        $items = session()->get('rush_order_items', []);
        $items[] = $validated;
        session()->put('rush_order_items', $items);

        
        $totalBudget = 0;
        foreach ($items as $item) {
            $totalBudget += $item['harga_satuan'] * $item['rencana_beli'];
        }
        session()->put('total_budget', $totalBudget);

        return redirect()->route('rush_orders.create');
    }

    public function destroy($id)
    {
        $pp = RushOrder::findOrFail($id);
        $pp->items()->delete();
        $pp->delete();
        // Alert::success('success', 'Rush order berhasil dihapus.');
        return redirect()->route('rush_orders.index')->with('success', 'ro deleted successfully.');
    }


    public function editItem($id)
    {
        $item = RushOrderItem::findOrFail($id);
        return view('Requisitions.RO.editItemRO', compact('item'));
    }

    public function updateItem(Request $request, $id)
    {
        $item = RushOrderItem::findOrFail($id);

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
        $rush_orders = $item->rush_order;
        $totalBudget = $rush_orders->items->sum('harga_satuan') * $rush_orders->items->sum('rencana_beli');
        $rush_orders->jumlah_anggaran = $totalBudget;
        $rush_orders->save();
        Alert::success('Success', 'Item updated successfully.');
        return redirect()->route('rush_orders.edit', $rush_orders->id)->with('success', 'Item updated successfully.');
    }

    public function deleteItem($id)
    {
        $item = RushOrderItem::findOrFail($id);
        $rush_orders = $item->rush_order;
        $item->delete();

        // Update total anggaran for rush$rush_orders
        $rush_orders->jumlah_anggaran = $rush_orders->items->sum('harga_satuan');
        $rush_orders->save();

        return redirect()->route('rush_orders.edit', $rush_orders->id)->with('success', 'Item deleted successfully.');
    }
}
