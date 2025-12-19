<x-guest-layout>
    <div class="transaction-container">
        <div class="back-button-container">
            <a href="{{ route('shops.show', $shop) }}" class="back-header-btn">
                <span class="back-icon"><</span>
                <div class="header-titles">
                    <span class="shop-name-title">{{ $shop->name }}</span>
                    <span class="page-name-title">Add Supplier Transaction</span>
                </div>
            </a>
        </div>

        <div class="form-wrapper">
            <div class="transaction-card">
                <form method="POST" action="{{ route('supplier-transactions.store', $shop) }}" id="supplierTransactionForm">
                    @csrf

                    <!-- Transaction Type -->
                    <div class="form-group">
                        <label for="transaction_type" class="form-label">Transaction Type *</label>
                        <select 
                            id="transaction_type" 
                            name="transaction_type" 
                            class="form-select @error('transaction_type') error-input @enderror" 
                            required
                            onchange="updateAmountLabels()"
                        >
                            <option value="" disabled selected>Select transaction type</option>
                            <option value="purchase" {{ old('transaction_type') == 'purchase' ? 'selected' : '' }}>Purchase from Supplier</option>
                            <option value="payment" {{ old('transaction_type') == 'payment' ? 'selected' : '' }}>Payment to Supplier</option>
                            <option value="return" {{ old('transaction_type') == 'return' ? 'selected' : '' }}>Return to Supplier</option>
                        </select>
                        @error('transaction_type')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount Row: Total, Paid, Due -->
                    <div class="amount-row">
                        <!-- Total Amount -->
                        <div class="form-group">
                            <label id="total_amount_label" for="total_amount" class="form-label">Purchase Amount *</label>
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
                            <label id="paid_amount_label" for="paid_amount" class="form-label">Amount Paid *</label>
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
                            <label id="due_amount_label" for="due_amount" class="form-label">Amount Due</label>
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
                        <!-- Payment Method -->
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
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                            </select>
                            @error('payment_method')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
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

                        <!-- Supplier Search Section -->
                        <div class="supplier-search-section">
                            <label class="form-label">Find Supplier</label>
                            <div class="search-container">
                                <div class="search-input-group">
                                    <input 
                                        type="text" 
                                        id="supplier_search" 
                                        placeholder="Enter supplier name or phone"
                                        class="search-input"
                                    >
                                    <button type="button" onclick="searchSupplier()" class="search-btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Find
                                    </button>
                                </div>
                                
                                <!-- Supplier Results Dropdown -->
                                <div id="supplierResults" class="supplier-results hidden">
                                    <div class="results-header">
                                        <span>Select a supplier</span>
                                        <button type="button" onclick="closeSupplierResults()" class="close-results">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="supplierList" class="supplier-list">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Supplier Name -->
                        <div class="form-group">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input 
                                type="text" 
                                id="supplier_name" 
                                name="supplier_name" 
                                value="{{ old('supplier_name') }}" 
                                placeholder="Enter supplier name"
                                class="form-input @error('supplier_name') error-input @enderror"
                            >
                            @error('supplier_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Supplier Phone -->
                        <div class="form-group">
                            <label for="supplier_phone" class="form-label">Supplier Phone</label>
                            <input 
                                type="tel" 
                                id="supplier_phone" 
                                name="supplier_phone" 
                                value="{{ old('supplier_phone') }}" 
                                placeholder="Enter supplier phone"
                                class="form-input @error('supplier_phone') error-input @enderror"
                            >
                            @error('supplier_phone')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Supplier Address -->
                        <div class="form-group">
                            <label for="supplier_address" class="form-label">Supplier Address</label>
                            <textarea 
                                id="supplier_address" 
                                name="supplier_address" 
                                placeholder="Enter supplier address"
                                class="form-textarea @error('supplier_address') error-input @enderror"
                                rows="2"
                            >{{ old('supplier_address') }}</textarea>
                            @error('supplier_address')
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

                    <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">

                    <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            Add Supplier Transaction
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
            const transactionType = document.getElementById('transaction_type').value;
            
            let due = total - paid;
            
            if (transactionType === 'return') {
                due = paid - total; 
            }
            
            document.getElementById('due_amount').value = due.toFixed(2);
            
            const dueInput = document.getElementById('due_amount');
            if (due > 0) {
                dueInput.style.background = 'linear-gradient(161deg, rgba(252, 184, 184, 1) 7%, rgba(220, 38, 38, 0.91) 50%, rgba(255, 163, 163, 1) 95%)!important';
                dueInput.style.color = '#ffffff';
            } else if (due < 0) {
                dueInput.style.background = 'linear-gradient(161deg, rgba(184, 252, 196, 1) 7%, rgba(38, 220, 100, 0.91) 50%, rgba(163, 255, 173, 1) 95%)!important';
                dueInput.style.color = '#064e3b';
            } else {
                dueInput.style.background = '#f3f4f6';
                dueInput.style.color = '#6b7280';
            }
        }

        function updateAmountLabels() {
            const transactionType = document.getElementById('transaction_type').value;
            const totalLabel = document.getElementById('total_amount_label');
            const paidLabel = document.getElementById('paid_amount_label');
            const dueLabel = document.getElementById('due_amount_label');
            
            switch(transactionType) {
                case 'purchase':
                    totalLabel.textContent = 'Purchase Amount *';
                    paidLabel.textContent = 'Amount Paid *';
                    dueLabel.textContent = 'Amount Due';
                    break;
                case 'payment':
                    totalLabel.textContent = 'Payment Amount *';
                    paidLabel.textContent = 'Amount Paid *';
                    dueLabel.textContent = 'Balance';
                    break;
                case 'return':
                    totalLabel.textContent = 'Return Amount *';
                    paidLabel.textContent = 'Refund Received *';
                    dueLabel.textContent = 'Refund Due';
                    break;
            }
            
            calculateDue();
        }

        function searchSupplier() {
            const searchTerm = document.getElementById('supplier_search').value.trim();
            
            if (!searchTerm) {
                alert('Please enter a name or phone number to search');
                return;
            }
            
            const supplierList = document.getElementById('supplierList');
            supplierList.innerHTML = '<div class="loading">Searching...</div>';
            
            // Fetch supplier data from existing transactions
            fetch(`/shops/{{ $shop->id }}/search-suppliers?query=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        supplierList.innerHTML = '<div class="no-results">No suppliers found</div>';
                    } else {
                        let html = '';
                        data.forEach(supplier => {
                            // Calculate supplier balance
                            const balance = (supplier.total_amount - supplier.paid_amount).toFixed(2);
                            const balanceClass = balance >= 0 ? 'text-red-600' : 'text-green-600';
                            const balanceText = balance >= 0 ? `Owes: Tk. ${balance}` : `Credit: Tk. ${Math.abs(balance)}`;
                            
                            html += `
                                <div class="supplier-item" onclick="selectSupplier(${JSON.stringify(supplier).replace(/"/g, '&quot;')})">
                                    <div class="supplier-name">${supplier.name || 'No Name'}</div>
                                    <div class="supplier-details">
                                        <span class="supplier-phone">${supplier.phone || 'No Phone'}</span>
                                        <span class="supplier-transactions">${supplier.transaction_count} transaction(s)</span>
                                    </div>
                                    <div class="supplier-balance ${balanceClass}">
                                        ${balanceText}
                                    </div>
                                    ${supplier.address ? `<div class="supplier-address">${supplier.address}</div>` : ''}
                                </div>
                            `;
                        });
                        supplierList.innerHTML = html;
                    }
                    document.getElementById('supplierResults').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    supplierList.innerHTML = '<div class="error">Error loading suppliers</div>';
                });
        }

        function selectSupplier(supplier) {
            document.getElementById('supplier_name').value = supplier.name || '';
            document.getElementById('supplier_phone').value = supplier.phone || '';
            document.getElementById('supplier_address').value = supplier.address || '';
            document.getElementById('supplier_search').value = '';
            closeSupplierResults();
            
        }

        function closeSupplierResults() {
            document.getElementById('supplierResults').classList.add('hidden');
        }

        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.createElement('div');
            toastContainer.id = 'tempToastContainer';
            toastContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
            `;
            document.body.appendChild(toastContainer);
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.style.cssText = `
                padding: 12px 16px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                font-size: 14px;
                font-weight: 500;
                animation: slideIn 0.3s ease-out;
                margin-bottom: 8px;
                background-color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
                color: white;
                border-left: 4px solid ${type === 'success' ? '#059669' : type === 'error' ? '#dc2626' : '#2563eb'};
            `;
            
            toast.textContent = message;
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                    if (toastContainer.parentNode && toastContainer.children.length === 0) {
                        toastContainer.parentNode.removeChild(toastContainer);
                    }
                }, 300);
            }, duration);
        }

        const style = document.createElement('style');
        style.textContent = `
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
        `;
        document.head.appendChild(style);

        document.addEventListener('click', function(event) {
            const results = document.getElementById('supplierResults');
            const searchContainer = document.querySelector('.search-container');
            
            if (!searchContainer.contains(event.target)) {
                results.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            calculateDue();
            
            document.getElementById('supplier_search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchSupplier();
                }
            });
            
            const transactionType = document.getElementById('transaction_type');
            if (transactionType.value) {
                updateAmountLabels();
            }
            
            transactionType.addEventListener('change', updateAmountLabels);
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

        .supplier-search-section {
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
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
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

        .supplier-results {
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

        .supplier-list {
            padding: 8px 0;
        }

        .supplier-item {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .supplier-item:hover {
            background-color: #f9fafb;
        }

        .supplier-item:last-child {
            border-bottom: none;
        }

        .supplier-name {
            font-weight: 600;
            font-size: 13px;
            color: #111827;
            margin-bottom: 4px;
        }

        .supplier-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .supplier-balance {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .supplier-address {
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
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 50px;
        }

        .due-input {
            background-color: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
            border-color: #d1d5db;
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
            background: #dc2626;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
        }

        .submit-btn:hover {
            transform: translateY(-1px);        }

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