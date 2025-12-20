<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LedgerMate - Smart Accounting</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            /* background: #fff7f7;  */
            background: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .welcome-container {
            width: 100%;
            max-width: 1000px;
            padding: 60px 40px;
            text-align: center;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        
        .logo {
            font-size: 60px;
            font-weight: 700;
            background: linear-gradient(90deg, #dc2626 60%, #e11d78 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 3px;
            letter-spacing: -1px;
            margin-top: -10px;
        }
        
        .slogan {
            font-size: 20px;
            color: #4b5563;
            margin-bottom: 24px;
            font-weight: 400;
            line-height: 1.4;
        }

        .intro-para {
            font-size: 16px;
            color: #374151;
            max-width: 700px;
            margin: 0 auto 80px;
            line-height: 1.4;
        }
        
        .question {
            margin-top: 60px;
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 500;
        }
        
        .buttons-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-width: 550px;
            margin: 0 auto 60px;
        }
        
        .btn {
            display: block;
            padding: 9px 30px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
            width: 100%;
        }
        
        .btn-yes {
            background: radial-gradient(circle, #ff4747 40%, #b80707 100%);
            color: white;
            border: 2px solid transparent;
        }
        
        .btn-yes:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(225, 38, 78, 0.25);
        }
        
        .btn-no {
            background-color: white;
            color: #dc2626;
            border: 2px solid #dc2626;
        }
        
        .btn-no:hover {
            background-color: #fef2f2;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.15);
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin-top: 1px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .feature-icon {
            width: 18px;
            height: 18px;
            color: #dc2626;
        }

        .feature-text {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .welcome-container { padding: 48px 32px; }
            .logo { font-size: 52px; }
            .slogan { font-size: 20px; margin-bottom: 20px; }
            .intro-para { font-size: 16px; margin-bottom: 60px; }
            .question { font-size: 22px; }
            .features { gap: 50px; }
            .feature-icon { width: 24px; height: 24px; }
        }

        @media (max-width: 480px) {
            .logo { font-size: 44px; }
            .intro-para { margin-bottom: 50px; }
            .question { font-size: 20px; }
            .features { flex-direction: column; gap: 24px; }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1 class="logo">LedgerMate</h1>
        <!-- <p class="slogan">Smart accounting made simple</p> -->

        <p class="intro-para">
            Manage your shop transactions, track customer dues, and generate receipts effortlessly. 
            Perfect for small businesses looking to go digital.
        </p>

        <div class="question">Do you have an account?</div>
        
        <div class="buttons-container">
            <a href="{{ url('/login') }}" class="btn btn-yes">Yes, login to my account</a>
            <a href="{{ url('/register') }}" class="btn btn-no">No, create new account</a>
        </div>

        <div class="features">
            <div class="feature-item">
                <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <div class="feature-text">Track Sales & Dues</div>
            </div>

            <div class="feature-item">
                <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <div class="feature-text">Print Receipts</div>
            </div>

            <div class="feature-item">
                <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <div class="feature-text">Manage Multiple Shops</div>
            </div>
        </div>
    </div>

    <footer>
        © 2025 LedgerMate | Smart Accounting Solutions
    </footer>
</body>
</html>