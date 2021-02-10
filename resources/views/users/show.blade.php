@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="{{ asset($user->photo) }}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->fullname }} </h5>
                            <p class="card-text">User Name: {{ $user->username }}</p>
                            <p class="card-text">Email Address: {{ $user->email }}</p>
                            <p class="card-text"><small class="text-muted">Last updated {{$user->updated_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
