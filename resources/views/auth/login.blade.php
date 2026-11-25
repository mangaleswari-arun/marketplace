
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="text-center mb-2">
                        Welcome Back
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Login to your marketplace account
                    </p>

                    <form method="POST"
                          action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email">

                            @error('email')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                                autocomplete="current-password">
                        </div>

                        <div class="form-check mb-3">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="form-check-input"
                                id="remember">

                            <label class="form-check-label"
                                   for="remember">
                                Remember me
                            </label>
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Login
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Don't have an account?
                        <a href="{{ route('register') }}">
                            Register
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
