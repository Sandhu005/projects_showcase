@extends('layouts.auth')

@section('content')

{{-- <main class="auth-page">
    <section class="auth-card">
      <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>adminHMD</strong><small>Get a reset link for your account.</small></span></a>
      <div class="auth-visual"><img src="{{url('images/png/dasher-ui-bootstrap-5.jpg')}}" alt="adminHMD dashboard interface"></div>
      <form class="needs-validation" novalidate>
        <div class="mb-4">
          <p class="eyebrow mb-1">Secure Access</p>
          <h1 class="h3 mb-1">@section('form-name') Forgot Password @endsection</h1>
          <p class="text-muted mb-0">Get a reset link for your account.</p>
        </div>
        <div class="mb-4"><label class="form-label" for="forgotEmail">Email address</label><input class="form-control" id="forgotEmail" type="email" required><div class="invalid-feedback">Enter a valid email.</div></div>
        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-envelope-arrow-up" aria-hidden="true"></i> Send Reset Link</button>
      </form>
      <p class="text-muted small mt-3 mb-0">Check your inbox and spam folder after submitting.</p>
      <div class="auth-footer">Remembered it? <a href="{{route('login')}}">Back to login</a></div>
    </section>
  </main> --}}





<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

@endsection
