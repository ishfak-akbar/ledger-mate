<x-guest-layout>
    <div class="page-content">
        <div class="back-button-container">
            <a href="{{ route('shops.show', $shop) }}" class="back-header-btn">
                <span class="back-icon"><</span>
                <div class="header-titles">
                    <span class="shop-name-title">{{ $shop->name }}</span>
                    <span class="page-name-title">View Transaction</span>
                </div>
            </a>
        </div>
        <div class="main-content-area">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $totalTransactions = $shop->transactions()->count();
                $totalAmount = $shop->transactions()->sum('total_amount');
                $totalPaid = $shop->transactions()->sum('paid_amount');
                $totalDue = $shop->transactions()->sum('due_amount');
                $completedTransactions = $shop->transactions()->where('due_amount', 0)->count();
                $pendingTransactions = $shop->transactions()->where('due_amount', '>', 0)->count();
            @endphp
            <div class="stats-grid">
                <div class="stat-card border-blue">
                    <div class="stat-label">Total Transactions</div>
                    <div class="stat-value text-default">{{ $totalTransactions }}</div>
                </div>
                <div class="stat-card border-purple">
                    <div class="stat-label">Total Amount</div>
                    <div class="stat-value text-default">Tk. {{ number_format($totalAmount, 2) }}</div>
                </div>
                <div class="stat-card border-green-light">
                    <div class="stat-label">Total Paid</div>
                    <div class="stat-value text-default">Tk. {{ number_format($totalPaid, 2) }}</div>
                </div>
                <div class="stat-card border-{{ $totalDue > 0 ? 'red' : 'green-light' }}">
                    <div class="stat-label">Total Due</div>
                    <div class="stat-value {{ $totalDue > 0 ? 'text-red' : 'text-green-dark' }}">
                        Tk. {{ number_format($totalDue, 2) }}
                    </div>
                </div>
            </div>

            <div class="combined-container">
                <div class="filter-bar-section">
                    <form method="GET" action="{{ route('transactions.index', $shop) }}" id="filterForm" class="filter-form">
                        <div class="filter-bar">
                            <div class="search-field-wrapper">
                                <input type="text" 
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Search by customer name or phone..." 
                                       class="search-input"
                                       onkeyup="applyFilters()">
                                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="filter-actions-group">
                                <select class="filter-select" name="status" onchange="applyFilters()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Transactions</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Fully Paid</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                                </select>
                                <select class="filter-select" name="payment_method" onchange="applyFilters()">
                                    <option value="">All Payment Methods</option>
                                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="upi" {{ request('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                <button type="button" class="clear-filters-btn" onclick="clearFilters()">
                                    Clear Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-content-section">
                    <div class="table-header-info">
                        <h3 class="table-title">All Transactions</h3>
                        <div class="table-pagination-summary">
                            Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} transactions
                        </div>
                    </div>

                    @if($transactions->isEmpty())
                        <div class="no-data-message">
                            <svg class="no-data-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="no-data-text">No transactions found for this shop</p>
                            <a href="{{ route('transactions.create', $shop) }}" class="add-first-btn">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add First Transaction
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead class="table-head">
                                    <tr>
                                        <th class="table-th">Date</th>
                                        <th class="table-th">Customer</th>
                                        <th class="table-th">Total</th>
                                        <th class="table-th">Paid</th>
                                        <th class="table-th">Due</th>
                                        <th class="table-th">Payment</th>
                                        <th class="table-th">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @foreach($transactions as $transaction)
                                    <tr class="table-row">
                                        <td class="table-td text-nowrap">
                                            <div class="text-medium text-default">{{ $transaction->date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-medium">{{ $transaction->date->format('h:i A') }}</div>
                                        </td>
                                        <td class="table-td">
                                            <div class="text-medium text-default">{{ $transaction->customer_name ?: 'Walk-in' }}</div>
                                            @if($transaction->customer_phone)
                                            <div class="text-xs text-gray-medium">{{ $transaction->customer_phone }}</div>
                                            @endif
                                        </td>
                                        <td class="table-td text-nowrap">
                                            <div class="text-medium font-semibold text-default">Tk. {{ number_format($transaction->total_amount, 2) }}</div>
                                        </td>
                                        <td class="table-td text-nowrap">
                                            <div class="text-medium font-semibold text-green-dark">Tk. {{ number_format($transaction->paid_amount, 2) }}</div>
                                        </td>
                                        <td class="table-td text-nowrap">
                                            <div class="flex-col">
                                                <div class="text-medium font-semibold {{ $transaction->due_amount > 0 ? 'text-red' : 'text-green-dark' }}">
                                                    Tk. {{ number_format($transaction->due_amount, 2) }}
                                                </div>
                                                @if($transaction->due_amount > 0)
                                                <div class="text-xs text-red-medium">Pending</div>
                                                @else
                                                <div class="text-xs text-green-medium">Paid</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="table-td text-nowrap">
                                            @php
                                                $paymentClass = 'bg-gray-light text-gray-dark';
                                                switch($transaction->payment_method) {
                                                    case 'cash': $paymentClass = 'bg-green-lightest text-green-dark'; break;
                                                    case 'card': $paymentClass = 'bg-blue-lightest text-blue-dark'; break;
                                                    case 'bank_transfer': $paymentClass = 'bg-purple-lightest text-purple-dark'; break;
                                                    case 'upi': $paymentClass = 'bg-yellow-lightest text-yellow-dark'; break;
                                                }
                                            @endphp
                                            <span class="badge {{ $paymentClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                            </span>
                                        </td>
                                        <td class="table-td text-actions">
                                            <div class="action-buttons-group">
                                                <a href="{{ route('transactions.show', [$shop, $transaction]) }}" 
                                                   class="text-blue-dark hover:text-blue-darkest"
                                                   title="View Details">
                                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                     </svg>
                                                </a>
                                                <form action="{{ route('transactions.destroy', [$shop, $transaction]) }}" 
                                                    method="POST" 
                                                    class="inline delete-form"
                                                    onsubmit="return confirmDelete(event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red hover:text-red-darkest focus:outline-none bg-transparent border-none p-0 cursor-pointer"
                                                            title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer-summary">
                            <div class="footer-stats-text">
                                Fully Paid: <span class="font-semibold text-green-dark">{{ $completedTransactions }}</span> 
                                | Pending: <span class="font-semibold text-red">{{ $pendingTransactions }}</span>
                            </div>
                            <div class="pagination-links">
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let filterTimeout;
        
        function applyFilters() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        }
        
        function clearFilters() {
            const url = new URL(window.location.href);
            url.search = '';
            window.location.href = url.toString();
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const statusSelect = document.querySelector('select[name="status"]');
            const paymentSelect = document.querySelector('select[name="payment_method"]');
            
            searchInput.value = "{{ request('search') }}";
        });

        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            if (confirm('Are you sure you want to delete this transaction? This action cannot be undone.')) {
                form.submit();
            }
            return false;
        }
    </script>

    <style>
        :root {
            --color-white: #fff;
            --color-gray-lightest: #f9fafb;
            --color-gray-light: #f3f4f6;
            --color-gray-medium: #6b7280;
            --color-gray-dark: #374151;
            --color-gray-darkest: #1f2937;

            --color-red: #dc2626;
            --color-red-hover: #b91c1c;
            --color-red-medium: #ef4444;
            --color-red-darkest: #7f1d1d;

            --color-green: #10b981;
            --color-green-dark: #059669;
            --color-green-medium: #34d399;
            --color-green-light: #6ee7b7;
            --color-green-lightest: #d1fae5;

            --color-blue: #3b82f6;
            --color-blue-dark: #2563eb;
            --color-blue-darkest: #1e3a8a;
            --color-blue-lightest: #dbeafe;

            --color-purple: #9333ea;
            --color-purple-lightest: #f3e8ff;

            --color-yellow: #f59e0b;
            --color-yellow-dark: #ca8a04;
            --color-yellow-darkest: #854d0e;
            --color-yellow-lightest: #fffbeb;
        }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .page-content {
            padding-top: 32px;
            padding-bottom: 32px;
        }
        .back-button-container {
            position: absolute;
            top: 30px;
            left: 30px;
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

        /* .back-header-btn:hover {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        } */

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

        .main-content-area {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 24px;
            padding-right: 24px;
        }

        .font-semibold { font-weight: 600; }
        .text-xl { font-size: 20px; line-height: 28px; }
        .text-lg { font-size: 18px; line-height: 28px; }
        .text-sm { font-size: 14px; line-height: 20px; }
        .text-xs { font-size: 12px; line-height: 16px; }
        .text-2xl { font-size: 24px; line-height: 32px; }
        .text-default { color: var(--color-gray-darkest); }
        .text-red { color: var(--color-red); }
        .text-green-dark { color: var(--color-green-dark); }
        .text-red-medium { color: var(--color-red-medium); }
        .text-green-medium { color: var(--color-green-medium); }
        .font-bold { font-weight: 700; }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-weight: 600;
            font-size: 20px;
            line-height: 28px;
            color: var(--color-gray-dark);
        }
        
        .header-subtitle {
            font-size: 14px;
            color: var(--color-gray-medium);
            margin-top: 4px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .add-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: var(--color-red);
            color: var(--color-white);
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .add-btn:hover {
            background: var(--color-red-hover);
            transform: translateY(-1px);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: var(--color-gray-light);
            color: var(--color-gray-dark);
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .success-message {
            margin-bottom: 24px;
            padding: 16px;
            background-color: #d1fae5;
            color: var(--color-green-dark);
            border-radius: 8px;
        }

        .stats-grid {
            margin-top: 70px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }
        @media (min-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .stat-card {
            background-color: var(--color-white);
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border-left-width: 4px;
            border-left-style: solid;
        }

        .stat-card.border-blue { border-left-color: var(--color-blue); }
        .stat-card.border-purple { border-left-color: var(--color-purple); }
        .stat-card.border-green-light { border-left-color: var(--color-green); }
        .stat-card.border-red { border-left-color: var(--color-red-medium); }

        .stat-label {
            font-size: 14px;
            color: var(--color-gray-medium);
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-top: 4px;
        }

        .combined-container {
            background-color: var(--color-white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 2px solid var(--color-red);
        }

        .filter-bar-section {
            background-color: #fef2f2;
            padding: 24px;
            border-bottom: 1px solid var(--color-red);
        }
        
        .filter-form {
            margin: 0;
        }
        
        .filter-bar {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        @media (min-width: 768px) {
            .filter-bar {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .search-field-wrapper {
            position: relative;
            flex: 1;
            max-width: 448px;
        }

        .search-input {
            width: 100%;
            padding-left: 40px;
            padding-right: 16px;
            padding-top: 8px;
            padding-bottom: 8px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .search-input:focus {
            border-color: var(--color-red);
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.5);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
        }

        .filter-actions-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .filter-select {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding-left: 16px;
            padding-right: 16px;
            padding-top: 8px;
            padding-bottom: 8px;
            outline: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            min-width: 200px;
        }
        .filter-select:focus {
            border-color: var(--color-red);
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.5);
        }

        .clear-filters-btn {
            padding: 8px 16px;
            background-color: #dc2626;
            color: #fff;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .clear-filters-btn:hover {
            background-color: #7f1d1d;
        }

        .table-content-section {
            padding: 24px;
        }

        .table-header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--color-gray-darkest);
        }

        .table-pagination-summary {
            font-size: 14px;
            color: var(--color-gray-medium);
        }

        .no-data-message {
            text-align: center;
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .no-data-icon {
            width: 64px;
            height: 64px;
            color: #9ca3af;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 16px;
        }

        .no-data-text {
            color: var(--color-gray-medium);
            margin-bottom: 16px;
        }

        .add-first-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background-color: var(--color-red);
            color: var(--color-white);
            border-radius: 8px;
            transition: background-color 0.15s ease-in-out;
        }

        .add-first-btn:hover {
            background-color: var(--color-red-hover);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            min-width: 100%;
            border-collapse: collapse;
        }

        .table-head {
            background-color: #dc2626;
        }

        .table-th {
            padding: 12px 24px;
            text-align: left;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-body {
            background-color: var(--color-white);
        }

        .table-td {
            padding: 16px 24px;
            font-size: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .table-td.text-nowrap {
            white-space: nowrap;
        }

        .table-row:hover {
            background-color: #f9fafb;
        }

        .flex-col {
            display: flex;
            flex-direction: column;
        }

        .action-buttons-group {
            display: flex;
            gap: 12px;
        }

        .action-buttons-group a {
            transition: color 0.15s ease-in-out;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .badge.bg-green-lightest { background-color: var(--color-green-lightest); }
        .badge.text-green-dark { color: var(--color-green-dark); }
        .badge.bg-blue-lightest { background-color: var(--color-blue-lightest); }
        .badge.text-blue-dark { color: var(--color-blue-dark); }
        .badge.bg-purple-lightest { background-color: var(--color-purple-lightest); }
        .badge.text-purple-dark { color: var(--color-purple); }
        .badge.bg-yellow-lightest { background-color: var(--color-yellow-lightest); }
        .badge.text-yellow-dark { color: var(--color-yellow-dark); }
        .badge.bg-gray-light { background-color: var(--color-gray-light); }
        .badge.text-gray-dark { color: var(--color-gray-dark); }

        .table-footer-summary {
            margin-top: 24px;
            padding: 16px;
            background-color: #f9fafb;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-stats-text {
            font-size: 14px;
            color: var(--color-gray-medium);
        }

        .pagination-links nav {
            display: flex;
            align-items: center;
        }
        .pagination-links nav > div {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .pagination-links a, .pagination-links span {
            padding: 8px 12px;
            margin: 0 2px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
            color: var(--color-gray-dark);
            text-decoration: none;
            transition: background-color 0.15s ease-in-out;
        }
        .pagination-links a:hover {
            background-color: #f3f4f6;
        }
        .pagination-links span[aria-current="page"] {
            background-color: var(--color-red);
            border-color: var(--color-red);
            color: var(--color-white);
            font-weight: 700;
        }
    </style>
</x-guest-layout>