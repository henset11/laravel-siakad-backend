<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
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
            ->where('roles', 'karyawan')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.karyawan', ['type_menu' => 'karyawan'], compact('users'));
    }

    public function create()
    {
        return view('pages.users.create-karyawan', ['type_menu' => 'karyawan']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'roles' => 'karyawan',
            'phone' => $request['phone'],
            'address' => $request['address'],
            'status' => 'Aktif',
        ]);

        return redirect(route('karyawan.index'))->with('success', 'Karyawan Baru Berhasil Ditambahkan');
    }

    public function edit(User $karyawan)
    {
        return view('pages.users.edit-karyawan', ['type_menu' => 'karyawan'])->with('karyawan', $karyawan);
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
    public function update(UpdateKaryawanRequest $request, User $karyawan)
    {
        $validate = $request->validated();
        if (!empty($validate['password'])) {
            $validate['password'] = Hash::make($validate['password']);
        } else {
            unset($validate['password']);
        }

        $karyawan->update($validate);
        return redirect(route('karyawan.index'))->with('success', 'Edit Karyawan Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $karyawan)
    {
        $karyawan->delete();
        return redirect(route('karyawan.index'))->with('success', 'Hapus Karyawan Berhasil');
    }
}
