@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('User List (Active)') }} <a
                            class="btn btn-primary btn-sm float-right"
                            href="{{ route('users.create') }}"><i
                                class="fas fa-user-plus"></i> Add User</a></div>

                    <div class="card-body">
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
                                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-info btn-sm"
                                               href="{{ route('users.show', $user->id) }}"><i
                                                    class="fas fa-user-circle"></i> Show</a>
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('users.edit', $user->id) }}"><i
                                                    class="fas fa-user-edit"></i> Edit</a>

                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-user-minus"></i> Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! $users->onEachSide(2)->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
