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
                background-color: #ffffff;
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
            }
            
            .logo {
                font-size: 60px;
                font-weight: 700;
                background: linear-gradient(90deg,rgba(220, 38, 38, 1) 60%, rgba(220, 38, 83, 1) 100%);
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
                margin-bottom: 80px;
                font-weight: 400;
                line-height: 1.4;
            }
            
            .question {
                margin-top: 120px;
                font-size: 20px;
                color: #1f2937;
                margin-bottom: 15px;
                font-weight: 400;
            }
            
            .buttons-container {
                display: flex;
                flex-direction: column;
                gap: 8px;
                max-width: 550px;
                margin: 0 auto;
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
                background: #ff4747;
                background: radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(220, 38, 38, 1) 100%);
                color: white;
                border: 2px solid transparent;
                background: 
                    radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(220, 38, 38, 1) 100%) padding-box,
                    radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(220, 38, 38, 1) 100%) border-box;
            }
            
            .btn-yes:hover {
                background-color: #b91c1c;
                /* border-color: #b91c1c; */
                border: 2px solid transparent;
                background: 
                    radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(220, 38, 38, 1) 100%) padding-box,
                    radial-gradient(circle, rgba(255, 71, 71, 1) 40%, rgba(220, 38, 38, 1) 100%) border-box;
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(220, 38, 38, 0.25);
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
            
            /* Header for logged-in users */
            .header {
                position: absolute;
                top: 32px;
                right: 32px;
            }
            
            .dashboard-btn {
                padding: 12px 24px;
                background-color: #dc2626;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                transition: background-color 0.3s ease;
            }
            
            .dashboard-btn:hover {
                background-color: #b91c1c;
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                .welcome-container {
                    max-width: 90%;
                    padding: 48px 32px;
                }
                
                .logo {
                    font-size: 52px;
                    margin-top: 0;
                }
                
                .slogan {
                    font-size: 20px;
                    margin-bottom: 64px;
                }
                
                .question {
                    font-size: 24px;
                    margin-bottom: 40px;
                }
                
                .buttons-container {
                    max-width: 400px;
                }
                
                .btn {
                    padding: 12px 32px;
                    font-size: 15px;
                }
            }
            
            @media (max-width: 480px) {
                .logo {
                    font-size: 44px;
                }
                
                .slogan {
                    font-size: 18px;
                    margin-bottom: 56px;
                }
                
                .question {
                    font-size: 20px;
                }
                
                .buttons-container {
                    max-width: 320px;
                }
                
                .btn {
                    padding: 11px 24px;
                    font-size: 14px;
                }
                
                .header {
                    top: 16px;
                    right: 16px;
                }
                
                .dashboard-btn {
                    padding: 10px 20px;
                    font-size: 13px;
                }
            }
        </style>
    </head>
    <body>
        <!-- Dashboard button for logged in users -->
        @auth
        <div class="header">
            <a href="{{ url('/dashboard') }}" class="dashboard-btn">Dashboard</a>
        </div>
        @endauth
        
        <div class="welcome-container">
            <h1 class="logo">LedgerMate</h1>
            <p class="slogan">Smart accounting made simple</p>
            
            <div class="question">Do you have an account?</div>
            
            <div class="buttons-container">
                <!-- Always show Login button -->
                <a href="{{ url('/login') }}" class="btn btn-yes">Yes, login to my account</a>
                
                <!-- Always show Register button -->
                <a href="{{ url('/register') }}" class="btn btn-no">No, create new account</a>
            </div>
        </div>

        <!-- Script to ensure buttons work -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add click handlers for buttons
                const loginBtn = document.querySelector('.btn-yes');
                const registerBtn = document.querySelector('.btn-no');
                
                if (loginBtn) {
                    loginBtn.addEventListener('click', function(e) {
                        console.log('Login button clicked');
                    });
                }
                
                if (registerBtn) {
                    registerBtn.addEventListener('click', function(e) {
                        console.log('Register button clicked');
                    });
                }
                
                // Fallback in case routes don't exist
                if (!loginBtn.getAttribute('href')) {
                    loginBtn.setAttribute('href', '#');
                    loginBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        alert('Login route not configured. Check your routes/web.php file.');
                    });
                }
                
                if (!registerBtn.getAttribute('href')) {
                    registerBtn.setAttribute('href', '#');
                    registerBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        alert('Register route not configured. Check your routes/web.php file.');
                    });
                }
            });
        </script>
        <footer style="
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            font-weight: 400;
        ">
            © 2025 LedgerMate | Smart Accounting Solutions
        </footer>
    </body>
</html>