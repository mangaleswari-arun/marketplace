
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="text-center mb-2">
                        Create Account
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Join our marketplace
                    </p>

                    <form method="POST"
                          action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Full Name
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name">

                            @error('name')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

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
                                autocomplete="new-password">

                            @error('password')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required
                                autocomplete="new-password">
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Register
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}">
                            Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
