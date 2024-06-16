<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PPs = PurchaseRequest::when(request('search') ?? false, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->with('items')
            ->with('user')
            ->paginate(10)
            ->withQueryString();    
        
        $totalPPs = PurchaseRequest::count();

        return view('Requisitions.PP.PPembelian', [
            'PPs' => $PPs,
            'totalPPs' => $totalPPs,
        ]);
    }


    public function edit($id)
    {
        $PP = PurchaseRequest::with('items')->findOrFail($id);
        return view('Requisitions.PP.editPP', compact('PP'));
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

        $pp = PurchaseRequest::findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pp = PurchaseRequest::findOrFail($id);
        $pp->items()->delete();
        $pp->delete();
        Alert::success('success', 'PP berhasil dihapus.');
        return redirect()->route('PP.index')->with('success', 'pp deleted successfully.');
    }




    public function updateItem(Request $request, $id)
    {
        $item = PurchaseRequestItem::findOrFail($id);

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
        $pp = $item->purchaseRequest;
        $pp->jumlah_anggaran = $pp->items->sum('harga_satuan');
        $pp->save();
        Alert::success('Success', 'Item updated successfully.');
        return redirect()->route('PP.edit', $pp->id)->with('success', 'Item updated successfully.');
    }

    public function deleteItem($id)
    {
        $item = PurchaseRequestItem::findOrFail($id);
        $pp = $item->purchaseRequest;
        $item->delete();

        // Update total anggaran for pp
        $totalBudget = $pp->items->sum('harga_satuan') * $pp->items->sum('rencana_beli');
        $pp->jumlah_anggaran = $totalBudget;
        $pp->save();

        return redirect()->route('PP.edit', $pp->id)->with('success', 'Item deleted successfully.');
    }
    
    public function editItem($id)
    {
        $item = PurchaseRequestItem::findOrFail($id);
        return view('Requisitions.PP.editItemPP', compact('item'));
    }

    public function submitForReview($id)
    {
        $pp = PurchaseRequest::findOrFail($id);
        $pp->update(['status' => 'pending']);

        Alert ::success('Success', 'PP berhasil diajukan untuk review.');
        return redirect()->route('PP.index');
    }

    public function review(Request $request, $id)
    {
        $pp = PurchaseRequest::findOrFail($id);
        $userRole = auth()->user()->role; // Assuming you have roles for users

        $reviewStatus = $pp->review_status;
        $reviewStatus[$userRole] = $request->input('status');
        $pp->review_status = $reviewStatus;
        
        if ($pp->isApprovedByAll()) {
            $pp->status = 'approved';
        }

        $pp->save();

        return redirect()->route('PP.index')->with('success', 'PP review status updated.');
    }


}
