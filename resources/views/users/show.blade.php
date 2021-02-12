@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="{{ asset($user->photo) }}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title">{{ $user->username }} </h1>
                            <dl class="row">
                                @foreach($user->details as $detail)
                                <dt class="col-sm-3">{{ $detail->key }}</dt>
                                <dd class="col-sm-9">{{ $detail->value ?: 'N/A' }}</dd>
                                @endforeach
                            </dl>
{{--                            <div class="cart-text">--}}
{{--                                @foreach($user->details as $detail)--}}
{{--                                    <p>{{ $detail->key }}: {{ $detail->value ?: 'N/A' }}</p>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
