<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserServiceInterface;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->list();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $userData = $request->all();

        $userData['photo'] = $request->hasFile('photo') ? $this->userService->upload($request->file('photo')) : '';
        $userData['password'] = $this->userService->hash($request->password);

        $flashResult = $this->userService->store($userData)
            ? ['success' => 'User created successfully.']
            : ['error' => 'User creation failed.'];

        return redirect()->route('users.index')->with($flashResult);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, int $id)
    {
        $userData = $request->all();
        $userData['photo'] = $request->hasFile('photo') ? $this->userService->upload($request->file('photo')) : '';

        $flashResult = $this->userService->update($id, $userData)
            ? ['success' => 'User updated successfully.']
            : ['error' => 'User update failed.'];

        return redirect()->route('users.index')->with($flashResult);
    }

    public function destroy(int $id)
    {
        $flashResult = $this->userService->destroy($id)
            ? ['success' => 'User permanently deleted successfully.']
            : ['error' => 'User permanently deletion failed.'];

        return redirect()->route('users.trashed')->with($flashResult);
    }

    public function trashed()
    {
        $users = $this->userService->listTrashed();

        return view('users.trashed', compact('users'));
    }

    public function delete(int $id)
    {
        $flashResult = $this->userService->delete($id)
            ? ['success' => 'User temporarily deleted successfully.']
            : ['error' => 'User temporarily deletion failed.'];

        return redirect()->route('users.index')->with($flashResult);
    }

    public function restore(int $id)
    {
        $flashResult = $this->userService->restore($id)
            ? ['success' => 'User restored successfully.']
            : ['error' => 'User restoration failed.'];

        return redirect()->route('users.trashed')->with($flashResult);
    }
}
