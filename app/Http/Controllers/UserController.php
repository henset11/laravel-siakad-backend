<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
            ->where('roles', 'siswa')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.siswa', ['type_menu' => 'siswa'], compact('users'));
    }

    public function create()
    {
        return view('pages.users.create-siswa', ['type_menu' => 'siswa']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'roles' => 'siswa',
            'phone' => $request['phone'],
            'address' => $request['address'],
            'status' => 'Aktif',
        ]);

        return redirect(route('siswa.index'))->with('success', 'Siswa Baru Berhasil Ditambahkan');
    }

    public function edit(User $siswa)
    {
        return view('pages.users.edit-siswa', ['type_menu' => 'siswa'])->with('siswa', $siswa);
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
    public function update(UpdateUserRequest $request, User $siswa)
    {
        $validate = $request->validated();
        if (!empty($validate['password'])) {
            $validate['password'] = Hash::make($validate['password']);
        } else {
            unset($validate['password']);
        }

        $siswa->update($validate);
        return redirect(route('siswa.index'))->with('success', 'Edit Siswa Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $siswa)
    {
        $siswa->delete();
        return redirect(route('siswa.index'))->with('success', 'Hapus Siswa Berhasil');
    }
}
