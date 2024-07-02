<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $Vendors = Vendor::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->paginate(10);
        $totalVendors = Vendor::count();
        
        return view('vendor.Vendors', [
            'Vendors' => $Vendors,
            'totalVendors' => $totalVendors,

        ]);
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $Vendors->delete();
        return redirect()->route('Vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
