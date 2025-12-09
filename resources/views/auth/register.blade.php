@extends('layouts.login-layout')

@section('styles')
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(120deg, #ffd4d4, #ffe8e8, rgba(255,255,255,0.7), #ffd4d4 80%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    .container {
        display: grid;
        grid-template-columns: 1fr 375px;
        gap: 80px;
        max-width: 900px;
        width: 100%;
        align-items: center;
        position: relative;
        z-index: 10;
    }

    .left-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 28px;
    }

    .welcome-text h1 {
        font-size: 52px;
        font-weight: 800;
        color: #dc2626;
        line-height: 1.1;
    }

    .left-desc {
        text-align: center;
        font-size: 15px;
        color: #555;
        line-height: 1.4;
        max-width: 400px;
        margin-top: -18px;
        margin-bottom: 20px;
    }

    .left-desc span{
        color: #dc2626;
        
    }

    .images-row {
        display: flex;
        align-items: flex-start;
        gap: 40px;
        flex-wrap: wrap;
    }

    .image-block {
        background: rgba(220, 38, 78, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(220, 38, 78, 0.2);
        border-radius: 20px;
        padding: 12px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        max-width: 170px;
        aspect-ratio: 1/1;
        box-shadow: 0 6px 18px rgba(220, 38, 78, 0.15);
    }

    .side-image{
        height: 117px;
    }

    .side-image img {
        width: 100%;
        object-fit: contain;
        border-radius: 20px;
        filter: drop-shadow(0 15px 40px rgba(220, 38, 78, 0.16));
        transition: transform 0.4s ease;
    }

    .side-image img:hover {
        transform: translateY(-6px);
    }

    .image-caption {
        font-size: 12px;
        color: #555;
        text-align: center;
        line-height: 1.4;
        max-width: 160px;
    }

    .ledgermate-text h1 {
        font-size: 52px;
        font-weight: 800;
        color: #dc2626;
        line-height: 1.1;
        text-align: center;
        margin-top: 20px;
    }

    .card {
        background: rgba(255,255,255,0.55);
        padding: 55px 36px;
        border-radius: 28px;
        box-shadow: 0 20px 70px rgba(0,0,0,0.14);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.4);
        width: 375px;
    }

    .card-header h2 { 
        font-size: 24px; 
        font-weight: 700; 
        color: #1f2937; 
        text-align: center; 
        margin-bottom: 5px; }
    
    .card-header p { 
        font-size: 10px; 
        font-weight: 300; 
        color: #6b7280; 
        text-align: center; 
        margin-bottom: 35px; }

    .input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14.5px;
        background: white;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .input:focus { 
        outline: none; 
        border-color: #dc2626; 
        box-shadow: 0 0 0 4px rgba(220,38,38,0.14); 
    }

    .input-error { 
        color: #dc2626; 
        font-size: 11.5px; 
        margin-top: -10px; 
        margin-bottom: 10px; }

    .btn-register {
        width: 100%;
        background: radial-gradient(circle, rgba(255,71,71,1) 40%, rgba(220,38,38,1) 100%);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 14px;
        font-size: 16.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(220,38,38,0.35);
        transition: all 0.3s;
        margin-top: 15px;
    }
    .btn-register:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 16px 40px rgba(220,38,38,0.45); 
    }

    .login-link { 
        text-align: center;
        margin-top: 25px; 
        font-size: 11px; 
        color: #666; 
    }
    .login-link a { 
        color: #dc2626; 
        font-weight: 600; 
        text-decoration: none; 
    }
    .login-link a:hover { 
        font-weight: 700; 
    }

    @media (max-width: 1024px) {
        .container { grid-template-columns: 1fr; gap: 60px; text-align: center; }
        .left-content { align-items: center; }
        .images-row { justify-content: center; }
        .card { margin: 0 auto; }
    }

    @media (max-width: 640px) {
        .card { padding: 45px 28px; width: 340px; }
        .side-image img { max-width: 120px; }
        .welcome-text h1, .ledgermate-text h1 { font-size: 46px; }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="left-content">
        <div class="welcome-text">
            <h1>Welcome</h1>
        </div>
        <div class="left-desc">
            Step into the future of shop management with <span>LedgerMate!</span>
        </div>
        <div class="images-row">
            <div class="image-block">
                <div class="side-image">
                    <img src="{{ asset('images/oldLedger.png') }}" alt="Traditional Ledger">
                </div>
                <div class="image-caption">
                    Move beyond messy paper logs...
                </div>
            </div>

            <div class="image-block">
                <div class="side-image">
                    <img src="{{ asset('images/tabregi.png') }}" alt="Digital Ledger">
                </div>
                <div class="image-caption">
                    ...to effortless digital tracking.
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Create Account</h2>
            <p>Join LedgerMate and manage your shop smarter</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="Full Name"
                   class="input @error('name') border-red-500 @enderror" required autofocus>
            @error('name') <p class="input-error">{{ $message }}</p> @enderror

            <input type="email" name="email" value="{{ old('email') }}"
                   placeholder="Email Address"
                   class="input @error('email') border-red-500 @enderror" required>
            @error('email') <p class="input-error">{{ $message }}</p> @enderror

            <input type="password" name="password"
                   placeholder="Password"
                   class="input @error('password') border-red-500 @enderror" required>
            @error('password') <p class="input-error">{{ $message }}</p> @enderror

            <input type="password" name="password_confirmation"
                   placeholder="Confirm Password"
                   class="input" required>

            <button type="submit" class="btn-register">
                Create Account
            </button>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </form>
    </div>

</div>
@endsection