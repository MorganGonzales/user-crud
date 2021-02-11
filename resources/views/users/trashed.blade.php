@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('User List (Deleted)') }}</div>

                    <div class="card-body">
                        @if (count($users))
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">User Name</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->username }}</th>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm"><i
                                                    class="fas fa-user-check"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-user-slash"></i> Destroy
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $users->onEachSide(2)->links() !!}
                        @else
                            <h5 class="card-title">No deleted users</h5>
                            <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Go back to User List</a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
