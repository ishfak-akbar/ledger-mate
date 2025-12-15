<x-guest-layout>
    <div class="transaction-container">
        <div class="back-button-container">
            <a href="{{ route('shops.show', $shop) }}" class="back-header-btn">
                <span class="back-icon"><</span>
                <div class="header-titles">
                    <span class="shop-name-title">{{ $shop->name }}</span>
                    <span class="page-name-title">Add Transaction</span>
                </div>
            </a>
        </div>

        <div class="form-wrapper">
            <div class="transaction-card">
                <form method="POST" action="{{ route('transactions.store', $shop) }}" id="transactionForm">
                    @csrf

                    <!-- Amount Row: Total, Paid, Due -->
                    <div class="amount-row">
                        <!-- Total Amount -->
                        <div class="form-group">
                            <label for="total_amount" class="form-label">Total *</label>
                            <input 
                                type="number" 
                                id="total_amount" 
                                name="total_amount" 
                                value="{{ old('total_amount') }}" 
                                placeholder="0.00"
                                step="0.01"
                                min="0.01"
                                class="form-input @error('total_amount') error-input @enderror" 
                                required
                                oninput="calculateDue()"
                            >
                            @error('total_amount')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Paid Amount -->
                        <div class="form-group">
                            <label for="paid_amount" class="form-label">Paid *</label>
                            <input 
                                type="number" 
                                id="paid_amount" 
                                name="paid_amount" 
                                value="{{ old('paid_amount') }}" 
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                class="form-input @error('paid_amount') error-input @enderror" 
                                required
                                oninput="calculateDue()"
                            >
                            @error('paid_amount')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Due Amount -->
                        <div class="form-group">
                            <label for="due_amount" class="form-label">Due</label>
                            <input 
                                type="number" 
                                id="due_amount" 
                                name="due_amount" 
                                value="{{ old('due_amount', 0) }}" 
                                class="form-input due-input" 
                                readonly
                            >
                        </div>
                    </div>

                    <div class="form-columns">
                        <div class="form-group">
                            <label for="payment_method" class="form-label">Payment Method *</label>
                            <select 
                                id="payment_method" 
                                name="payment_method" 
                                class="form-select @error('payment_method') error-input @enderror" 
                                required
                            >
                                <option value="" disabled selected>Select payment method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            </select>
                            @error('payment_method')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                placeholder="Enter transaction description"
                                class="form-textarea @error('description') error-input @enderror"
                                rows="3"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Search Section -->
                        <div class="customer-search-section">
                            <label class="form-label">Find Customer</label>
                            <div class="search-container">
                                <div class="search-input-group">
                                    <input 
                                        type="text" 
                                        id="customer_search" 
                                        placeholder="Enter name or phone number"
                                        class="search-input"
                                    >
                                    <button type="button" onclick="searchCustomer()" class="search-btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Find
                                    </button>
                                </div>
                                
                                <!-- Customer Results Dropdown -->
                                <div id="customerResults" class="customer-results hidden">
                                    <div class="results-header">
                                        <span>Select a customer</span>
                                        <button type="button" onclick="closeResults()" class="close-results">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="customerList" class="customer-list">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Name -->
                        <div class="form-group">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input 
                                type="text" 
                                id="customer_name" 
                                name="customer_name" 
                                value="{{ old('customer_name') }}" 
                                placeholder="Enter customer name"
                                class="form-input @error('customer_name') error-input @enderror"
                            >
                            @error('customer_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div class="form-group">
                            <label for="customer_phone" class="form-label">Customer Phone</label>
                            <input 
                                type="tel" 
                                id="customer_phone" 
                                name="customer_phone" 
                                value="{{ old('customer_phone') }}" 
                                placeholder="Enter phone number"
                                class="form-input @error('customer_phone') error-input @enderror"
                            >
                            @error('customer_phone')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Customer Address -->
                        <div class="form-group">
                            <label for="customer_address" class="form-label">Customer Address</label>
                            <textarea 
                                id="customer_address" 
                                name="customer_address" 
                                placeholder="Enter customer address"
                                class="form-textarea @error('customer_address') error-input @enderror"
                                rows="2"
                            >{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Note -->
                        <div class="form-group">
                            <label for="note" class="form-label">Note</label>
                            <textarea 
                                id="note" 
                                name="note" 
                                placeholder="Any additional note"
                                class="form-textarea @error('note') error-input @enderror"
                                rows="2"
                            >{{ old('note') }}</textarea>
                            @error('note')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Hidden Date Field -->
                    <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">

                    <!-- Submit Button -->
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            Add Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calculateDue() {
            const total = parseFloat(document.getElementById('total_amount').value) || 0;
            const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
            const due = total - paid;
            
            document.getElementById('due_amount').value = due.toFixed(2);
        }

        //Search customer function
        function searchCustomer() {
            const searchTerm = document.getElementById('customer_search').value.trim();
            
            if (!searchTerm) {
                alert('Please enter a name or phone number to search');
                return;
            }
            
            const customerList = document.getElementById('customerList');
            customerList.innerHTML = '<div class="loading">Searching...</div>';
            
            //Fetch customer data
            fetch(`/api/shops/{{ $shop->id }}/search-customers?query=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        customerList.innerHTML = '<div class="no-results">No customers found</div>';
                    } else {
                        let html = '';
                        data.forEach(customer => {
                            html += `
                                <div class="customer-item" onclick="selectCustomer(${JSON.stringify(customer).replace(/"/g, '&quot;')})">
                                    <div class="customer-name">${customer.name || 'No Name'}</div>
                                    <div class="customer-details">
                                        <span class="customer-phone">${customer.phone || 'No Phone'}</span>
                                        <span class="customer-transactions">${customer.transaction_count} transaction(s)</span>
                                    </div>
                                    ${customer.address ? `<div class="customer-address">${customer.address}</div>` : ''}
                                </div>
                            `;
                        });
                        customerList.innerHTML = html;
                    }
                    document.getElementById('customerResults').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    customerList.innerHTML = '<div class="error">Error loading customers</div>';
                });
        }

        function selectCustomer(customer) {
            document.getElementById('customer_name').value = customer.name || '';
            document.getElementById('customer_phone').value = customer.phone || '';
            document.getElementById('customer_address').value = customer.address || '';
            document.getElementById('customer_search').value = '';
            closeResults();
        }

        function closeResults() {
            document.getElementById('customerResults').classList.add('hidden');
        }

        document.addEventListener('click', function(event) {
            const results = document.getElementById('customerResults');
            const searchContainer = document.querySelector('.search-container');
            
            if (!searchContainer.contains(event.target)) {
                results.classList.add('hidden');
            }
        });

        //Calculate due on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateDue();
            
            document.getElementById('customer_search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchCustomer();
                }
            });
        });
    </script>

    <style>
        :root {
            --form-width: 500px;
        }

        .transaction-container {
            background: linear-gradient(120deg, #ffd4d4, #ffe8e8, rgba(255,255,255,0.7), #ffd4d4 80%);
            min-height: calc(100vh - 64px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .back-button-container {
            position: absolute;
            top: 50px;
            left: 50px;
            z-index: 100;
        }

        .back-header-btn {
            display: flex;
            justify-content: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            padding: 8px 12px;
        }

        .back-icon {
            margin-top: -5px;
            font-size: 40px;
            font-weight: 400;
            color: #dc2626;
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
            color: #dc2626;
            line-height: 1.2;
        }

        .page-name-title {
            font-size: 20px;
            font-weight: 500;
            color: #1c1c1c;
            line-height: 1.2;
        }

        .form-wrapper {
            width: 100%;
            max-width: var(--form-width);
            margin: 60px auto 0 auto;
            padding: 0 15px;
        }

        .transaction-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            padding: 25px;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .amount-row {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }

        .amount-row .form-group {
            flex: 1;
        }

        .form-columns {
            display: flex;
            flex-direction: column;
            margin-bottom: 5px;
        }

        .customer-search-section {
            margin-bottom: 15px;
        }

        .search-container {
            position: relative;
        }

        .search-input-group {
            display: flex;
            gap: 8px;
        }

        .search-input {
            flex: 1;
            padding: 6px 13px;
            border: 1px solid #dc2626;
            border-radius: 6px;
            font-size: 12px;
            background: white;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .search-input:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.1);
        }

        .search-btn {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .search-btn:hover {
            background: #b91c1c;
        }

        .customer-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 4px;
            max-height: 300px;
            overflow-y: auto;
        }

        .hidden {
            display: none;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
        }

        .close-results {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 2px;
            border-radius: 4px;
        }

        .close-results:hover {
            background: #f3f4f6;
        }

        .customer-list {
            padding: 8px 0;
        }

        .customer-item {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .customer-item:hover {
            background-color: #f9fafb;
        }

        .customer-item:last-child {
            border-bottom: none;
        }

        .customer-name {
            font-weight: 600;
            font-size: 13px;
            color: #111827;
            margin-bottom: 4px;
        }

        .customer-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .customer-address {
            font-size: 11px;
            color: #9ca3af;
            font-style: italic;
        }

        .loading, .no-results, .error {
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: black;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 6px 13px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 12px;
            background: white;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 50px;
        }

        .due-input {
            background-color: #dc2626 !important;
            background: linear-gradient(161deg, rgba(252, 184, 184, 1) 7%, rgba(220, 38, 38, 0.91) 50%, rgba(255, 163, 163, 1) 95%)!important;
            color: #ffffff;
            font-weight: 600;
            border-color: #dc2626;
        }

        .error-input {
            border-color: #dc2626 !important;
        }

        .error-message {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
            font-weight: 500;
        }

        /* Footer Buttons */
        .form-footer {
            display: flex;
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
        }
        
        .submit-btn {
            width: 100%;
            padding: 10px 26px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.25);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            :root {
                --form-width: 95%;
            }
            
            .form-columns {
                flex-direction: column;
                gap: 15px;
            }
            
            .amount-row {
                flex-direction: column;
                gap: 12px;
            }
        }

        @media (max-width: 768px) {
            .transaction-card {
                padding: 18px;
            }
            
            .back-button-container {
                top: 15px;
                left: 15px;
            }
            
            .back-header-btn {
                padding: 6px 10px;
            }
            
            .back-icon {
                font-size: 20px;
                margin-right: 8px;
            }
            
            .shop-name-title {
                font-size: 11px;
            }
            
            .page-name-title {
                font-size: 14px;
            }
            
            .form-wrapper {
                margin-top: 50px;
            }
            
            .form-footer {
                flex-direction: column;
                gap: 12px;
            }
            
            .search-input-group {
                flex-direction: column;
            }
            
            .search-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .transaction-card {
                padding: 15px;
            }
            
            .form-wrapper {
                padding: 0 10px;
                margin-top: 45px;
            }
            
            .back-button-container {
                top: 10px;
                left: 10px;
            }
            
            .back-header-btn {
                padding: 5px 8px;
            }
            
            .back-icon {
                font-size: 18px;
                margin-right: 6px;
            }
            
            .shop-name-title {
                font-size: 10px;
            }
            
            .page-name-title {
                font-size: 13px;
            }
        }
    </style>
</x-guest-layout>