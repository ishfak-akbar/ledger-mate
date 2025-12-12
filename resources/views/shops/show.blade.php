<x-app-layout>
    <x-slot name="header">
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

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-700 border-l-4 border-green-500 rounded-r-lg shadow-sm font-medium text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="shop-grid-container">

                {{-- Row 1: Shop Header & Primary Action --}}
                <div class="shop-header">
                    <div class="shop-header-content">
                        <h1 class="shop-name">{{ $shop->name }}</h1>
                        <div class="shop-category">
                            <span class="category-label">Category:</span>
                            <span class="badge {{ $shop->category }}">
                                {{ ucfirst($shop->category) }}
                            </span>
                        </div>
                    </div>
                </div>

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
                            <div class="stat-label">Total Amount (Tk.)</div>
                            <div class="stat-value">{{ number_format($totalAmount, 2) }}</div>
                            <div class="stat-icon">💰</div>
                        </div>
                        <div class="stat-box stat-box-green">
                            <div class="stat-label">Amount Paid (Tk.)</div>
                            <div class="stat-value">{{ number_format($paidAmount, 2) }}</div>
                            <div class="stat-icon">✅</div>
                        </div>
                        <div class="stat-box stat-box-reddish">
                            <div class="stat-label">Total Due (Tk.)</div>
                            <div class="stat-value">{{ number_format($dueAmount, 2) }}</div>
                            <div class="stat-icon">⏳</div>
                        </div>
                    </div>

                    <h3 class="section-title text-lg mb-4 mt-6">Core Information</h3>
                    {{-- Core Information Table --}}
                    <div class="detail-card">
                        <dl class="divide-y divide-gray-200">
                            <div class="detail-row">
                                <dt class="detail-label">
                                    <span class="detail-icon">📍</span>
                                    Address
                                </dt>
                                <dd class="detail-value text-gray-800 whitespace-pre-line">{{ $shop->address }}</dd>
                            </div>
                            <div class="detail-row">
                                <dt class="detail-label">
                                    <span class="detail-icon">🏷️</span>
                                    Category
                                </dt>
                                <dd class="detail-value">
                                    <span class="detail-badge {{ $shop->category }}">
                                        {{ ucfirst($shop->category) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="detail-row">
                                <dt class="detail-label">
                                    <span class="detail-icon">👤</span>
                                    Owner
                                </dt>
                                <dd class="detail-value text-gray-800">{{ $shop->user->name }}</dd>
                            </div>
                            @if($shop->notes)
                            <div class="detail-row">
                                <dt class="detail-label">
                                    <span class="detail-icon">📝</span>
                                    Shop Note
                                </dt>
                                <dd class="detail-value text-gray-800">{{ $shop->notes }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                </div>
                <div class="grid-card-span-1 p-6 md:p-8 bg-white border-l border-gray-100">
                    <h3 class="section-title text-red-600 mb-6">Quick Tools</h3>
                    
                    <div class="space-y-4">
                        <a href="{{ route('transactions.create', $shop) }}" class="action-btn text-red-600 hover:bg-red-50 border-red-200" style="margin: 12px 0px;">
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
                        
                        <a href="#" class="action-btn text-green-600 hover:bg-green-50 border-green-200" style="margin: 12px 0px;">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generate Report
                        </a>
                    </div>

                    <div class="bg-gray-50 border-t border-gray-200" style="margin-top: 20px;">
                        {{-- Payment Status Counts --}}
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100" style="width: 100%; margin: 10px 0px; margin-top: 20px;">
                            <h4 class="subsection-title-red">Payment Status</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Fully Paid:</span>
                                    <span class="font-bold text-green-600">{{ $shop->transactions()->where('due_amount', 0)->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Pending Payment:</span>
                                    <span class="font-bold text-red-600">{{ $shop->transactions()->where('due_amount', '>', 0)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100" style="width: 100%;">
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
                    </div>
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
        
        .shop-header {
            background-color: white;
            padding: 4px 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
        }

        @media (min-width: 640px) {
            .shop-header {
                padding: 20px 8px;
            }
        }

        .shop-header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px; 
        }

        .shop-name {
            color: #dc2626;
            font-size: 30px; 
            font-weight: 600;
            margin: 0;
        }

        .shop-category {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-label {
            font-size: 18px; 
            font-weight: 500;
            color: #4b5563;
        }

        .shop-grid-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            border-radius: 12px; 
            overflow: hidden;
            background: #ffffff;
        }

        .grid-card-span-2 {
            width: 70%;
        }
        .grid-card-span-3 {
            width: 100%;
        }
        .grid-card-span-1 {
            width: 25%;
        }

      
        .section-title {
            font-weight: 600;
            color: #1f2937;
            padding-bottom: 8px; 
            border-bottom: 1px solid #d1d5db;
            margin-bottom: 24px; 
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
            padding: 10px;
            border-radius: 8px; 
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 35%;
            min-height: 100px;
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
            font-size: 12px; 
            font-weight: 500;
            margin-bottom: 4px; 
            opacity: 0.9;
        }

        .stat-value {
            font-size: 20px; 
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 4px; 
        }

        .stat-icon {
            font-size: 24px; 
            opacity: 0.9;
            position: absolute;
            bottom: 5px;
            right: 8px;
            z-index: 1;
        }

 
        .detail-card {
            border: 1px solid #f3f4f6;
            border-radius: 8px; 
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            background: #fef2f2;
        }

        .detail-row {
            padding: 12px 16px; 
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 16px; 
            align-items: center;
            transition: background-color 0.2s;
        }

        .detail-row:hover {
            background-color: rgba(254, 242, 242, 0.7);
        }

        .detail-label {
            font-size: 12px; 
            font-weight: 600;
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 8px; 
        }

        .detail-icon {
            font-size: 14px; 
        }

        .detail-value {
            font-size: 14px; 
            font-weight: 600;
            color: #1f2937;
        }

        .detail-badge {
            display: inline-block;
            padding: 2px 8px; 
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
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
                min-height: 80px;
            }
            
            .stats-container {
                gap: 8px; 
            }
            
            .detail-row {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 8px 12px; 
            }
        }
    </style>
</x-app-layout>