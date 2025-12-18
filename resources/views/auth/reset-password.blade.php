<x-guest-layout>
    <div style="
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
    ">
        <div style="
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        ">
            <!-- Header -->
            <div style="
                background: linear-gradient(90deg, #dc2626 0%, #b91c1c 100%);
                padding: 18px;
                text-align: center;
                color: white;
            ">
                <div style="font-size: 32px; font-weight: 700; margin-bottom: 6px;">
                    🔐
                </div>
                <h1 style="font-size: 24px; font-weight: 600; margin: 0;">
                    Reset Password
                </h1>
                <p style="font-size: 14px; opacity: 0.9; margin-top: 6px;">
                    Create a new password for your account
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.store') }}" style="padding: 40px;">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div style="margin-bottom: 22px;">
                    <label style="
                        display: block;
                        font-size: 14px;
                        font-weight: 500;
                        color: #374151;
                        margin-bottom: 6px;
                    ">
                        Email Address
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $request->email) }}"
                           required 
                           autofocus 
                           autocomplete="username"
                           style="
                               width: 100%;
                               padding: 12px 16px;
                               font-size: 14px;
                               border: 1px solid #d1d5db;
                               border-radius: 8px;
                               background: #f9fafb;
                               transition: all 0.3s;
                               box-sizing: border-box;
                           "
                           onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 3px rgba(220, 38, 38, 0.1)';"
                           onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                    >
                    @error('email')
                        <p style="color: #dc2626; font-size: 13px; margin-top: 6px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div style="margin-bottom: 22px;">
                    <label style="
                        display: block;
                        font-size: 14px;
                        font-weight: 500;
                        color: #374151;
                        margin-bottom: 6px;
                    ">
                        New Password
                    </label>
                    <div style="position: relative;">
                        <input type="password" 
                               name="password" 
                               id="password"
                               required 
                               autocomplete="new-password"
                               style="
                                   width: 100%;
                                   padding: 12px 16px;
                                   padding-right: 45px;
                                   font-size: 14px;
                                   border: 1px solid #d1d5db;
                                   border-radius: 8px;
                                   background: #f9fafb;
                                   transition: all 0.3s;
                                   box-sizing: border-box;
                               "
                               onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 3px rgba(220, 38, 38, 0.1)';"
                               onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                        >
                        <button type="button" 
                                onclick="togglePassword('password')"
                                style="
                                    position: absolute;
                                    right: 12px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    background: none;
                                    border: none;
                                    cursor: pointer;
                                    color: #6b7280;
                                    font-size: 18px;
                                    padding: 0;
                                    width: 24px;
                                    height: 24px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                ">
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <p style="color: #dc2626; font-size: 13px; margin-top: 6px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="
                        display: block;
                        font-size: 14px;
                        font-weight: 500;
                        color: #374151;
                        margin-bottom: 6px;
                    ">
                        Confirm Password
                    </label>
                    <div style="position: relative;">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               required 
                               autocomplete="new-password"
                               style="
                                   width: 100%;
                                   padding: 12px 16px;
                                   padding-right: 45px;
                                   font-size: 14px;
                                   border: 1px solid #d1d5db;
                                   border-radius: 8px;
                                   background: #f9fafb;
                                   transition: all 0.3s;
                                   box-sizing: border-box;
                               "
                               onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 3px rgba(220, 38, 38, 0.1)';"
                               onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"
                        >
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')"
                                style="
                                    position: absolute;
                                    right: 12px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    background: none;
                                    border: none;
                                    cursor: pointer;
                                    color: #6b7280;
                                    font-size: 18px;
                                    padding: 0;
                                    width: 24px;
                                    height: 24px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                ">
                            👁️
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p style="color: #dc2626; font-size: 13px; margin-top: 6px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                        style="
                            width: 100%;
                            padding: 14px;
                            font-size: 16px;
                            font-weight: 600;
                            color: white;
                            background: linear-gradient(90deg, #dc2626 0%, #b91c1c 100%);
                            border: none;
                            border-radius: 8px;
                            cursor: pointer;
                            transition: all 0.3s;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 8px;
                        "
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.3)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                >
                    🔄 Reset Password
                </button>

                <div style="
                    text-align: center;
                    margin-top: 22px;
                    padding-top: 15px;
                    border-top: 1px solid #e5e7eb;
                ">
                    <a href="{{ route('login') }}" 
                       style="
                           color: #dc2626;
                           text-decoration: none;
                           font-size: 14px;
                           font-weight: 500;
                           transition: color 0.3s;
                       "
                       onmouseover="this.style.textDecoration='underline';"
                       onmouseout="this.style.textDecoration='none';"
                    >
                        ← Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '👁️';
            } else {
                input.type = 'password';
                button.innerHTML = '👁️';
            }
        }

        //Password strength indicator
        document.getElementById('password')?.addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthIndicator = document.getElementById('password-strength');
            
            if (!strengthIndicator) {
                const indicator = document.createElement('div');
                indicator.id = 'password-strength';
                indicator.style.marginTop = '8px';
                indicator.style.fontSize = '12px';
                e.target.parentElement.parentElement.appendChild(indicator);
            }
            
            const indicator = document.getElementById('password-strength');
            let strength = 0;
            let color = '#dc2626';
            let text = 'Weak';
            
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength >= 3) {
                color = '#f59e0b';
                text = 'Medium';
            }
            if (strength >= 4) {
                color = '#10b981';
                text = 'Strong';
            }
            
            if (password.length > 0) {
                indicator.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="flex: 1; height: 4px; background: #e5e7eb; border-radius: 2px; overflow: hidden;">
                            <div style="width: ${strength * 25}%; height: 100%; background: ${color};"></div>
                        </div>
                        <span style="color: ${color}; font-weight: 500;">${text}</span>
                    </div>
                `;
            } else {
                indicator.innerHTML = '';
            }
        });
    </script>

    <style>
        @media (max-width: 480px) {
            div[style*="max-width: 440px"] {
                max-width: 100% !important;
                border-radius: 12px !important;
            }
            
            div[style*="padding: 40px"] {
                padding: 24px !important;
            }
            
            div[style*="padding: 32px"] {
                padding: 24px !important;
            }
            
            h1[style*="font-size: 24px"] {
                font-size: 20px !important;
            }
        }
    </style>
</x-guest-layout>