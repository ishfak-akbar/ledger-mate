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
            @if(session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-700 border-l-4 border-green-500 rounded-r-lg shadow-sm font-medium text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-3 bg-red-100 text-red-700 border-l-4 border-red-500 rounded-r-lg shadow-sm font-medium text-sm">
                    {{ session('error') }}
                </div>
            @endif

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
                            <div class="stat-value">Tk. {{ number_format($dueAmount, 2) }}</div>
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
                    
                    <div class="space-y-4">
                        <a href="{{ route('transactions.create', $shop) }}" class="action-btn red-btn text-red-600 border-red-200" style="margin: 12px 0px;">
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
                        
                        <button onclick="openClearDueModal()" class="action-btn text-green-600 hover:bg-green-50 border-green-200" style="margin: 12px 0px; width: 100%; border: 1px solid; cursor: pointer;">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Clear Due Payment
                        </button>
                    </div>

                    <div class="bg-gray-50" style="margin-top: 20px; border-top: 1px solid #ddd;">
                        {{-- Payment Status Counts --}}
                        <div class="bg-white p-4 rounded-lg shadow-sm" style="border: 1px solid #ffc7c7; width: 100%; margin: 10px 0px; margin-top: 20px;">
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
                                class="delete-shop-btn" style="margin: 20px 0px 5px; display: flex; align-items: center; gap: 2px; width: 100%; font-size: 13px;">
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
            border-bottom: 1px solid #ddd;
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
            font-size: 14px; 
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
    </style>

    <script>
        //Modal functions
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
    </script>
</x-app-layout>