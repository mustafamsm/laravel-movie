<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RoleController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->input('perPage') ?: 5;
     
 dd(Role::with('permissions')->get());
        return Inertia::render('Roles/Index', [
            
            'roles' => Role::query()
            ->when(request()->input('search'),function($q,$search){
                    $q->where('title','like',"%{$search}%");
            })->when(request()->input('column'),function($q,$column){
                $q->orderBy($column,request()->input('direction','desc'));
            })->paginate($perPage)->withQueryString(),
            'filters' => request()->only(['search','perPage','column','direction'])
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
