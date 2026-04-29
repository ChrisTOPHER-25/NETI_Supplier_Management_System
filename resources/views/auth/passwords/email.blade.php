@extends('layouts.app')

@section('content')
<div class="row flex-grow-1 align-items-center justify-content-center">
    <div class="col-auto">
        <div class="card rounded-3 shadow-lg border-1 border-secondary-subtle" style="width: 30rem;">
            <div class="card-header rounded-top-3 text-white fw-bold fs-3" style="background: #020166;">
                Reset Password
            </div>
            <div class="card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col">
                            <div>
                                <label for="email" class="form-label">Email Address</label>
                            </div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            We’ll send a password reset link to this email to change your password.
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
