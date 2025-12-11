{{-- resources/views/transactions/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Transaction
                </h2>
                <p class="text-sm text-gray-600 mt-1">For: {{ $shop->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('transactions.index', $shop) }}" class="back-btn">
                    View All Transactions
                </a>
                <a href="{{ route('shops.show', $shop) }}" class="back-btn">
                    Back to Shop
                </a>
            </div>
        </div>
    </x-slot>

    <div class="transaction-container">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="transaction-card">
                <form method="POST" action="{{ route('transactions.store', $shop) }}" id="transactionForm">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Transaction Details -->
                        <div>
                            <!-- Total Amount -->
                            <div class="form-group">
                                <label for="total_amount" class="form-label">Total Amount (₹) *</label>
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
                                <label for="paid_amount" class="form-label">Paid Amount (₹) *</label>
                                <input 
                                    type="number" 
                                    id="paid_amount" 
                                    name="paid_amount" 
                                    value="{{ old('paid_amount', 0) }}" 
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

                            <!-- Due Amount (Auto-calculated, Readonly) -->
                            <div class="form-group">
                                <label for="due_amount" class="form-label">Due Amount (₹)</label>
                                <input 
                                    type="number" 
                                    id="due_amount" 
                                    name="due_amount" 
                                    value="{{ old('due_amount', 0) }}" 
                                    class="form-input" 
                                    readonly
                                    style="background-color: #f9fafb;"
                                >
                            </div>

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
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                @error('payment_method')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column - Customer Details & Notes -->
                        <div>
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
                                <label for="customer_phone" class="form-label">Customer Phone Number</label>
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
                    </div>

                    <!-- Hidden Date Field (Current Date) -->
                    <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-between">
                        <button type="button" onclick="window.history.back()" class="cancel-btn">
                            Cancel
                        </button>
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

        // Calculate due on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateDue();
        });
    </script>

    <style>
        .transaction-container {
            padding: 2rem 0;
            background: #f9fafb;
            min-height: calc(100vh - 64px);
        }

        .transaction-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            border: 1px solid #f3f4f6;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #f3f4f6;
            color: #374151;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .error-input {
            border-color: #dc2626 !important;
        }

        .error-message {
            font-size: 13px;
            color: #dc2626;
            margin-top: 4px;
            font-weight: 500;
        }

        .cancel-btn {
            padding: 12px 24px;
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cancel-btn:hover {
            background: #e5e7eb;
        }

        .submit-btn {
            padding: 12px 32px;
            background: #dc2626;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .submit-btn:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .transaction-card {
                padding: 1.5rem;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-app-layout>