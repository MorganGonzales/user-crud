<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withoutTrashed()->latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $userData = $request->all();

        if ($request->hasFile('photo')) {
            $imageName = $request->username . '.' . $request->photo->extension();
            $userData['photo'] = Storage::url($request->file('photo')->storeAs('avatars', $imageName, 'public'));
        }

        $userData['password'] = Hash::make($request->password);

        User::create($userData);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $userData = $request->all();

        if ($request->hasFile('photo')) {
            $imageName = $request->username . '.' . $request->photo->extension();
            $userData['photo'] = Storage::url($request->file('photo')->storeAs('avatars', $imageName, 'public'));
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.trashed')->with('success', 'User permanently deleted successfully.');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->latest()->get();

        return view('users.trashed', compact('users'));
    }

    public function delete(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User temporarily deleted successfully.');
    }

    public function restore(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
    }
}
