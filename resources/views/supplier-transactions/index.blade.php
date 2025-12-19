<x-guest-layout>
    <style>
        :root {
            --color-primary: #dc2626;
            --color-primary-dark: #dc2626;
            --color-primary-light: #dc2626;
            --color-success: #10b981;
            --color-danger: #dc2626;
            --color-warning: #f59e0b;
            --color-info: #3b82f6;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }


        .btn-reset-filters {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
        }

        .btn-reset-filters:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.25);
        }

        .btn-reset-filters:active {
            transform: translateY(0);
        }

        .filter-input, .filter-select {
            transition: all 0.3s;
        }

        .filter-input:focus, .filter-select:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.1);
        }

        .filter-input[type="date"][value]:not([value=""]) {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .back-button-container {
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
        .header-section {
            background: white;
            border-radius: 12px;
            margin-bottom: 35px;
            margin-top: 20px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shop-name {
            font-size: 18px;
            font-weight: 500;
            color: var(--color-primary);
            margin-top: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
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

        .btn-back {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(107, 114, 128, 0.2);
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            border-left: 3px solid #dc2626;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            transition: all 0.2s;
        }

        .stat-card:nth-child(1){
            border-color: blue;
        }
        .stat-card:nth-child(2){
            border-color: purple;
        }
        .stat-card:nth-child(3){
            border-color: green;
        }
        .stat-card:nth-child(4){
            border-color: red;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-trend {
            font-size: 12px;
            font-weight: 500;
        }

        .trend-up {
            color: var(--color-success);
        }

        .trend-down {
            color: var(--color-danger);
        }

        .filters-section {
            background: #fdf2f2;
            border-radius: 10px 10px 0px 0px;
            border-bottom: 1px solid #dc2626;
            padding: 20px;
        }

        .filter-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .filter-input, .filter-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1);
        }

        .transactions-table {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .table-header {
            background: #f9fafb;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f3f4f6;
        }

        th {
            padding: 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 500;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #4b5563;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 20px;
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

        .amount-cell {
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .due-amount {
            color: var(--color-danger);
        }

        .paid-amount {
            color: var(--color-success);
        }

        .action-cell {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        .btn-view {
            background: var(--color-primary);
            color: white;
            border: none;
            text-decoration: none;
        }

        .btn-view:hover {
            background: var(--color-primary-dark);
        }

        .btn-edit {
            background: var(--color-info);
            color: white;
            border: none;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-delete {
            background: var(--color-danger);
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }

        .pagination-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 12px;
        }

        .pagination-info {
            font-size: 14px;
            color: #6b7280;
        }

        .pagination {
            display: flex;
            gap: 5px;
        }

        .page-link {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
        }

        .page-link:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .page-link.active {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 20px;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .action-buttons {
                width: 100%;
            }
            
            .btn {
                flex: 1;
            }
            
            .stats-section {
                grid-template-columns: 1fr 1fr;
            }
            
            th, td {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .filter-row {
                flex-direction: column;
            }
            
            .filter-group {
                min-width: 100%;
            }
            
            .pagination-section {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
    <body>
        <div class="container">
            <!-- Toast Container -->
            <div id="toastContainer" class="toast-container"></div>
                <div class="header-row">
                    <div class="back-button-container">
                        <a href="{{ route('shops.show', $shop) }}" class="back-header-btn">
                            <span class="back-icon"><</span>
                            <div class="header-titles">
                                <span class="shop-name-title">{{ $shop->name }}</span>
                                <span class="page-name-title">Supplier Transaction</span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('supplier-transactions.create', $shop) }}" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Transaction
                        </a>
                    </div>
                </div>
            <div class="header-section">
            

                <!-- Stats Section -->
                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Total Transactions
                        </div>
                        <div class="stat-value">{{ $totalTransactions }}</div>
                        <div class="stat-trend">
                            @php
                                $types = ['Purchase' => $purchaseCount, 'Payment' => $paymentCount, 'Return' => $returnCount];
                                $maxType = array_search(max($types), $types);
                            @endphp
                            Most: {{ $maxType }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Total Amount
                        </div>
                        <div class="stat-value">Tk.  {{ number_format($totalAmount, 2) }}</div>
                        <div class="stat-trend">
                            @php
                                $avgTransaction = $totalTransactions > 0 ? $totalAmount / $totalTransactions : 0;
                            @endphp
                            Avg: Tk.  {{ number_format($avgTransaction, 2) }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Amount Paid
                        </div>
                        <div class="stat-value">Tk.  {{ number_format($totalPaid, 2) }}</div>
                        <div class="stat-trend">
                            @php
                                $paidPercentage = $totalAmount > 0 ? ($totalPaid / $totalAmount) * 100 : 0;
                            @endphp
                            <span class="trend-up">{{ number_format($paidPercentage, 1) }}% of total</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Total Due
                        </div>
                        <div class="stat-value">Tk.  {{ number_format($totalDue, 2) }}</div>
                        <div class="stat-trend">
                            @php
                                $duePercentage = $totalAmount > 0 ? ($totalDue / $totalAmount) * 100 : 0;
                            @endphp
                            <span class="trend-down">{{ number_format($duePercentage, 1) }}% of total</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="border: 2px solid #dc2626; border-radius:12px;">
    <!-- Filters Section -->
        <div>
            <div class="filters-section">
                <div class="filter-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 style="font-size: 16px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 8px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Transactions
                    </h3>
                    <button type="button" onclick="resetFilters()" class="btn-reset-filters">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filters
                    </button>
                </div>
            
                <form method="GET" action="{{ route('supplier-transactions.index', $shop) }}" id="filterForm">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">Supplier Name</label>
                            <input type="text" 
                                name="supplier" 
                                value="{{ request('supplier') }}"
                                placeholder="Search supplier..."
                                class="filter-input">
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Transaction Type</label>
                            <select name="type" class="filter-select">
                                <option value="">All Types</option>
                                <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Purchase</option>
                                <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Payment</option>
                                <option value="return" {{ request('type') == 'return' ? 'selected' : '' }}>Return</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Date From</label>
                            <input type="date" 
                                name="from_date" 
                                value="{{ request('from_date') }}"
                                class="filter-input">
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">Date To</label>
                            <input type="date" 
                                name="to_date" 
                                value="{{ request('to_date') }}"
                                class="filter-input">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="transactions-table">
                @if($transactions->count() > 0)
                    <div class="table-container">
                        <table>
                            <thead style="background:#dc2626;">
                                <tr style="color:white;">
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Type</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>#{{ $transaction->id }}</td>
                                        <td>{{ $transaction->date->format('M d, Y') }}</td>
                                        <td>
                                            <strong>{{ $transaction->supplier_name ?? 'N/A' }}</strong>
                                            @if($transaction->supplier_phone)
                                                <div style="font-size: 12px; color: #6b7280;">
                                                    {{ $transaction->supplier_phone }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge type-{{ $transaction->transaction_type }}">
                                                {{ ucfirst($transaction->transaction_type) }}
                                            </span>
                                        </td>
                                        <td class="amount-cell">Tk.  {{ number_format($transaction->total_amount, 2) }}</td>
                                        <td class="amount-cell paid-amount">Tk.  {{ number_format($transaction->paid_amount, 2) }}</td>
                                        <td class="amount-cell due-amount">Tk.  {{ number_format($transaction->due_amount, 2) }}</td>
                                        <td>
                                            <span style="font-size: 12px; text-transform: capitalize;">
                                                {{ str_replace('_', ' ', $transaction->payment_method) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($transaction->due_amount > 0)
                                                <span class="badge status-due">Due</span>
                                            @else
                                                <span class="badge status-paid">Paid</span>
                                            @endif
                                        </td>
                                        <td class="action-cell">
                                            <form action="{{ route('supplier-transactions.destroy', [$shop, $transaction]) }}" 
                                                    method="POST" 
                                                    style="display: inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-delete">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="empty-title">No Supplier Transactions Found</h3>
                        <a href="{{ route('supplier-transactions.create', $shop) }}" class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create First Transaction
                        </a>
                    </div>
                @endif
            </div>

                <!-- Pagination -->
                @if($transactions->count() > 0)
                    <div class="pagination-section">
                        <div class="pagination-info">
                            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} transactions
                        </div>
                        
                        <div class="pagination">
                            @if($transactions->onFirstPage())
                                <span class="page-link disabled">Previous</span>
                            @else
                                <a href="{{ $transactions->previousPageUrl() }}" class="page-link">Previous</a>
                            @endif

                            @foreach(range(1, $transactions->lastPage()) as $page)
                                @if($page == $transactions->currentPage())
                                    <span class="page-link active">{{ $page }}</span>
                                @else
                                    <a href="{{ $transactions->url($page) }}" class="page-link">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($transactions->hasMorePages())
                                <a href="{{ $transactions->nextPageUrl() }}" class="page-link">Next</a>
                            @else
                                <span class="page-link disabled">Next</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>   
        </div>

        <script>
            function setupFilterAutoSubmit() {
            const filterInputs = document.querySelectorAll('.filter-input, .filter-select');
            
                filterInputs.forEach(input => {

                    if (input.tagName === 'SELECT') {
                        input.addEventListener('change', function() {
                            submitFilterForm();
                        });
                    }
                    
                    if (input.type === 'text') {
                        input.addEventListener('keypress', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                submitFilterForm();
                            }
                        });
                        
                        // Auto-submit after typing stops (debounce)
                        let timeout;
                        input.addEventListener('input', function() {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => {
                                submitFilterForm();
                            }, 800);
                        });
                    }
                    
                    if (input.type === 'date') {
                        input.addEventListener('change', function() {
                            submitFilterForm();
                        });
                    }
                });
            }

            function submitFilterForm() {
                document.getElementById('filterForm').submit();
            }


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

            //Check for session messages
            <?php if(session('success')): ?>
                showToast("<?php echo e(session('success')); ?>", 'success');
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                showToast("<?php echo e(session('error')); ?>", 'error');
            <?php endif; ?>

            //Filter form reset
            function resetFilters() {
                const form = document.getElementById('filterForm');
                const inputs = form.querySelectorAll('input, select');
                
                inputs.forEach(input => {
                    if (input.type === 'text' || input.type === 'date') {
                        input.value = '';
                    } else if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    }
                });

                form.submit();
            }

            function updateFilterUI() {
                const urlParams = new URLSearchParams(window.location.search);
                const hasFilters = Array.from(urlParams.keys()).some(key => 
                    ['supplier', 'type', 'from_date', 'to_date'].includes(key)
                );
                
                const supplierInput = document.querySelector('input[name="supplier"]');
                const typeSelect = document.querySelector('select[name="type"]');
                const fromDateInput = document.querySelector('input[name="from_date"]');
                const toDateInput = document.querySelector('input[name="to_date"]');
                
                if (urlParams.get('supplier')) {
                    supplierInput.style.borderColor = '#dc2626';
                    supplierInput.style.backgroundColor = '#fef2f2';
                }
                
                if (urlParams.get('type')) {
                    typeSelect.style.borderColor = '#dc2626';
                    typeSelect.style.backgroundColor = '#fef2f2';
                }
                
                if (urlParams.get('from_date')) {
                    fromDateInput.style.borderColor = '#dc2626';
                    fromDateInput.style.backgroundColor = '#fef2f2';
                }
                
                if (urlParams.get('to_date')) {
                    toDateInput.style.borderColor = '#dc2626';
                    toDateInput.style.backgroundColor = '#fef2f2';
                }
                
                if (hasFilters) {
                    const filterHeader = document.querySelector('.filter-header h3');
                    const activeFilterCount = Array.from(urlParams.keys()).filter(key => 
                        ['supplier', 'type', 'from_date', 'to_date'].includes(key) && urlParams.get(key)
                    ).length;
                    
                    if (filterHeader && activeFilterCount > 0) {
                        const existingBadge = filterHeader.querySelector('.filter-badge');
                        if (existingBadge) {
                            existingBadge.remove();
                        }
                        
                        const badge = document.createElement('span');
                        badge.className = 'filter-badge';
                        badge.textContent = `${activeFilterCount} active`;
                        badge.style.cssText = `
                            background: #dc2626;
                            color: white;
                            font-size: 11px;
                            font-weight: 600;
                            padding: 2px 8px;
                            border-radius: 10px;
                            margin-left: 8px;
                            vertical-align: middle;
                        `;
                        filterHeader.appendChild(badge);
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                //Check for session messages
                <?php if(session('success')): ?>
                        showToast("<?php echo e(session('success')); ?>", 'success');
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                    showToast("<?php echo e(session('error')); ?>", 'error');
                <?php endif; ?>
                
                //Setup filter functionality
                setupFilterAutoSubmit();
                updateFilterUI();
        
                window.showToast = function(message, type = 'success', duration = 5000) {
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
                };
            });
        </script>
    </body>
    </html>
</x-guest-layout>
    
    