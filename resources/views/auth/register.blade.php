@extends('layouts.app')

@section('title', __('messages.register'))

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">

                    <div class="card-body">
                        <!-- Hata Mesajları -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ __('messages.error') }}</strong> {{ __('messages.fix_issues') }}
                                <ul class="mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('messages.password') }}</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('messages.password_confirmation') }}</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.register') }}</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">
                            {{ __('messages.already_have_account') }}
                            <a href="{{ route('login') }}" class="btn btn-link fw-bold">{{ __('messages.login') }}</a>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
