<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Supplier Transaction #{{ $transaction->id }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --color-primary: #8b5cf6;
            --color-primary-dark: #7c3aed;
            --color-primary-light: #a78bfa;
            --color-success: #10b981;
            --color-danger: #dc2626;
            --color-warning: #f59e0b;
            --color-info: #3b82f6;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(120deg, #f0f0ff, #f8f7ff, #ffffff, #f0f0ff 80%);
            min-height: 100vh;
        }

        .transaction-container {
            min-height: 100vh;
            padding: 20px;
        }

        .header-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #dc2626;
        }

        .back-button-container {
            margin-bottom: 20px;
        }

        .back-header-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            padding: 10px 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 2px solid #dc2626;
        }

        .back-header-btn:hover {
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .back-icon {
            font-size: 20px;
            font-weight: 400;
            color: var(--color-primary);
            margin-right: 10px;
            line-height: 1;
        }

        .header-titles {
            display: flex;
            flex-direction: column;
        }

        .shop-name-title {
            font-size: 14px;
            font-weight: 400;
            color: var(--color-primary);
            line-height: 1.2;
        }

        .page-name-title {
            font-size: 18px;
            font-weight: 600;
            color: #1c1c1c;
            line-height: 1.2;
        }

        .transaction-id {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .transaction-id::before {
            content: "#";
            color: var(--color-primary);
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }

        .info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 25px;
            border: 2px solid #dc2626;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--color-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title svg {
            width: 20px;
            height: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 640px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #1f2937;
            padding: 8px 0;
        }

        .amount-display {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .total-amount {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
            border: 2px solid #d1d5db;
        }

        .paid-amount {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 2px solid #10b981;
        }

        .due-amount {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 2px solid #dc2626;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-due {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #dc2626;
        }

        .status-credit {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #3b82f6;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-purchase {
            background-color: #ede9fe;
            color: #5b21b6;
            border: 1px solid #8b5cf6;
        }

        .type-payment {
            background-color: #f0f9ff;
            color: #0369a1;
            border: 1px solid #0ea5e9;
        }

        .type-return {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .text-area-content {
            background: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border: 2px solid #dc2626;
            min-height: 60px;
            font-size: 14px;
            color: #374151;
            white-space: pre-wrap;
        }

        .empty-text {
            color: #9ca3af;
            font-style: italic;
            font-size: 14px;
        }

        .actions-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 25px;
            border: 2px solid #dc2626;
            margin-top: 20px;
        }

        .actions-title {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .edit-btn {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, var(--color-primary-dark) 0%, #6d28d9 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(139, 92, 246, 0.25);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.25);
        }

        .back-btn {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(107, 114, 128, 0.2);
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.25);
        }

        .timeline-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 25px;
            border: 2px solid #dc2626;
            margin-top: 20px;
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-created {
            background-color: #ede9fe;
            color: var(--color-primary);
        }

        .icon-updated {
            background-color: #f0f9ff;
            color: var(--color-info);
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .timeline-time {
            font-size: 12px;
            color: #6b7280;
        }

        .payment-method-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
        }

        /* Toast Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
            margin-bottom: 8px;
            color: white;
            border-left: 4px solid;
            min-width: 250px;
        }

        .toast-success {
            background-color: var(--color-success);
            border-color: #059669;
        }

        .toast-error {
            background-color: var(--color-danger);
            border-color: #b91c1c;
        }

        .toast-info {
            background-color: var(--color-info);
            border-color: #2563eb;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="transaction-container">
        <!-- Toast Container -->
        <div id="toastContainer" class="toast-container"></div>

        <div class="header-section">
            <div class="back-button-container">
                <a href="{{ route('shops.show', $shop) }}" class="back-header-btn">
                    <span class="back-icon">←</span>
                    <div class="header-titles">
                        <span class="shop-name-title">{{ $shop->name }}</span>
                        <span class="page-name-title">Supplier Transaction Details</span>
                    </div>
                </a>
            </div>

            <div class="transaction-id">
                <span>Transaction #{{ $transaction->id }}</span>
                <span class="type-badge type-{{ $transaction->transaction_type }}">
                    {{ ucfirst($transaction->transaction_type) }}
                </span>
                <span class="status-badge {{ $transaction->due_amount > 0 ? 'status-due' : 'status-paid' }}">
                    {{ $transaction->due_amount > 0 ? 'Due' : 'Paid' }}
                </span>
            </div>
        </div>

        <div class="main-content">
            <!-- Transaction Details Card -->
            <div class="info-card">
                <h3 class="card-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Transaction Details
                </h3>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date
                        </span>
                        <span class="info-value">{{ $transaction->date->format('F d, Y') }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Payment Method
                        </span>
                        <span class="info-value">
                            <span class="payment-method-badge">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</span>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                            Type
                        </span>
                        <span class="info-value">
                            <span class="type-badge type-{{ $transaction->transaction_type }}">
                                {{ ucfirst($transaction->transaction_type) }}
                            </span>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status
                        </span>
                        <span class="info-value">
                            <span class="status-badge {{ $transaction->due_amount > 0 ? 'status-due' : 'status-paid' }}">
                                {{ $transaction->due_amount > 0 ? 'Due' : 'Paid' }}
                            </span>
                        </span>
                    </div>
                </div>

                @if($transaction->description)
                    <div style="margin-top: 20px;">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Description
                        </span>
                        <div class="text-area-content">
                            {{ $transaction->description }}
                        </div>
                    </div>
                @endif

                @if($transaction->note)
                    <div style="margin-top: 20px;">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Note
                        </span>
                        <div class="text-area-content">
                            {{ $transaction->note }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Amount Details Card -->
            <div class="info-card">
                <h3 class="card-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Amount Details
                </h3>

                <div class="amount-display total-amount">
                    <span style="font-size: 14px; color: #6b7280;">Total Amount</span>
                    <span>Tk. {{ number_format($transaction->total_amount, 2) }}</span>
                </div>

                <div class="amount-display paid-amount">
                    <span style="font-size: 14px; color: #065f46;">Paid Amount</span>
                    <span>Tk. {{ number_format($transaction->paid_amount, 2) }}</span>
                </div>

                <div class="amount-display due-amount">
                    <span style="font-size: 14px; color: #991b1b;">Due Amount</span>
                    <span>Tk.  {{ number_format($transaction->due_amount, 2) }}</span>
                </div>

                @if($transaction->due_amount > 0)
                    <div style="margin-top: 20px; text-align: center;">
                        <button onclick="showPaymentModal()" class="action-btn edit-btn" style="width: 100%;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Make Payment
                        </button>
                        <p style="font-size: 12px; color: #6b7280; margin-top: 8px;">
                            Clear the due amount of Tk.  {{ number_format($transaction->due_amount, 2) }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Supplier Information Card -->
            <div class="info-card">
                <h3 class="card-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Supplier Information
                </h3>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Name
                        </span>
                        <span class="info-value">
                            {{ $transaction->supplier_name ?? 'Not specified' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Phone
                        </span>
                        <span class="info-value">
                            {{ $transaction->supplier_phone ?? 'Not specified' }}
                        </span>
                    </div>

                    <div class="info-item" style="grid-column: span 2;">
                        <span class="info-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Address
                        </span>
                        <span class="info-value">
                            {{ $transaction->supplier_address ?? 'Not specified' }}
                        </span>
                    </div>
                </div>

                @if($transaction->supplier_name)
                    <div style="margin-top: 20px;">
                        <a href="{{ route('supplier-transactions.index', ['shop' => $shop, 'supplier' => $transaction->supplier_name]) }}" 
                           class="action-btn back-btn" style="width: 100%; text-align: center;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            View All Transactions with {{ $transaction->supplier_name }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Timeline Card -->
            <div class="timeline-section">
                <h3 class="card-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Timeline
                </h3>

                <div class="timeline-item">
                    <div class="timeline-icon icon-created">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Transaction Created</div>
                        <div class="timeline-time">{{ $transaction->created_at->format('F d, Y h:i A') }}</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon icon-updated">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Last Updated</div>
                        <div class="timeline-time">{{ $transaction->updated_at->format('F d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="actions-section">
            <h3 class="actions-title">Actions</h3>
            <div class="action-buttons">
                <a href="{{ route('supplier-transactions.create', $shop) }}" class="action-btn edit-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Transaction
                </a>
                
                <a href="{{ route('supplier-transactions.index', $shop) }}" class="action-btn back-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    View All Transactions
                </a>

                <form id="deleteForm" action="{{ route('supplier-transactions.destroy', [$shop, $transaction]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete()" class="action-btn delete-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Transaction
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Make Payment Modal -->
    <div id="paymentModal" style="
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    ">
        <div style="
            background: white;
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        ">
            <h3 style="
                font-size: 20px;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 10px;
            ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Make Payment
            </h3>
            
            <p style="color: #6b7280; margin-bottom: 20px;">
                Pay due amount for Transaction #{{ $transaction->id }} to {{ $transaction->supplier_name }}
            </p>
            
            <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6b7280;">Due Amount:</span>
                    <span style="font-weight: 600; color: #dc2626;">Tk.  {{ number_format($transaction->due_amount, 2) }}</span>
                </div>
            </div>
            
            <form id="paymentForm" method="POST" action="{{ route('supplier-transactions.payment', [$shop, $transaction]) }}">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                        Payment Amount *
                    </label>
                    <input type="number" 
                           name="payment_amount" 
                           id="paymentAmount"
                           step="0.01"
                           min="0.01"
                           max="{{ $transaction->due_amount }}"
                           value="{{ $transaction->due_amount }}"
                           style="
                               width: 100%;
                               padding: 10px;
                               border: 1px solid #d1d5db;
                               border-radius: 6px;
                               font-size: 16px;
                               font-weight: 600;
                           "
                           oninput="validatePaymentAmount()"
                           required>
                    <p id="amountError" style="color: #dc2626; font-size: 12px; margin-top: 5px; display: none;">
                        Amount cannot exceed due amount
                    </p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                        Payment Method *
                    </label>
                    <select name="payment_method" 
                            style="
                                width: 100%;
                                padding: 10px;
                                border: 1px solid #d1d5db;
                                border-radius: 6px;
                                font-size: 14px;
                            "
                            required>
                        <option value="cash" selected>Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cheque">Cheque</option>
                        <option value="online">Online Payment</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                        Notes (Optional)
                    </label>
                    <textarea name="notes" 
                              rows="3"
                              placeholder="Add any notes about this payment..."
                              style="
                                  width: 100%;
                                  padding: 10px;
                                  border: 1px solid #d1d5db;
                                  border-radius: 6px;
                                  font-size: 14px;
                                  resize: vertical;
                              "></textarea>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" 
                            onclick="hidePaymentModal()"
                            style="
                                padding: 10px 20px;
                                background: #e5e7eb;
                                color: #374151;
                                border: none;
                                border-radius: 6px;
                                font-size: 14px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.2s;
                            "
                            onmouseover="this.style.backgroundColor='#d1d5db'"
                            onmouseout="this.style.backgroundColor='#e5e7eb'">
                        Cancel
                    </button>
                    <button type="submit"
                            id="submitPayment"
                            style="
                                padding: 10px 20px;
                                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                color: white;
                                border: none;
                                border-radius: 6px;
                                font-size: 14px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.2s;
                            "
                            onmouseover="this.style.backgroundColor='#059669'"
                            onmouseout="this.style.backgroundColor='#10b981'">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        //Toast Notification Functions
        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, duration);
        }

        if(session('success'))
            showToast("{{ session('success') }}", 'success');
        endif
        
        if(session('error'))
            showToast("{{ session('error') }}", 'error');
        endif

        function showPaymentModal() {
            document.getElementById('paymentModal').style.display = 'flex';
        }

        function hidePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        function validatePaymentAmount() {
            const amountInput = document.getElementById('paymentAmount');
            const maxAmount = parseFloat(amountInput.max);
            const currentAmount = parseFloat(amountInput.value) || 0;
            const errorElement = document.getElementById('amountError');
            const submitButton = document.getElementById('submitPayment');
            
            if (currentAmount > maxAmount) {
                errorElement.style.display = 'block';
                submitButton.disabled = true;
                submitButton.style.opacity = '0.5';
                submitButton.style.cursor = 'not-allowed';
            } else {
                errorElement.style.display = 'none';
                submitButton.disabled = false;
                submitButton.style.opacity = '1';
                submitButton.style.cursor = 'pointer';
            }
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this transaction? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }

        document.getElementById('paymentModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                hidePaymentModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hidePaymentModal();
            }
        });

        document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
            const amountInput = document.getElementById('paymentAmount');
            const maxAmount = parseFloat(amountInput.max);
            const currentAmount = parseFloat(amountInput.value) || 0;
            
            if (currentAmount > maxAmount) {
                e.preventDefault();
                alert('Payment amount cannot exceed due amount');
                return false;
            }
            
            if (!confirm(`Confirm payment of Tk.  ${currentAmount.toFixed(2)}?`)) {
                e.preventDefault();
                return false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            validatePaymentAmount();
        });
    </script>
</body>
</html>