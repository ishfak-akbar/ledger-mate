<x-guest-layout>
    <div class="transaction-details-container">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="transaction-details-card">
                <!-- Header -->
                <div class="transaction-header">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="transaction-title">Transaction #{{ $transaction->id }}</h1>
                            <div class="flex items-center mt-2 space-x-4">
                                <div class="date-badge">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $transaction->date->format('F j, Y') }}
                                </div>
                                <div class="payment-badge payment-{{ $transaction->payment_method }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                </div>
                                <div class="status-badge {{ $transaction->due_amount > 0 ? 'pending' : 'paid' }}">
                                    {{ $transaction->due_amount > 0 ? 'Pending' : 'Paid' }}
                                </div>
                            </div>
                        </div>
                        <div class="print-btn" onclick="window.print()">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print
                        </div>
                    </div>
                </div>

                <div class="amount-summary">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 amount-card total">
                            <div class="amount-label">Total Amount</div>
                            <div class="amount-value">Tk. {{ number_format($transaction->total_amount, 2) }}</div>
                        </div>
                        
                        <div class="flex-1 amount-card paid">
                            <div class="amount-label">Paid Amount</div>
                            <div class="amount-value">Tk. {{ number_format($transaction->paid_amount, 2) }}</div>
                        </div>
                        
                        <div class="flex-1 amount-card due {{ $transaction->due_amount > 0 ? 'pending' : 'paid' }}">
                            <div class="amount-label">Due Amount</div>
                            <div class="amount-value">Tk. {{ number_format($transaction->due_amount, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="details-grid">
                    <div class="details-section">
                        <h3 class="section-title">Transaction Information</h3>
                        
                        <div class="info-item">
                            <div class="info-label">Transaction ID</div>
                            <div class="info-value">#{{ $transaction->id }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Date & Time</div>
                            <div class="info-value">
                                {{ $transaction->date->format('F j, Y') }}
                                <div class="text-sm text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Payment Method</div>
                            <div class="info-value">
                                <span class="payment-badge payment-{{ $transaction->payment_method }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($transaction->description)
                        <div class="info-item">
                            <div class="info-label">Description</div>
                            <div class="info-value">{{ $transaction->description }}</div>
                        </div>
                        @endif
                        
                        @if($transaction->note)
                        <div class="info-item">
                            <div class="info-label">Note</div>
                            <div class="info-value">{{ $transaction->note }}</div>
                        </div>
                        @endif
                    </div>

                    <div class="details-section">
                        <h3 class="section-title">Customer Information</h3>
                        
                        @if($transaction->customer_name)
                        <div class="info-item">
                            <div class="info-label">Customer Name</div>
                            <div class="info-value">{{ $transaction->customer_name }}</div>
                        </div>
                        @endif
                        
                        @if($transaction->customer_phone)
                        <div class="info-item">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">{{ $transaction->customer_phone }}</div>
                        </div>
                        @endif
                        
                        @if($transaction->customer_address)
                        <div class="info-item">
                            <div class="info-label">Address</div>
                            <div class="info-value whitespace-pre-line">{{ $transaction->customer_address }}</div>
                        </div>
                        @endif
                        
                        <div class="info-item">
                            <div class="info-label">Shop</div>
                            <div class="info-value">{{ $shop->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('transactions.index', $shop) }}" class="cancel-btn">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transaction-details-container {
            padding: 2rem 0;
            background: #f9fafb;
            min-height: calc(100vh - 64px);
        }

        .transaction-details-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
            overflow: hidden;
        }

        .transaction-header {
            padding: 2rem;
            background: linear-gradient(135deg, #fef2f2 0%, #fff5f5 100%);
            border-bottom: 1px solid #fee2e2;
        }

        .transaction-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
        }

        .date-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: white;
            color: #374151;
            font-weight: 500;
            border-radius: 9999px;
            font-size: 0.875rem;
            border: 1px solid #e5e7eb;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 9999px;
        }

        .status-badge.paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: white;
            color: #374151;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s;
        }

        .print-btn:hover {
            background: #f3f4f6;
        }

        /* Amount Summary */
        .amount-summary {
            padding: 2rem;
            background: #fafafa;
            border-bottom: 1px solid #e5e7eb;
        }

        .amount-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #e5e7eb;
            flex: 1;
        }

        .amount-card.total {
            border-top: 4px solid #3b82f6;
        }

        .amount-card.paid {
            border-top: 4px solid #10b981;
        }

        .amount-card.due.paid {
            border-top: 4px solid #10b981;
        }

        .amount-card.due.pending {
            border-top: 4px solid #f59e0b;
        }

        .amount-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .amount-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        @media (min-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .details-section {
            padding: 1.5rem;
            background: #fafafa;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            color: #111827;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            background: #fafafa;
        }

        .cancel-btn {
            padding: 0.75rem 1.5rem;
            background: #f3f4f6;
            color: #374151;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .cancel-btn:hover {
            background: #e5e7eb;
        }

        .edit-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: #3b82f6;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .edit-btn:hover {
            background: #2563eb;
        }

        .delete-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: #ef4444;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .delete-btn:hover {
            background: #dc2626;
        }

        .payment-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .payment-cash {
            background: #d1fae5;
            color: #065f46;
        }

        .payment-card {
            background: #dbeafe;
            color: #1e40af;
        }

        .payment-bank_transfer {
            background: #e0e7ff;
            color: #3730a3;
        }

        .payment-upi {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .payment-cheque {
            background: #fef3c7;
            color: #92400e;
        }

        @media (max-width: 768px) {
            .transaction-header,
            .amount-summary,
            .details-grid,
            .action-buttons {
                padding: 1rem;
            }
            
            .transaction-title {
                font-size: 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</x-guest-layout>