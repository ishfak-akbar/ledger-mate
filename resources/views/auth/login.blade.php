@extends('layouts.login-layout')

@section('styles')
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family: 'Inter', sans-serif;
        /* background: linear-gradient(120deg, #ffe0e0, #ffcccc, #ffb3b3); */
        background: linear-gradient(120deg, #ffd4d4, #ffe8e8, #ffffff);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .center-bg {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 450px;         
        max-width: 85vw;
        pointer-events: none;
        z-index: 1;
        opacity: 0.4;         
    }

    .center-bg img {
        width: 100%;
        height: auto;
        border-radius: 20px;
        filter: drop-shadow(0 20px 50px rgba(220, 38, 78, 0.2));
    }

    .container, .card, .branding {
        position: relative;
        z-index: 10;
    }

    .container {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 50px;
        max-width: 1000px;
        width: 100%;
        align-items: center;
    }

    .branding {
        text-align: left;
    }

    .branding h1 {
        font-size: 52px;
        font-weight: 800;
        color: #dc2626;
        line-height: 1.1;
        margin-bottom: 12px;
    }

    .branding p {
        font-size: 17px;
        color: #555;
        line-height: 1.5;
        max-width: 400px;
        margin-bottom: 80px;
    }

    .features-grid {
        display: flex;
        gap: 15px; 
        margin-top: 60px;
    }

    .tiny-feature {
        background: rgba(220, 38, 78, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(220, 38, 78, 0.2);
        border-radius: 20px;
        padding: 12px 16px; 
        display: flex;
        align-items: center;
        gap: 10px;
        width: 200px; 
        min-height: 60px;
        box-shadow: 0 6px 18px rgba(220, 38, 78, 0.15);
        transition: all 0.3s ease;
    }

    .tiny-feature:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(220, 38, 78, 0.25);
        background: rgba(220, 38, 78, 0.18);
    }

    .tiny-icon {
        width: 36px;
        height: 36px; 
        background: #dc2626;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .tiny-icon svg {
        width: 20px; 
        height: 20px;
    }
    .tiny-icon img {
        width: 20px; 
        height: 20px;
    }

    .tiny-text {
        line-height: 1.3;
    }

    .tiny-text .font-semibold {
        font-size: 13px; 
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .tiny-text .text-xs {
        font-size: 10px; 
        color: #64748b;
        opacity: 0.9;
    }

    .card {
        background: rgba(255,255,255,0.5);
        padding: 55px 36px;
        border-radius: 28px;
        box-shadow: 0 20px 70px rgba(0,0,0,0.14);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.4);
        width: 385px;
    }

    .card-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .card-header h2 {
        font-size: 25px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .card-header p {
        font-size: 9px;
        font-weight: 300;
        color: #6b7280;
    }

    .input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14.5px;
        background: white;
        margin-bottom: 17px;
        transition: all 0.3s;
    }

    .input:focus {
        outline: none;
        border-color: #dc2626;
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.15);
    }

    .checkbox-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: -7px 3px 26px;
        font-size: 11px;
        color: #555;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 14px;
        height: 14px;
        accent-color: #dc2626;
        cursor: pointer;
    }
    .checkbox-line a {
        color: #dc2626;
        text-decoration: none;
    }

    .btn-signin {
    width: 100%;
    background: radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(220, 38, 38, 1) 100%);
    color: white;
    border: none;
    padding: 12px;
    margin-top: 14px;
    border-radius: 12px;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 12px 35px rgba(220, 38, 38, 0.4);
    transition: all 0.3s;
}

.btn-signin:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 34px rgba(220, 38, 38, 0.45);
    background: radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(200, 34, 34, 1) 100%);
}
    .btn-signin img{
        margin-right: 2px;
        height: 14px;
        width: 16px;
    }

    .signup-link {
        text-align: center;
        margin-top: 25px;
        font-size: 11px;
        color: #666;
    }

    .signup-link a {
        color: #dc2626;
        font-weight: 600;
        text-decoration: none;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
    <div class="center-bg">
        <img src="{{ asset('images/ledgermatee.png') }}" alt="LedgerMate">
    </div>

    <div class="container">
        <div class="branding">
            <h1>LedgerMate</h1>
            <p>Digital ledger for your shop — track customer & supplier dues automatically.</p>

            <div class="features-grid">
                <div class="tiny-feature">
                    <div class="tiny-icon">
                        <img src="{{ asset('images/dollar.png') }}" alt="Dollar">
                    </div>
                    <div class="tiny-text">
                        <div class="font-semibold">Track Dues</div>
                        <div class="text-xs">Auto balance tracking & reminders</div>
                    </div>
                </div>
                <div class="tiny-feature">
                    <div class="tiny-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="tiny-text">
                        <div class="font-semibold">Multi-Shop</div>
                        <div class="text-xs">Unified dashboard for all locations</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Welcome Back</h2>
                <p>Sign in to manage your shop transactions</p>
            </div>

            @if(session('status'))
                <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:10px;margin-bottom:20px;text-align:center;font-size:13.5px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Enter your email address"
                       class="input @error('email') border-red-500 @enderror" required autofocus>

                @error('email')
                    <p class="text-red-600 text-xs mt-1 mb-2">{{ $message }}</p>
                @enderror

                <input type="password" name="password" placeholder="Password"
                       class="input @error('password') border-red-500 @enderror" required>

                @error('password')
                    <p class="text-red-600 text-xs mt-1 mb-2">{{ $message }}</p>
                @enderror

                <div class="checkbox-line">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-signin">
                    <img src="{{ asset('images/login-128.png') }}" alt=""> Sign In
                </button>

                <div class="signup-link">
                    Don’t have an account? <a href="{{ route('register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
@endsection
