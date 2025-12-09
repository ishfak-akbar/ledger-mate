<x-guest-layout>
    @section('styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #ffd4d4, #ffe8e8,#ffffff, rgba(255,255,255,0.7), #ffd4d4 80%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: rgba(255,255,255,0.55);
            padding: 60px 44px;
            border-radius: 32px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.16);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.5);
            width: 450px;
            max-width: 90vw;
            text-align: center;
        }

        .card h2 {
            font-size: 26px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.1;
            margin-bottom: 32px;
        }

        .input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            background: white;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .input:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 5px rgba(220,38,38,0.15);
        }

        .btn {
            width: 100%;
            background: radial-gradient(circle, rgba(255,71,71,1) 40%, rgba(220,38,38,1) 100%);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 12px 35px rgba(220,38,38,0.4);
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 45px rgba(220,38,38,0.5);
        }

        .back-link {
            margin-top: 26px;
            font-size: 13px;
        }

        .back-link a {
            color: #dc2626;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
    @endsection

    <div class="card">
        <h2>Forgot Password?</h2>
        <p>No worries. Just enter your email and we’ll send you a reset link.</p>

        <x-auth-session-status class="mb-6 text-sm text-green-600" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <input type="email" name="email" value="{{ old('email') }}" 
                   placeholder="Email Address" class="input @error('email') !border-red-500 @enderror" required autofocus>

            @error('email')
                <p class="text-red-600 text-sm -mt-3 mb-4 text-center">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn">
                Reset Password
            </button>

            <div class="back-link">
                <a href="{{ route('login') }}"><- Back to Sign In</a>
            </div>
        </form>
    </div>
</x-guest-layout>