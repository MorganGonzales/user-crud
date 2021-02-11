<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserService implements UserServiceInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    public function rules($id = null): array
    {
        return [
            'prefixname' => 'string|max:255|nullable',
            'firstname' => 'required|string|max:255',
            'middlename' => 'string|max:255|nullable',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'string|max:255|nullable',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => ['string', 'min:8', 'confirmed', $id ? '' : 'required'],
            'photo' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function list(): LengthAwarePaginator
    {
        return User::withoutTrashed()->latest()->paginate(5);
    }

    public function store(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find(int $id): ?Model
    {
        return $this->model->withTrashed()->find($id);
    }

    public function update(int $id, array $attributes): bool
    {
        $user = $this->find($id);

        return $user->update($attributes);
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): ?bool
    {
        return $this->find($id)->delete();
    }

    public function listTrashed(): LengthAwarePaginator
    {
        return $this->model->onlyTrashed()->latest('deleted_at')->paginate(5);
    }

    public function restore($id): ?bool
    {
        return $this->find($id)->restore();
    }

    public function destroy($id): ?bool
    {
        return $this->find($id)->forceDelete();
    }

    public function hash(string $key): string
    {
        return Hash::make($key);
    }

    public function upload(UploadedFile $file): ?string
    {
        return Storage::url($file->storeAs('avatars', $file->getClientOriginalName(), 'public'));
    }
}
