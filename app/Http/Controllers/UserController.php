<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function  __construct()
    {
        $this->middleware('can:show users')->only('index');
        $this->middleware('can:create users')->only('store');
        $this->middleware('can:edit users')->only('edit', 'update');
        $this->middleware('can:delete users')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->input('perPage') ?: 5;
        $users = User::with('roles')
            ->when(request()->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when(request()->input('column'), function ($q, $column) {
                $q->orderBy($column, request()->input('direction', 'desc'));
            })
            ->when(!auth()->user()->hasRole('Super-Admin'), function ($query) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'Super-Admin');
                });
            });
        $roles = Role::all();

        return Inertia::render('Users/Index', [
            'users' => $users->with('roles')->paginate($perPage)->withQueryString(),

            'roles' => $roles,
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
        $request->validate([
                
                'name' => ['required', 'string', 'max:255'],
                'email' => "required|email|unique:users,email",
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => 'required_with:password|same:password',
                'role' => ['required'],
        ]);

        DB::beginTransaction();
        try{
            $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
                
            ]);
            $user->assignRole($request->role);
            DB::commit();
            return redirect()->back()->with('flash.banner', 'User created successfully');

        }catch(\Throwable $th){
            DB::rollback();
            return back()->with('flash.banner', 'semthing error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => "required|email|unique:users,email,{$id}",
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'sometimes|required_with:password|same:password',
            'role' => ['required'],


        ]);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->update($request->only('name', 'email'));
            $user->syncRoles($request->role);
            if ($request->password) {
                $user->update(['password' => bcrypt($request->password)]);
            }
            DB::commit();

            return redirect()->back()->with('flash.banner', 'User updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('flash.banner', 'semthing error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
