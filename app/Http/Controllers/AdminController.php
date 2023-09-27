<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->select('id', 'name', 'email', 'phone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as created_at'), 'address', 'status')
            ->where('roles', 'admin')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.admin', ['type_menu' => 'admin'], compact('users'));
    }

    public function create()
    {
        return view('pages.users.create-admin', ['type_menu' => 'admin']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'roles' => 'admin',
            'phone' => $request['phone'],
            'address' => $request['address'],
            'status' => 'Aktif',
        ]);

        return redirect(route('admin.index'))->with('success', 'Admin Baru Berhasil Ditambahkan');
    }

    public function edit(User $admin)
    {
        return view('pages.users.edit-admin', ['type_menu' => 'admin'])->with('admin', $admin);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, User $admin)
    {
        $validate = $request->validated();
        if (!empty($validate['password'])) {
            $validate['password'] = Hash::make($validate['password']);
        } else {
            unset($validate['password']);
        }

        $admin->update($validate);
        return redirect(route('admin.index'))->with('success', 'Edit Admin Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect(route('admin.index'))->with('success', 'Hapus Admin Berhasil');
    }
}
