{{-- resources/views/shops/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shop Details
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('shops.index') }}" class="back-btn">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Shops
                </a>
                <a href="{{ route('dashboard') }}" class="dashboard-btn">
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="shop-details-container">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="shop-details-card">
                <!-- Shop Header -->
                <div class="shop-header">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="shop-title">{{ $shop->name }}</h1>
                            <div class="flex items-center mt-2">
                                <span class="shop-category-badge 
                                    @if($shop->category == 'retail') category-retail
                                    @elseif($shop->category == 'restaurant') category-restaurant
                                    @elseif($shop->category == 'grocery') category-grocery
                                    @else category-other @endif">
                                    {{ ucfirst($shop->category) }}
                                </span>
                                <span class="shop-id ml-3">
                                    ID: {{ $shop->id }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shop Details Grid -->
                <div class="shop-details-grid">
                    <!-- Left Column: Shop Information -->
                    <div class="shop-info-section">
                        <h3 class="section-title">Shop Information</h3>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Shop Name
                            </div>
                            <div class="info-value">{{ $shop->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Address
                            </div>
                            <div class="info-value whitespace-pre-line">{{ $shop->address }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Category
                            </div>
                            <div class="info-value">{{ ucfirst($shop->category) }}</div>
                        </div>

                        @if($shop->notes)
                        <div class="info-item">
                            <div class="info-label">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Notes
                            </div>
                            <div class="info-value whitespace-pre-line">{{ $shop->notes }}</div>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column: Quick Actions & Statistics -->
                    <div class="sidebar-section">
                        <h3 class="section-title">Quick Actions</h3>
                        
                        <div class="action-buttons">
                            <a href="{{ route('transactions.create', $shop) }}" class="action-btn add-transaction-btn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Transaction
                            </a>
                            
                            <a href="#" class="action-btn view-transactions-btn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View Transactions
                            </a>
                            
                            <a href="#" class="action-btn generate-report-btn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Generate Report
                            </a>
                        </div>

                        <!-- Shop Statistics -->
                        <div class="stats-section">
                            <h3 class="section-title mt-6">Shop Statistics</h3>
                            
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-label">Total Transactions</div>
                                    <div class="stat-value">{{ $shop->transactions()->count() }}</div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-label">Total Amount</div>
                                    <div class="stat-value">₹{{ number_format($shop->transactions()->sum('total_amount'), 2) }}</div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-label">Total Paid</div>
                                    <div class="stat-value">₹{{ number_format($shop->transactions()->sum('paid_amount'), 2) }}</div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-label">Total Due</div>
                                    <div class="stat-value">₹{{ number_format($shop->transactions()->sum('due_amount'), 2) }}</div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-label">Fully Paid</div>
                                    <div class="stat-value">{{ $shop->transactions()->where('due_amount', 0)->count() }}</div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-label">Pending Payment</div>
                                    <div class="stat-value">{{ $shop->transactions()->where('due_amount', '>', 0)->count() }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="metadata-section">
                            <h3 class="section-title mt-6">Metadata</h3>
                            
                            <div class="metadata-item">
                                <span class="metadata-label">Created:</span>
                                <span class="metadata-value">{{ $shop->created_at->format('F j, Y') }}</span>
                                <div class="metadata-time">{{ $shop->created_at->diffForHumans() }}</div>
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label">Last Updated:</span>
                                <span class="metadata-value">{{ $shop->updated_at->format('F j, Y') }}</span>
                                <div class="metadata-time">{{ $shop->updated_at->diffForHumans() }}</div>
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label">Shop ID:</span>
                                <span class="metadata-value">{{ $shop->id }}</span>
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label">Owner:</span>
                                <span class="metadata-value">{{ $shop->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .shop-details-container {
            padding: 2rem 0;
            background: #f9fafb;
            min-height: calc(100vh - 64px);
        }

        .shop-details-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
            overflow: hidden;
        }

        /* Header Buttons */
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

        .dashboard-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #dc2626;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .dashboard-btn:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        /* Shop Header */
        .shop-header {
            padding: 2rem;
            background: linear-gradient(135deg, #fef2f2 0%, #fff5f5 100%);
            border-bottom: 1px solid #fee2e2;
        }

        .shop-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .shop-category-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 9999px;
        }

        .category-retail {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .category-restaurant {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .category-grocery {
            background-color: #d1fae5;
            color: #065f46;
        }

        .category-other {
            background-color: #f3f4f6;
            color: #374151;
        }

        .shop-id {
            font-size: 0.875rem;
            color: #6b7280;
            background: #f3f4f6;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .shop-actions {
            display: flex;
            gap: 0.75rem;
        }

        .edit-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: #3b82f6;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .edit-btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        /* Shop Details Grid */
        .shop-details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        @media (min-width: 1024px) {
            .shop-details-grid {
                grid-template-columns: 2fr 1fr;
            }
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }

        /* Information Section */
        .shop-info-section {
            padding-right: 1rem;
        }

        .info-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1rem;
            color: #111827;
            line-height: 1.5;
            padding-left: 1.75rem;
        }

        /* Sidebar Section */
        .sidebar-section {
            background: #fafafa;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #f3f4f6;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: white;
            color: #374151;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .add-transaction-btn:hover {
            border-color: #dc2626;
            color: #dc2626;
        }

        .view-transactions-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .generate-report-btn:hover {
            border-color: #10b981;
            color: #10b981;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        /* Metadata */
        .metadata-section {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
        }

        .metadata-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .metadata-item:last-child {
            border-bottom: none;
        }

        .metadata-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .metadata-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
        }

        .metadata-time {
            font-size: 0.75rem;
            color: #9ca3af;
            width: 100%;
            text-align: right;
            margin-top: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .shop-header {
                padding: 1.5rem;
            }
            
            .shop-title {
                font-size: 1.5rem;
            }
            
            .shop-details-grid {
                padding: 1.5rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-app-layout>