@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">{{ __('Add User') }}</h4>

                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="prefixname">{{ __('Prefix') }} <span class="text-muted">{{  __('(Optional)') }}</span></label>
                            @php
                                $prefixOptions = ['Mr', 'Mrs', 'Ms'];
                            @endphp
                            <select class="custom-select d-block w-100" id="prefixname" name="prefixname" value="{{ old('prefixname') }}">
                                <option value="" selected>Choose...</option>
                                @foreach($prefixOptions as $option)
                                    <option value="{{ $option }}" @if(old('prefixname') == $option) selected @endif>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname">{{ __('First name') }}</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname') }}" required>

                            @error('firstname')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname">{{ __('Last name') }}</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname') }}" required>

                            @error('lastname')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="middlename">{{ __('Middle name') }} <span class="text-muted ">{{ __('(Optional)') }}</span></label>
                            <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" value="{{ old('middlename') }}">

                            @error('middlename')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="suffixname">{{ __('Suffix') }} <span class="text-muted">{{ __('(Optional)') }}</span></label>
                            <input type="text" class="form-control @error('suffixname') is-invalid @enderror" id="suffixname" name="suffixname" value="{{ old('suffixname') }}">

                            @error('suffixname')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username">{{ __('User Name') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>

                                @error('username')
                                <div class="invalid-feedback" style="width: 100%;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>

                            @error('email')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="username">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">

                            @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3 input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo">
                                <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">{{ __('Upload Photo (Optional)') }}</label>
                            </div>

                            @error('photo')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('Add User') }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg btn-block">{{ __('Cancel') }}</a>
                </form>
            </div>
        </div>
    </div>

@endsection
