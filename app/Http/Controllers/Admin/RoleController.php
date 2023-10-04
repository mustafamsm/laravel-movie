<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Inertia\Inertia;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->input('perPage') ?: 5;
        $roles = Role::query()
            ->when(request()->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })->when(request()->input('column'), function ($q, $column) {
                $q->orderBy($column, request()->input('direction', 'desc'));
            })->with('permissions')->paginate($perPage)->withQueryString();
        $role = auth()->user()->roles->pluck('name')[0];
        $permissions = Permission::latest();
        if ($role != 'Super-Admin') {
            $permissions = Permission::whereNotIn('name', ['create permissions', 'show permissions', 'update permissions', 'delete permissions'])->latest();
            $roles->where('name', '<>', 'Super-Admin');
        }
        return Inertia::render('Roles/Index', [

            'roles' => $roles,
            'permissions' => $permissions->get(),
            'filters' => request()->only(['search', 'perPage', 'column', 'direction'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
