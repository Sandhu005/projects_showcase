@extends('layouts.auth')

@section('form-name') Login @endsection

@section('content')

{{-- <main class="auth-page">
  <section class="auth-card">
    <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>Admin Dashboard</strong><small>Sign in to your admin workspace.</small></span></a>
    <div class="auth-visual"><img src="{{url('images/png/dasher-ui-bootstrap-5.jpg')}}" alt="adminHMD dashboard interface"></div>

    <form class="needs-validation" novalidate action="{{route('login.attempt')}}" method="post">
      @csrf
      <div class="mb-4">
        <p class="eyebrow mb-1">Secure Access</p>
        <h1 class="h3 mb-1">@section('form-name') Login @endsection</h1>
        <p class="text-muted mb-0">Sign in to your admin workspace.</p>
      </div>

      @if(Session::get('error'))
      <span class="text-danger">
        {{Session::get('error')}}
      </span>
      @endif

      <div class="mb-3"><label class="form-label" for="loginEmail">Email address</label><input class="form-control" id="loginEmail" name="loginEmail" type="email" required>
        <div class="invalid-feedback">Enter a valid email.</div>
      </div>
      <div class="mb-3">
        <div class="d-flex justify-content-between"><label class="form-label" for="loginPassword">Password</label><a class="small fw-semibold" href="{{route('forgot-password.index')}}">Forgot?</a></div><input class="form-control" id="loginPassword" name="loginPassword" type="password" minlength="8" required>
        <div class="invalid-feedback">Password must be at least 8 characters.</div>
      </div>

      <!-- <div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="rememberMe"><label class="form-check-label" for="rememberMe">Remember me</label></div> -->

      <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Sign In</button>
    </form>
  </section>
</main> --}}



<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


@endsection