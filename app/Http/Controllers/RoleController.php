<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data role
        $roles = Role::paginate(10);
        $totalRoles = Role::count();

        // Mencari role berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $roles = Role::where('name', 'like', "%{$search}%")->paginate(10);
        }

        return view('Roles.Index', compact('roles', 'totalRoles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('Roles.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    // RoleController.php

        public function update(Request $request, $id)
        {
            // Validasi
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id, // Mengabaikan role dengan ID saat ini
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            // Temukan role berdasarkan ID
            $role = Role::findOrFail($id);
            
            // Update nama role
            $role->name = $request->input('name');
            $role->save();

            // Sinkronisasi permissions
            $role->permissions()->sync($request->input('permissions', []));

            Alert::success('success', 'Roles berhasil diupdate.');
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        }



    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
