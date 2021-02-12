<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{
    public function rules($id = null): array;

    public function list(): LengthAwarePaginator;

    public function store(array $attributes): Model;

    public function find(int $id): ?Model;

    public function update(int $id, array $attributes): bool;

    public function delete(int $id): ?bool;

    public function listTrashed(): LengthAwarePaginator;

    public function restore(int $id): ?bool;

    public function destroy(int $id): ?bool;

    public function hash(string $key): string;

    public function upload(UploadedFile $file): ?string;

    public function saveDetails(User $user, array $details): int;
}
