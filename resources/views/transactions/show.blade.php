<x-guest-layout>
    <div class="transaction-details-container" style="padding: 10px; background: #ffffff;">
        @if(session('success'))
            <div class="mb-6 p-4" style="background-color: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="transaction-details-card" style="
            background: white; 
            border: 1px solid #e5e7eb; 
            border-radius: 6px; 
            max-width: 600px;
            margin: 0 auto; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        ">
            <div style="
                padding: 15px 20px; 
                background: linear-gradient(90deg, #fef2f2 0%, #ffffff 100%); 
                border-bottom: 2px solid #dc2626; /* Highlight with Primary Color */
            ">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h1 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin: 0;">
                            RECEIPT - #{{ $transaction->id }}
                        </h1>
                        <div style="display: flex; align-items: center; margin-top: 5px; gap: 8px;">
                            <div class="date-badge" style="
                                display: inline-flex; 
                                align-items: center; 
                                padding: 4px 8px; 
                                background: #f9fafb; 
                                color: #374151; 
                                font-weight: 500; 
                                border-radius: 4px; 
                                font-size: 0.75rem;
                            ">
                                <svg style="width: 12px; height: 12px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $transaction->date->format('M j, Y') }}
                            </div>
                            <div class="status-badge {{ $transaction->due_amount > 0 ? 'pending' : 'paid' }}" style="
                                display: inline-block; 
                                padding: 4px 8px; 
                                font-size: 0.75rem; 
                                font-weight: 600; 
                                border-radius: 4px;
                                <?php echo $transaction->due_amount > 0 ? 'background: #fef3c7; color: #92400e;' : 'background: #d1fae5; color: #065f46;'; ?>
                            ">
                                {{ $transaction->due_amount > 0 ? 'Pending' : 'Paid' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="print-btn" onclick="window.print()" style="
                        display: inline-flex; 
                        align-items: center; 
                        padding: 8px 12px; 
                        background: #f3f4f6; 
                        color: #374151; 
                        font-weight: 500; 
                        border-radius: 6px; 
                        border: 1px solid #e5e7eb; 
                        cursor: pointer; 
                        font-size: 0.875rem;
                        transition: all 0.2s;
                    " onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f3f4f6'">
                        <svg style="width: 14px; height: 14px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Receipt
                    </div>
                </div>
            </div>

            <div style="
                padding: 15px 20px; 
                background: #fff; 
                border-bottom: 1px dashed #e5e7eb;
            ">
               <div style="display: flex; gap: 10px;">
                    <div style="flex: 1; padding: 10px; text-align: center; border: 1px solid #e5e7eb; border-radius: 4px;">
                        <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Total Amount</div>
                        <div style="font-size: 1.125rem; font-weight: 700; color: #dc2626;">
                            Tk. {{ number_format($transaction->total_amount, 2) }}
                        </div>
                    </div>
                    
                    <div style="flex: 1; padding: 10px; text-align: center; border: 1px solid #e5e7eb; border-radius: 4px;">
                        <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Paid Amount</div>
                        <div style="font-size: 1.125rem; font-weight: 700; color: #10b981;">
                            Tk. {{ number_format($transaction->paid_amount, 2) }}
                        </div>
                    </div>
                    
                    <div style="flex: 1; padding: 10px; text-align: center; border: 1px solid #e5e7eb; border-radius: 4px;">
                        <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Due Amount</div>
                        <div style="font-size: 1.125rem; font-weight: 700; <?php echo $transaction->due_amount > 0 ? 'color: #f59e0b;' : 'color: #10b981;'; ?>">
                            @if($transaction->total_amount == 0)
                                Tk. {{ number_format(0, 2) }}
                            @else
                                Tk. {{ number_format($transaction->total_amount - $transaction->paid_amount, 2) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 15px 20px;">
                <div style="display: grid; grid-template-columns: 1fr; gap: 10px; border: 1px solid #f3f4f6; border-radius: 4px; padding: 10px; background-color: #f9fafb;">
                    
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #dc2626; border-bottom: 1px solid #dc2626; padding-bottom: 5px; margin-bottom: 10px;">
                        Transaction & Customer Details
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 20px;">
                        
                        <div style="border-right: 1px solid #e5e7eb; padding-right: 10px;">
                            <div class="info-item" style="margin-bottom: 8px;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Trx. Date / Time</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500;">
                                    {{ $transaction->date->format('Y-m-d') }} ({{ $transaction->created_at->format('H:i') }})
                                </div>
                            </div>
                            <div class="info-item" style="margin-bottom: 8px;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Payment Method</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500;">
                                     <span class="payment-badge payment-{{ $transaction->payment_method }}" style="
                                        display: inline-block; 
                                        padding: 2px 6px; 
                                        font-size: 0.7rem; 
                                        font-weight: 600; 
                                        border-radius: 9999px;
                                        background: #e5e7eb;
                                        color: #374151;
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                    </span>
                                </div>
                            </div>
                            @if($transaction->description)
                            <div class="info-item" style="margin-bottom: 0;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Description</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500; word-break: break-all;">
                                    {{ $transaction->description }}
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div>
                            @if($transaction->customer_name)
                            <div class="info-item" style="margin-bottom: 8px;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Customer Name</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500;">
                                    {{ $transaction->customer_name }}
                                </div>
                            </div>
                            @endif
                            @if($transaction->customer_phone)
                            <div class="info-item" style="margin-bottom: 8px;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Phone</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500;">
                                    {{ $transaction->customer_phone }}
                                </div>
                            </div>
                            @endif
                            <div class="info-item" style="margin-bottom: 8px;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Shop Name</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500;">
                                    {{ $shop->name }}
                                </div>
                            </div>
                            @if($transaction->note)
                            <div class="info-item" style="margin-bottom: 0;">
                                <div style="font-size: 0.7rem; color: #6b7280;">Note</div>
                                <div style="font-size: 0.85rem; color: #111827; font-weight: 500; word-break: break-all;">
                                    {{ $transaction->note }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($transaction->customer_address)
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 10px;">
                        <div style="font-size: 0.7rem; color: #6b7280; margin-bottom: 3px;">Address</div>
                        <div style="font-size: 0.85rem; color: #111827; font-weight: 500; white-space: pre-line;">
                            {{ $transaction->customer_address }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div style="
                text-align: center; 
                padding: 10px 20px 15px; 
                border-top: 1px dashed #e5e7eb; 
                font-size: 0.7rem; 
                color: #6b7280;
            ">
                <p style="margin: 0;">Thank you for your purchase!</p>
                <p style="margin: 3px 0 0;">This is an electronically generated receipt.</p>
            </div>

            <div class="action-buttons-screen-only" style="
                display: flex;
                justify-content: flex-start;
                padding: 15px 20px;
                border-top: 1px solid #e5e7eb;
                background: #f9fafb;
            ">
                <a href="{{ route('transactions.index', $shop) }}" style="
                    padding: 8px 16px;
                    background: #dc2626;
                    color: #fff;
                    font-weight: 500;
                    border-radius: 6px;
                    text-decoration: none;
                    font-size: 0.875rem;
                    transition: background-color 0.2s;
                " onmouseover="this.style.backgroundColor='#9e0808'" onmouseout="this.style.backgroundColor='#dc2626'">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <style>
        .payment-cash { background: #d1fae5; color: #065f46; }
        .payment-card { background: #dbeafe; color: #1e40af; }
        .payment-bank_transfer { background: #e0e7ff; color: #3730a3; }
        .payment-upi { background: #f3e8ff; color: #6b21a8; }
        .payment-cheque { background: #fef3c7; color: #92400e; }

        .transaction-details-container {
            padding: 20px;
            background: #f9fafb;
        }

        @media print {
            body > *:not(.transaction-details-container) {
                display: none !important;
            }
            
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-size: 10pt; 
            }

            .transaction-details-container {
                padding: 0;
                margin: 0;
                width: 100%;
                max-width: 100%; 
            }

            .transaction-details-card {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                max-width: 100%;
                margin: 0;
            }

            .print-btn,
            .action-buttons-screen-only,
            .mb-6 { 
                display: none !important;
            }

            .transaction-details-card > div:nth-child(2) { 
                padding: 10px 15px !important;
                border-bottom: 2px solid #dc2626 !important;
            }
            .transaction-details-card > div:nth-child(2) h1 {
                font-size: 1.1rem !important;
                font-weight: 800 !important;
            }
            .transaction-details-card > div:nth-child(2) .date-badge,
            .transaction-details-card > div:nth-child(2) .status-badge {
                padding: 2px 5px !important;
                font-size: 0.6rem !important;
            }

            .transaction-details-card > div:nth-child(3) { 
                padding: 10px 15px !important;
            }
            .transaction-details-card > div:nth-child(3) > div {
                 gap: 5px !important;
            }
            .transaction-details-card > div:nth-child(3) > div > div {
                padding: 6px !important;
            }
            .transaction-details-card > div:nth-child(3) .amount-label {
                font-size: 0.65rem !important;
                margin-bottom: 2px !important;
            }
            .transaction-details-card > div:nth-child(3) .amount-value {
                font-size: 1rem !important;
            }
            
            .transaction-details-card > div:nth-child(4) { 
                padding: 10px 15px !important;
            }
             .transaction-details-card > div:nth-child(4) > div { 
                padding: 8px !important;
                gap: 8px 10px !important;
            }
            .transaction-details-card > div:nth-child(4) h3 {
                font-size: 0.85rem !important;
                padding-bottom: 3px !important;
                margin-bottom: 5px !important;
            }

            .transaction-details-card > div:nth-child(4) .info-item {
                margin-bottom: 6px !important;
            }

            .transaction-details-card > div:nth-child(4) .info-item > div:first-child { 
                font-size: 0.65rem !important;
                color: #374151 !important; 
                font-weight: 600 !important;
            }
            .transaction-details-card > div:nth-child(4) .info-item > div:last-child { 
                font-size: 0.75rem !important;
            }

            .transaction-details-card > div:nth-child(5) { 
                padding: 8px 15px 12px !important;
                font-size: 0.65rem !important;
            }
        }
    </style>
</x-guest-layout>