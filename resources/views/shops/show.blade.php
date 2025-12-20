<x-app-layout>
    <x-slot name="header">
        @php
            session(['current_shop' => $shop]);
        @endphp
        
        <div class="flex justify-between items-center py-2">
            <h2 class="text-xl font-bold text-gray-900 leading-tight">
                Shop Details: {{ $shop->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('shops.index') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 transition shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Shops
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition shadow-md">
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Toast Container -->
            <div
            id="toastContainer"
            style="
                position: fixed;
                top: 20px;
                right: 1rem;
                z-index: 50;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                width: 20rem;
                max-width: 100%;
            "
            ></div>


            <div class="shop-grid-container">
                {{-- Row 2: Statistics & Key Info (3-column layout on large screens) --}}
                <div class="grid-card-span-2 bg-white p-6 md:p-8">
                    <h3 class="section-title text-xl mb-6 text-red-600">Financial Summary</h3>
                    
                    @php
                        $totalAmount = $shop->transactions()->sum('total_amount');
                        $paidAmount = $shop->transactions()->sum('paid_amount');
                        $dueAmount = $shop->transactions()->sum('due_amount');
                        $totalTransactions = $shop->transactions()->count();
                    @endphp

                    {{-- Financial Stats --}}
                    <div class="stats-container">
                        <div class="stat-box stat-box-red">
                            <div class="stat-label">Total Transactions</div>
                            <div class="stat-value">{{ $totalTransactions }}</div>
                            <div class="stat-icon">📊</div>
                        </div>
                        <div class="stat-box stat-box-blue">
                            <div class="stat-label">Total Amount</div>
                            <div class="stat-value">Tk. {{ number_format($totalAmount, 2) }}</div>
                            <div class="stat-icon">💰</div>
                        </div>
                        <div class="stat-box stat-box-green">
                            <div class="stat-label">Amount Paid</div>
                            <div class="stat-value">Tk. {{ number_format($paidAmount, 2) }}</div>
                            <div class="stat-icon">✅</div>
                        </div>
                        <div class="stat-box stat-box-reddish">
                            <div class="stat-label">Total Due</div>
                            <div class="stat-value">Tk. {{ number_format($totalAmount - $paidAmount, 2) }}</div>
                            <div class="stat-icon">⏳</div>
                        </div>
                    </div>

                    <h3 class="section-title text-lg mb-4 mt-6">Core Information</h3>

                    <div class="shop-details-container-columns">
                        <div class="shop-card-columns">        
                            <div class="info-grid-columns">         
                                {{-- Owner --}}
                                <div class="info-item-col">
                                    <dt class="info-label-col">
                                        <span class="info-icon-col">👤</span>
                                        Owner
                                    </dt>
                                    <dd class="info-value-col">{{ $shop->user->name }}</dd>
                                </div>                         
                                {{-- Category --}}
                                <div class="info-item-col">
                                    <dt class="info-label-col">
                                        <span class="info-icon-col">🏷️</span>
                                        Category
                                    </dt>
                                    <dd class="info-value-col">
                                        <span class="info-badge-col category-{{ $shop->category }}">
                                            {{ ucfirst($shop->category) }}
                                        </span>
                                    </dd>
                                </div>

                                {{-- Address (Span Full Width Below) --}}
                                <div class="info-item-col">
                                    <dt class="info-label-col">
                                        <span class="info-icon-col">📍</span>
                                        Address
                                    </dt>
                                    <dd class="info-value-col">{{ $shop->address }}</dd>
                                </div>
                                
                                @if($shop->notes)
                                    <div class="info-note-block info-note-col-span">
                                        <dt class="info-label-col">
                                            <span class="info-icon-col">📝</span>
                                            Shop Note
                                        </dt>
                                        <dd class="info-note-value">{{ $shop->notes }}</dd>
                                    </div>
                                @endif
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="grid-card-span-1 p-6 md:p-8 bg-white border-l border-gray-100">
                    <h3 class="section-title" style="margin-top: 6px;">Quick Tools</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('transactions.create', $shop) }}" class="action-btn red-btn text-red-600 border-red-200" style="margin: 6px 0px;">
                           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Transaction
                        </a>
                        <a href="{{ route('transactions.index', $shop) }}" class="action-btn text-blue-600 hover:bg-blue-50 border-blue-200" style="margin: 12px 0px;">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            View Transactions
                        </a>
                        <a href="{{ route('supplier-transactions.index', $shop) }}" class="action-btn purple-btn"
                        style="
                                display: flex;
                                align-items: center;
                                width: 100%;
                                padding: 12px 16px;
                                font-weight: 600;
                                border-radius: 8px;
                                border: 1px solid #8b5cf6;
                                text-decoration: none;
                                transition: all 0.2s;
                                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                                color: #8b5cf6;
                                margin: 12px 0px;
                                cursor: pointer;
                        "><svg style="width: 20px; height: 20px; margin-right: 10px; color: #8b5cf6;" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Supplier Transactions
                        </a>
                        
                        <button onclick="openClearDueModal()" class="action-btn text-green-600 hover:bg-green-50 border-green-200" style="margin: 12px 0px; width: 100%; border: 1px solid; cursor: pointer;">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Clear Due Payment
                        </button>
                    </div>

                    <div class="bg-gray-50" style="margin-top: 5px; border-top: 1px solid #ddd;">
                        {{-- Payment Status Counts --}}
                        <div class="bg-white p-4 rounded-lg shadow-sm" style="border: 1px solid #ffc7c7; width: 100%; margin: 10px 0px;">
                            <h4 class="subsection-title-red">Payment Status</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Paid transactions:</span>
                                    <span class="font-bold text-green-600">{{ $shop->transactions()->where('due_amount', 0)->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Due transactions:</span>
                                    <span class="font-bold text-red-600">{{ $shop->transactions()->where('due_amount', '>', 0)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm" style="border: 1px solid #ffc7c7; width: 100%;">
                            <h4 class="subsection-title-red">Audit Trail</h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Shop ID:</span>
                                    <span class="font-mono text-gray-700">{{ $shop->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created:</span>
                                    <span class="text-gray-700">{{ $shop->created_at->format('M j, Y') }} ({{ $shop->created_at->diffForHumans() }})</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Updated:</span>
                                    <span class="text-gray-700">{{ $shop->updated_at->format('M j, Y') }} ({{ $shop->updated_at->diffForHumans() }})</span>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="openDeleteModal()" 
                                class="delete-shop-btn" style="margin: 12px 0px 5px; display: flex; align-items: center; gap: 2px; width: 100%; font-size: 13px;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Shop
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>  
    


    <!-- Clear Due Payment Modal -->
    <div id="clearDueModal" 
        class="hidden" 
        style="
            background: rgba(0, 0, 0, 0.6); 
            backdrop-filter: blur(8px); 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            z-index: 50;
            overflow-y: auto; 
            padding: 40px 10px; 
            justify-content: center;
            align-items: center;
        ">

        <div style="
            
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
            width: 100%; 
            max-width: 600px; 
            max-height: 90vh;
            overflow-y: auto;
            margin: auto; 
            position: relative;
            padding: 0; 
        ">
            
            <div style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 24px;
                border-bottom: 1px solid #e5e7eb;
                position: sticky; 
                top: 0;
                background-color: #ffffff;
                z-index: 10;
            ">
                <h3 style="
                    font-size: 1.25rem; 
                    font-weight: 700; 
                    color: #1f2937; 
                    margin: 0;
                ">Clear Due Payment</h3>
                <button onclick="closeClearDueModal()" style="
                    background: none;
                    border: none;
                    cursor: pointer;
                    color: #9ca3af; 
                    transition: color 0.2s;
                " onmouseover="this.style.color='#4b5563'" onmouseout="this.style.color='#9ca3af'">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div style="padding: 24px;">
                <form method="POST" action="{{ route('transactions.store', $shop) }}" id="clearDueForm">
                    @csrf
                    
                    <input type="hidden" name="transaction_type" value="due_clearance">
                    <input type="hidden" name="customer_name" id="modal_customer_name">
                    <input type="hidden" name="customer_phone" id="modal_customer_phone">
                    <input type="hidden" name="customer_address" id="modal_customer_address">
                    
                    <div id="searchStep" style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 8px;">Find Customer *</label>
                        <div style="position: relative;">
                            <div style="display: flex; gap: 8px;">
                                <input 
                                    type="text" 
                                    id="due_customer_search" 
                                    placeholder="Enter customer name or phone number"
                                    style="
                                        flex-grow: 1; 
                                        padding: 10px 12px; 
                                        border: 1px solid #d1d5db; 
                                        border-radius: 6px; 
                                        outline: none; 
                                        font-size: 0.875rem; 
                                        transition: border-color 0.2s, box-shadow 0.2s;
                                    "
                                    onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 1px #dc2626'"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                                >
                                <button type="button" onclick="searchDueCustomer()" style="
                                    padding: 10px 16px; 
                                    background-color: #dc2626; 
                                    color: #ffffff; 
                                    border: none;
                                    border-radius: 6px; 
                                    cursor: pointer;
                                    font-size: 0.875rem; 
                                    font-weight: 500; 
                                    transition: background-color 0.2s;
                                    display: flex; 
                                    align-items: center; 
                                    gap: 4px;
                                " onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Search
                                </button>
                            </div>
                            
                            <div id="dueCustomerResults" class="customer-results hidden" style="
                                position: absolute; 
                                top: 100%; 
                                left: 0; 
                                right: 0; 
                                background-color: #ffffff; 
                                border: 1px solid #e5e7eb; 
                                border-radius: 6px; 
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
                                margin-top: 4px; 
                                z-index: 20; 
                                max-height: 240px; 
                                overflow-y: auto;
                            ">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                    <span style="font-size: 0.875rem; font-weight: 500; color: #4b5563;">Select a customer</span>
                                    <button type="button" onclick="closeDueResults()" style="background: none; border: none; cursor: pointer; color: #9ca3af;" onmouseover="this.style.color='#4b5563'" onmouseout="this.style.color='#9ca3af'">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div id="dueCustomerList" style="padding: 4px;">
                                    </div>
                            </div>
                        </div>
                        <p style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">Search for customer by name or phone number</p>
                    </div>

                    <div id="detailsStep" class="hidden">
                        <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                            <h4 style="font-size: 0.875rem; font-weight: 600; color: #1e40af; margin-bottom: 12px; border-bottom: 1px solid #dbeafe; padding-bottom: 8px;">Selected Customer</h4>
                            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px;">
                                <div>
                                    <span style="font-size: 0.75rem; color: #3b82f6; display: block;">Name:</span>
                                    <p style="font-size: 0.875rem; font-weight: 600; color: #1e40af; margin: 0;" id="selected_customer_name"></p>
                                </div>
                                <div>
                                    <span style="font-size: 0.75rem; color: #3b82f6; display: block;">Phone:</span>
                                    <p style="font-size: 0.875rem; font-weight: 600; color: #1e40af; margin: 0;" id="selected_customer_phone"></p>
                                </div>
                                <div>
                                    <span style="font-size: 0.75rem; color: #3b82f6; display: block;">Address:</span>
                                    <p style="font-size: 0.875rem; font-weight: 600; color: #1e40af; margin: 0;" id="selected_customer_address"></p>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                            <h4 style="font-size: 0.875rem; font-weight: 600; color: #4b5563; margin-bottom: 12px;">Customer Financial Summary</h4>
                            
                            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px;">
                                <div style="text-align: center; background-color: #ffffff; padding: 12px; border-radius: 8px; border: 1px solid #d1d5db;">
                                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Total</div>
                                    <div style="font-size: 1.125rem; font-weight: 700; color: #10b981;" id="customer_total_amount">Tk.  0.00</div>
                                </div>
                                
                                <div style="text-align: center; background-color: #ffffff; padding: 12px; border-radius: 8px; border: 1px solid #d1d5db;">
                                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Paid</div>
                                    <div style="font-size: 1.125rem; font-weight: 700; color: #3b82f6;" id="customer_paid_amount">Tk.  0.00</div>
                                </div>
                                
                                <div style="text-align: center; background-color: #ffffff; padding: 12px; border-radius: 8px; border: 1px solid #d1d5db;">
                                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Due</div>
                                    <div style="font-size: 1.125rem; font-weight: 700; color: #dc2626;" id="customer_due_amount">Tk.  0.00</div>
                                </div>
                            </div>
                            <div id="smsContainer" style="display: none; margin-top: 17px;">
                                <button type="button" 
                                        onclick="sendSMSReminder()"
                                        style="
                                            width: 100%;
                                            padding: 8px 10px;
                                            background-color: #dc2626;
                                            color: white;
                                            border: none;
                                            border-radius: 6px;
                                            cursor: pointer;
                                            font-weight: 500;
                                            transition: background-color 0.2s;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            gap: 8px;
                                        "
                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                        onmouseout="this.style.backgroundColor='#dc2626'">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                    Send SMS Reminder
                                </button>
                                <p style="font-size: 11px; color: #6b7280; margin-top: 4px; text-align: center;">
                                    Sends an SMS to remind about pending dues
                                </p>
                            </div>
                        </div>

                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                            <h4 style="font-size: 0.875rem; font-weight: 600; color: #4b5563; margin-bottom: 12px;">Payment Details</h4>
                            
                            <div style="margin-bottom: 16px;">
                                <label for="clear_due_amount" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 4px;">
                                    Payment Amount *
                                    <span style="font-size: 0.75rem; color: #6b7280;">(Maximum: <span id="max_due_amount" style="font-weight: 600;">Tk.  0.00</span>)</span>
                                </label>
                                <div style="position: relative;">
                                    <div style="position: absolute; inset-block-start: 0; inset-inline-start: 0; padding-left: 12px; height: 100%; display: flex; align-items: center; pointer-events: none;">
                                        <span style="color: #6b7280; font-size: 0.875rem;">Tk. </span>
                                    </div>
                                    <input 
                                        type="number" 
                                        id="clear_due_amount" 
                                        name="paid_amount" 
                                        placeholder="0.00"
                                        step="0.01"
                                        min="0.01"
                                        max="0"
                                        style="
                                            padding: 10px 12px 10px 28px;
                                            width: 100%; 
                                            border: 1px solid #d1d5db; 
                                            border-radius: 6px; 
                                            outline: none; 
                                            font-size: 0.875rem;
                                            transition: border-color 0.2s, box-shadow 0.2s;
                                        "
                                        onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 1px #dc2626'"
                                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                                        required
                                        oninput="validatePaymentAmount()"
                                    >
                                </div>
                                <p style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;" id="amount_hint">Enter the amount being paid to clear due</p>
                            </div>

                            <div style="margin-bottom: 16px;">
                                <label for="clear_due_payment_method" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 4px;">Payment Method *</label>
                                <select 
                                    id="clear_due_payment_method" 
                                    name="payment_method" 
                                    style="
                                        width: 100%; 
                                        padding: 10px 12px; 
                                        border: 1px solid #d1d5db; 
                                        border-radius: 6px; 
                                        outline: none; 
                                        font-size: 0.875rem;
                                        transition: border-color 0.2s, box-shadow 0.2s;
                                    "
                                    onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 1px #dc2626'"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                                    required
                                >
                                    <option value="" disabled selected>Select payment method</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="upi">UPI</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>

                            <div>
                                <label for="clear_due_description" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 4px;">Description</label>
                                <textarea 
                                    id="clear_due_description" 
                                    name="description" 
                                    placeholder="(Optional)"
                                    rows="2"
                                    style="
                                        width: 100%; 
                                        padding: 10px 12px; 
                                        border: 1px solid #d1d5db; 
                                        border-radius: 6px; 
                                        outline: none; 
                                        font-size: 0.875rem;
                                        resize: vertical;
                                        transition: border-color 0.2s, box-shadow 0.2s;
                                    "
                                    onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 1px #dc2626'"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                                ></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
                        <input type="hidden" name="total_amount" id="total_amount_field" value="0">
                        <input type="hidden" name="due_amount" id="due_amount_field" value="0">
                        <input type="hidden" name="transaction_type" value="due_clearance">
                    </div>

                    <div style="
                        display: flex; 
                        justify-content: space-between; 
                        align-items: center;
                        padding: 16px 24px; 
                        border-top: 1px solid #e5e7eb;
                        position: sticky; /* Sticky footer for scrollable content */
                        bottom: 0;
                        background-color: #ffffff;
                        z-index: 10;
                        margin: 0 -24px -24px -24px; /* Counteract padding to make footer full width */
                        border-radius: 0 0 12px 12px; /* Match modal border radius */
                    ">
                        <button type="button" onclick="closeClearDueModal()" 
                                style="
                                    padding: 10px 16px; 
                                    background-color: #e5e7eb; 
                                    color: #374151; 
                                    border: none;
                                    border-radius: 6px; 
                                    cursor: pointer;
                                    font-size: 0.875rem; 
                                    font-weight: 500; 
                                    transition: background-color 0.2s;
                                " onmouseover="this.style.backgroundColor='#d1d5db'" onmouseout="this.style.backgroundColor='#e5e7eb'">
                            Cancel
                        </button>
                        
                        <div style="display: flex; gap: 12px;">
                            <button type="button" id="backButton" 
                                    onclick="goBackToSearch()"
                                    class="hidden"
                                    style="
                                        padding: 10px 16px; 
                                        background-color: #3b82f6; 
                                        color: #ffffff; 
                                        border: none;
                                        border-radius: 6px; 
                                        cursor: pointer;
                                        font-size: 0.875rem; 
                                        font-weight: 500; 
                                        transition: background-color 0.2s;
                                    " onmouseover="this.style.backgroundColor='#2563eb'" onmouseout="this.style.backgroundColor='#3b82f6'">
                                Back to Search
                            </button>
                            
                            <button type="submit" 
                                    id="clearDueSubmit"
                                    disabled
                                    style="
                                        padding: 10px 16px; 
                                        background-color: #10b981; /* Green for submit/success */
                                        color: #ffffff; 
                                        border: none;
                                        border-radius: 6px; 
                                        cursor: not-allowed; /* Visually indicate disabled state */
                                        font-size: 0.875rem; 
                                        font-weight: 500; 
                                        display: flex; 
                                        align-items: center; 
                                        gap: 8px;
                                        transition: background-color 0.2s;
                                    ">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Clear Due Payment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Delete Shop Modal -->
    <div id="deleteModal" class="hidden bg-opacity-50 overflow-y-auto h-full w-full z-50" style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); position: fixed; top: 0; left: 0; width: 100%; height: 100%; overflow-y: auto;">
        <div class="shadow-lg rounded-md bg-white"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 100%; max-width: 500px; margin: 0 auto; padding: 20px;">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-14 w-14 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2 text-center">Delete Shop</h3>
                <p class="text-sm text-gray-500 mb-4 text-center">
                    This action cannot be undone. All transactions associated with this shop will also be deleted.
                </p>
                <div class="mt-2">
                    <p class="text-sm text-gray-700 mb-2">
                        To confirm, please type the shop name: <span class="font-bold text-red-600">{{ $shop->name }}</span>
                    </p>
                    <input type="text" 
                           id="shopNameInput" 
                           placeholder="Enter shop name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           oninput="checkShopName()">
                    <p id="errorMessage" class="text-red-500 text-sm mt-1 hidden">Shop name doesn't match!</p>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <form id="deleteForm" action="{{ route('shops.destroy', $shop) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                id="deleteButton"
                                disabled
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Delete Shop
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <style>
        :root {
            --color-primary: #dc2626; 
        }
        .bg-red-600 { background-color: var(--color-primary); }
        .hover\:bg-red-700:hover { background-color: #b91c1c; }
        .text-red-600 { color: var(--color-primary); }
        .border-red-200 { border-color: #fecaca; }
        .bg-red-50 { background-color: #fef2f2; }
        .border-blue-200 { border-color: #bfdbfe; }
        .hover\:bg-blue-50:hover { background-color: #eff6ff; }
        .text-blue-600 { color: #2563eb; }
        .border-green-200 { border-color: #d1fae5; }
        .hover\:bg-green-50:hover { background-color: #ecfdf5; }
        .text-green-600 { color: #059669; }
        .border-yellow-200 { border-color: #fde68a; }
        .bg-yellow-50 { background-color: #fffbeb; }
        .text-yellow-700 { color: #b45309; }

        .category-label {
            font-size: 18px; 
            font-weight: 500;
            color: #fff;
        }

        .shop-grid-container {
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            border-radius: 12px; 
            overflow: hidden;
            background: #ffffff;
        }

        .grid-card-span-2 {
            width: 75%;
        }
        .grid-card-span-3 {
            width: 100%;
        }
        .grid-card-span-1 {
            width: 25%;
            margin-left: auto;
        }

      
        .section-title {
            font-weight: 600;
            color: #1f2937;
            padding-bottom: 8px; 
            border-bottom: 1px solid #ddd;
            margin-bottom: 14px; 
        }

       
        .subsection-title-red {
            font-size: 14px; 
            font-weight: 600;
            color: white;
            background-color: #dc2626;
            padding: 8px 12px; 
            border-radius: 4px 4px 0 0;
            margin: -12px -12px 12px -12px; 
        }

        
        .badge {
            display: inline-block;
            padding: 4px 12px; 
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge.retail { 
            background-color: #eff6ff; 
            color: #1e40af; 
            border: 1px solid #bfdbfe;
        }
        .badge.restaurant { 
            background-color: #fef2f2; 
            color: #991b1b; 
            border: 1px solid #fecaca;
        }
        .badge.grocery { 
            background-color: #ecfdf5; 
            color: #047857; 
            border: 1px solid #a7f3d0;
        }
        .badge.other { 
            background-color: #f3f4f6; 
            color: #374151; 
            border: 1px solid #d1d5db;
        }
        .badge.electronics { 
            background-color: #f5f3ff; 
            color: #5b21b6; 
            border: 1px solid #ddd6fe;
        }
        .badge.clothing { 
            background-color: #fdf2f8; 
            color: #9d174d; 
            border: 1px solid #fbcfe8;
        }
        .badge.hardware { 
            background-color: #fefce8; 
            color: #854d0e; 
            border: 1px solid #fde68a;
        }
        .badge.pharmacy { 
            background-color: #f0f9ff; 
            color: #0369a1; 
            border: 1px solid #bae6fd;
        }
        .badge.wholesale { 
            background-color: #f8fafc; 
            color: #334155; 
            border: 1px solid #cbd5e1;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px; 
            justify-content: center;
            margin-bottom: 24px; 
        }
        .stat-box {
            padding: 15px;
            border-radius: 8px; 
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 35%;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .stat-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-box-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: 1px solid #2563eb;
        }

        .stat-box-red {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: 1px solid #dc2626;
        }

        .stat-box-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: 1px solid #059669;
        }

        .stat-box-reddish {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            border: 1px solid #991b1b;
        }

        .stat-box-blue:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.25);
        }

        .stat-box-red:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.25);
        }

        .stat-box-green:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);
        }

        .stat-box-reddish:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            box-shadow: 0 6px 12px rgba(220, 38, 38, 0.25);
        }

        .stat-label {
            font-size: 16px; 
            font-weight: 500;
            margin-bottom: 8px; 
            opacity: 0.9;
        }

        .stat-value {
            font-size: 24px; 
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px; 
        }

        .stat-icon {
            font-size: 28px; 
            opacity: 0.9;
            position: absolute;
            bottom: 8px;
            right: 12px;
            z-index: 1;
        }

        .delete-shop-btn {
            border: 2px solid #ffb3b3;
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            color: #ff3333;
            background-color: #ffd6d6;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .delete-shop-btn:hover {
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .delete-shop-btn:active {
            transform: translateY(0);
        }

        .shop-details-container-columns {
            max-width: 900px; 
            margin: 20px auto; 
        }

        .shop-card-columns {
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
            padding: 14px;
        }

        .card-header-columns {
            font-size: 22px; 
            font-weight: 800; 
            color: #1f2937; 
            margin-bottom: 20px;
        }

        .info-grid-columns {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px; 
        }

        .info-item-col {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100%; 
        }

        .info-note-col-span {
            grid-column: span 3; 
        }
        
        .is-empty-spacer {
            display: none; 
        }
        
        @media (min-width: 600px) {
            .is-empty-spacer {
                display: flex;
            }
        }
        
        @media (max-width: 600px) {
            .info-grid-columns {
                grid-template-columns: 1fr 1fr;
            }
            .info-address-col-span {
                grid-column: span 2;
            }
            .is-empty-spacer {
                display: none;
            }
        }
        .info-label-col {
            font-size: 13px; 
            font-weight: 700; 
            color: #6b7280; 
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-icon-col {
            font-size: 14px; 
        }

        .info-value-col {
            font-size: 18px; 
            font-weight: 900; 
            color: #111827; 
            line-height: 1.3;
        }
        
        .info-address-text {
            font-size: 16px;
            font-weight: 700;
            white-space: pre-line;
        }

        .info-badge-col {
            display: inline-block;
            padding: 4px 12px; 
            font-size: 13px;
            font-weight: 800;
            border-radius: 9999px; 
            text-transform: uppercase;
            background-color: #dbeafe; 
            color: #1d4ed8;
        }
        
        .category-food {
            background-color: #fef3c7; 
            color: #d97706; 
        }
        .category-retail {
            background-color: #d1fae5; 
            color: #059669; 
        }
        .category-service {
            background-color: #fee2e2; 
            color: #dc2626; 
        }
        
        .info-note-block {
            padding: 10px 12px;
            background-color: #fff7f7;
            border-left: 5px solid #dc2626;
            border-radius: 4px;
        }

        .info-note-value {
            font-weight: 600; 
            color: #374151;
            font-style: italic;
            font-size: 15px;
            margin-top: 5px;
        }

        /* Action Buttons */
        .action-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 16px; 
            background: white;
            font-weight: 600;
            border-radius: 8px;
            border: 1px solid;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .action-btn.red-btn:hover{
            background-color: #fff0f0 ;
        }

        .purple-btn{
            background-color: white;
        }

        .action-btn.purple-btn:hover{
            background-color: #f6f2ff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .shop-grid-container {
                flex-direction: column;
                gap: 8px; 
            }
            
            .grid-card-span-2,
            .grid-card-span-1 {
                width: 100%;
            }
            
            .stat-box {
                width: 48%;
                min-height: 100px;
            }
            
            .stats-container {
                gap: 8px; 
            }
            
            .detail-row {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 8px 12px; 
            }
            
            .delete-shop-btn {
                margin-left: 8px;
                padding: 4px 8px;
                font-size: 11px;
            }
        }
        /* Toast Notification Styles */
        .toast {
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideIn 0.3s ease-out;
            margin-bottom: 8px;
            max-width: 100%;
        }

        .toast-success {
            background-color: #10b981;
            color: white;
            border-left: 4px solid #059669;
        }

        .toast-error {
            background-color: #ef4444;
            color: white;
            border-left: 4px solid #dc2626;
        }

        .toast-info {
            background-color: #3b82f6;
            color: white;
            border-left: 4px solid #2563eb;
        }

        .toast-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 4px;
            margin-left: 12px;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .toast-close:hover {
            opacity: 1;
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

    <script>
        function openClearDueModal() {
            console.log('Opening modal');
            const modal = document.getElementById('clearDueModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex'; 
            resetClearDueForm();
        }

        function closeClearDueModal() {
            console.log('Closing modal');
            const modal = document.getElementById('clearDueModal');
            modal.classList.add('hidden');
            modal.style.display = 'none'; 
        }

        function resetClearDueForm() {
            document.getElementById('due_customer_search').value = '';
            
            document.getElementById('searchStep').style.display = 'block';
            document.getElementById('detailsStep').style.display = 'none';
            
            document.getElementById('backButton').style.display = 'none';

            document.getElementById('clearDueSubmit').disabled = true;
            
            closeDueResults();
        }

        function goBackToSearch() {
            document.getElementById('searchStep').style.display = 'block';
            document.getElementById('detailsStep').style.display = 'none';
            document.getElementById('backButton').style.display = 'none';
            document.getElementById('clearDueSubmit').disabled = true;
        }

        function searchDueCustomer() {
            const searchTerm = document.getElementById('due_customer_search').value.trim();
            
            if (!searchTerm) {
                alert('Please enter a name or phone number to search');
                return;
            }
            
            //Show loading state
            const customerList = document.getElementById('dueCustomerList');
            customerList.innerHTML = '<div style="padding: 12px; text-align: center; color: #6b7280; font-size: 14px;">Searching...</div>';
            
            //Fetch customer data
            fetch(`/api/shops/{{ $shop->id }}/search-customers?query=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        customerList.innerHTML = '<div style="padding: 12px; text-align: center; color: #6b7280; font-size: 14px;">No customers found</div>';
                    } else {
                        let html = '';
                        data.forEach(customer => {
                            html += `
                                <div style="padding: 12px; border-bottom: 1px solid #f3f4f6; cursor: pointer; transition: background-color 0.2s;" 
                                    onmouseover="this.style.backgroundColor='#f9fafb'" 
                                    onmouseout="this.style.backgroundColor='transparent'"
                                    onclick="selectDueCustomer(${JSON.stringify(customer).replace(/"/g, '&quot;')})">
                                    <div style="font-size: 14px; font-weight: 600; color: #111827;">${customer.name || 'No Name'}</div>
                                    <div style="display: flex; justify-content: space-between; font-size: 12px; color: #6b7280; margin-top: 4px;">
                                        <span>${customer.phone || 'No Phone'}</span>
                                        <span>${customer.transaction_count} transaction(s)</span>
                                    </div>
                                    ${customer.address ? `<div style="font-size: 12px; color: #9ca3af; font-style: italic; margin-top: 4px;">${customer.address}</div>` : ''}
                                </div>
                            `;
                        });
                        customerList.innerHTML = html;
                    }
                    document.getElementById('dueCustomerResults').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    customerList.innerHTML = '<div style="padding: 12px; text-align: center; color: #ef4444; font-size: 14px;">Error loading customers</div>';
                });
        }

        async function selectDueCustomer(customer) {
            console.log('Selecting customer:', customer);
            
            document.getElementById('selected_customer_name').textContent = customer.name || 'Not provided';
            document.getElementById('selected_customer_phone').textContent = customer.phone || 'Not provided';
            document.getElementById('selected_customer_address').textContent = customer.address || 'Not provided';
            
            document.getElementById('modal_customer_name').value = customer.name || '';
            document.getElementById('modal_customer_phone').value = customer.phone || '';
            document.getElementById('modal_customer_address').value = customer.address || '';
            
            closeDueResults();
            
            await fetchCustomerFinancialSummary(customer.name, customer.phone);
            
            const smsContainer = document.getElementById('smsContainer');
            if (customer.phone && customer.phone !== 'Not provided') {
                smsContainer.style.display = 'block';
            } else {
                smsContainer.style.display = 'none';
            }
            
            document.getElementById('searchStep').style.display = 'none';
            document.getElementById('detailsStep').style.display = 'block';
            document.getElementById('backButton').style.display = 'block';
            document.getElementById('clearDueSubmit').disabled = false;
        }

        async function fetchCustomerFinancialSummary(customerName, customerPhone) {
            try {
                const response = await fetch(`/api/shops/{{ $shop->id }}/customer-summary?name=${encodeURIComponent(customerName)}&phone=${encodeURIComponent(customerPhone)}`);
                const summary = await response.json();
                
                console.log('Customer summary:', summary);
                
                const total = parseFloat(summary.total || 0);
                const paid = parseFloat(summary.paid || 0);
                const due = total - paid;
                
                document.getElementById('customer_total_amount').textContent = `Tk.  ${total.toFixed(2)}`;
                document.getElementById('customer_paid_amount').textContent = `Tk.  ${paid.toFixed(2)}`;
                document.getElementById('customer_due_amount').textContent = `Tk.  ${due.toFixed(2)}`;
                
                document.getElementById('clear_due_amount').max = due;
                document.getElementById('max_due_amount').textContent = `Tk.  ${due.toFixed(2)}`;
                
                document.getElementById('total_amount_field').value = 0;
                document.getElementById('due_amount_field').value = 0;
                
            } catch (error) {
                console.error('Error fetching customer summary:', error);
                document.getElementById('customer_total_amount').textContent = 'Tk.  0.00';
                document.getElementById('customer_paid_amount').textContent = 'Tk.  0.00';
                document.getElementById('customer_due_amount').textContent = 'Tk.  0.00';
                document.getElementById('max_due_amount').textContent = 'Tk.  0.00';
            }
        }

        function validatePaymentAmount() {
            const paymentAmount = parseFloat(document.getElementById('clear_due_amount').value) || 0;
            const maxDue = parseFloat(document.getElementById('clear_due_amount').max) || 0;
            const amountHint = document.getElementById('amount_hint');
            const submitButton = document.getElementById('clearDueSubmit');
            
            if (paymentAmount > maxDue) {
                amountHint.innerHTML = `<span style="color: #dc2626;">Payment amount cannot exceed due amount of Tk.  ${maxDue.toFixed(2)}</span>`;
                submitButton.disabled = true;
                submitButton.style.backgroundColor = '#9ca3af';
                submitButton.style.cursor = 'not-allowed';
            } else if (paymentAmount <= 0) {
                amountHint.textContent = 'Please enter a valid payment amount (greater than 0)';
                submitButton.disabled = true;
                submitButton.style.backgroundColor = '#9ca3af';
                submitButton.style.cursor = 'not-allowed';
            } else {
                amountHint.textContent = `Clearing Tk.  ${paymentAmount.toFixed(2)} of Tk.  ${maxDue.toFixed(2)} due`;
                submitButton.disabled = false;
                submitButton.style.backgroundColor = '#10b981';
                submitButton.style.cursor = 'pointer';

                submitButton.onmouseover = function() { this.style.backgroundColor = '#059669'; };
                submitButton.onmouseout = function() { this.style.backgroundColor = '#10b981'; };
            }
        }

        function closeDueResults() {
            document.getElementById('dueCustomerResults').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up event listeners');

            const searchInput = document.getElementById('due_customer_search');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchDueCustomer();
                    }
                });
            }
            
            //Close modal when clicking outside of modal content
            const modal = document.getElementById('clearDueModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    console.log('Modal clicked, target:', e.target);
                    if (e.target === this) {
                        closeClearDueModal();
                    }
                });
            }
            
            //Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('clearDueModal');
                    if (modal && modal.style.display !== 'none') {
                        closeClearDueModal();
                    }
                }
            });
            
            //Form submission validation
            const clearDueForm = document.getElementById('clearDueForm');
            if (clearDueForm) {
                clearDueForm.addEventListener('submit', function(e) {
                    const customerName = document.getElementById('modal_customer_name').value;
                    const amount = document.getElementById('clear_due_amount').value;
                    const paymentMethod = document.getElementById('clear_due_payment_method').value;
                    const maxDue = parseFloat(document.getElementById('clear_due_amount').max) || 0;
                    const paymentAmount = parseFloat(amount) || 0;
                    
                    if (!customerName) {
                        e.preventDefault();
                        alert('Please select a customer first');
                        return;
                    }
                    
                    if (!amount || paymentAmount <= 0) {
                        e.preventDefault();
                        alert('Please enter a valid payment amount (greater than 0)');
                        return;
                    }
                    
                    if (paymentAmount > maxDue) {
                        e.preventDefault();
                        alert(`Payment amount cannot exceed due amount of Tk.  ${maxDue.toFixed(2)}`);
                        return;
                    }
                    
                    if (!paymentMethod) {
                        e.preventDefault();
                        alert('Please select a payment method');
                        return;
                    }
                    
                    const confirmationMessage = `Create due clearance transaction for ${customerName}?\n\nAmount: Tk.  ${paymentAmount.toFixed(2)}\nPayment Method: ${paymentMethod}`;
                    
                    if (!confirm(confirmationMessage)) {
                        e.preventDefault();
                    }
                });
            }
        });

        document.addEventListener('click', function(event) {
            const results = document.getElementById('dueCustomerResults');
            const searchContainer = document.querySelector('#clearDueModal .search-container');
            
            if (results && searchContainer && !searchContainer.contains(event.target)) {
                results.style.display = 'none';
            }
        });

        const paymentAmountInput = document.getElementById('clear_due_amount');
        if (paymentAmountInput) {
            paymentAmountInput.addEventListener('input', function() {
                validatePaymentAmount();
            });
        }

        const submitButton = document.getElementById('clearDueSubmit');
        if (submitButton && submitButton.disabled) {
            submitButton.style.backgroundColor = '#9ca3af';
            submitButton.style.cursor = 'not-allowed';
        }

        //Toast Notification Functions
        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toastContainer');
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            const messageEl = document.createElement('span');
            messageEl.textContent = message;
            
            const closeBtn = document.createElement('button');
            closeBtn.className = 'toast-close';
            closeBtn.innerHTML = '&times;';
            closeBtn.onclick = () => removeToast(toast);
            
            toast.appendChild(messageEl);
            toast.appendChild(closeBtn);
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                removeToast(toast);
            }, duration);
            
            return toast;
        }

        function removeToast(toast) {
            toast.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }

        //Check for session messages and show toasts
        function checkSessionMessages() {
            if(session('success'))
                showToast("{{ session('success') }}", 'success');
            endif
            
            if(session('error'))
                showToast("{{ session('error') }}", 'error');
            endif
        }

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = "{{ session('success') }}";
            const errorMessage = "{{ session('error') }}";
            
            if (successMessage) {
                showToast(successMessage, 'success');
            }
            
            if (errorMessage) {
                showToast(errorMessage, 'error');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            checkSessionMessages();
        });

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('shopNameInput').value = '';
            document.getElementById('deleteButton').disabled = true;
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function checkShopName() {
            const input = document.getElementById('shopNameInput').value;
            const shopName = "{{ $shop->name }}";
            const deleteButton = document.getElementById('deleteButton');
            const errorMessage = document.getElementById('errorMessage');
            
            if (input === shopName) {
                deleteButton.disabled = false;
                errorMessage.classList.add('hidden');
            } else {
                deleteButton.disabled = true;
                errorMessage.classList.remove('hidden');
            }
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
        function sendSMSReminder() {
            const customerPhoneElement = document.getElementById('selected_customer_phone');
            const customerNameElement = document.getElementById('selected_customer_name');
            const dueAmountElement = document.getElementById('customer_due_amount');
            
            //Get text content
            const customerPhone = customerPhoneElement ? customerPhoneElement.textContent.trim() : '';
            const customerName = customerNameElement ? customerNameElement.textContent.trim() : '';
            const dueAmount = dueAmountElement ? dueAmountElement.textContent.trim() : '';
            
            console.log('SMS Details:', { customerPhone, customerName, dueAmount });
            
            //Check if phone number is available
            if (!customerPhone || customerPhone === 'Not provided' || customerPhone === '') {
                alert('Customer phone number is not available. Cannot send SMS.');
                return;
            }
            
            //Clean and format the phone number
            let formattedPhone = customerPhone.replace(/\D/g, ''); 
            
            if (!formattedPhone.startsWith('+') && !formattedPhone.startsWith('00')) {
                if (formattedPhone.length === 11 && formattedPhone.startsWith('01')) {
                    formattedPhone = '+880' + formattedPhone.substring(1);
                } else if (formattedPhone.length === 10 && formattedPhone.startsWith('1')) {
                    formattedPhone = '+880' + formattedPhone;
                } else {
                    formattedPhone = '+' + formattedPhone;
                }
            }
            
            console.log('Formatted Phone:', formattedPhone);
            
            const message = `Hello${customerName && customerName !== 'Not provided' ? ' ' + customerName : ''}! You have pending dues of ${dueAmount}. Please make payment at your earliest convenience. - LedgerMate`;
            
            const smsLink = `sms:${formattedPhone}?body=${encodeURIComponent(message)}`;
            
            console.log('SMS Link:', smsLink);
            
            window.open(smsLink, '_blank');
            
            showToast(`SMS reminder opened for ${customerName || 'customer'}`, 'info', 3000);
        }
    </script>
</x-app-layout>