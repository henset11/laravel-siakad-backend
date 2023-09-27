<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTutorRequest;
use App\Http\Requests\UpdateTutorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TutorController extends Controller
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
            ->where('roles', 'tutor')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.tutor', ['type_menu' => 'tutor'], compact('users'));
    }

    public function create()
    {
        return view('pages.users.create-tutor', ['type_menu' => 'tutor']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTutorRequest $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'roles' => 'tutor',
            'phone' => $request['phone'],
            'address' => $request['address'],
            'status' => 'Aktif',
        ]);

        return redirect(route('tutor.index'))->with('success', 'Tutor Baru Berhasil Ditambahkan');
    }

    public function edit(User $tutor)
    {
        return view('pages.users.edit-tutor', ['type_menu' => 'tutor'])->with('tutor', $tutor);
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
    public function update(UpdateTutorRequest $request, User $tutor)
    {
        $validate = $request->validated();
        if (!empty($validate['password'])) {
            $validate['password'] = Hash::make($validate['password']);
        } else {
            unset($validate['password']);
        }

        $tutor->update($validate);
        return redirect(route('tutor.index'))->with('success', 'Edit Tutor Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $tutor)
    {
        $tutor->delete();
        return redirect(route('tutor.index'))->with('success', 'Hapus Tutor Berhasil');
    }
}
