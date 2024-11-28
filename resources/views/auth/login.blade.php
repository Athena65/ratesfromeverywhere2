@extends('layouts.app')

@section('title', __('messages.login'))

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('messages.password') }}</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.login') }}</button>
                        </form>
                        <div class="text-center mt-3">
                            <p class="mb-0">{{ __('messages.no_account') }} <a href="{{ route('register') }}" class="text-primary fw-bold">{{ __('messages.register') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hata Mesajı -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <strong>{{ __('messages.error') }}</strong> {{ __('messages.fix_issues') }}
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection
