<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('shops.create') }}" 
                class="add-first-shop-btn">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Shop
            </a>
        </div>
    </x-slot>

    <div class="dashboard-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div id="success-notification" 
                    class="fixed top-0 left-0 right-0 z-50 transform -translate-y-full transition-all duration-500 ease-out flex justify-center">
                    <div class="mx-auto max-w-md mt-4 flex justify-center">
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow-xl">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                                <button onclick="closeNotification()" class="text-white hover:text-gray-200 ml-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="dashboard-card">
                <div class="dashboard-content">
                    @if($shops->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Welcome to Shop Manager</h3>
                            <p class="text-gray-600 mb-6">
                                {{ __("You're logged in!") }} Start by adding your first shop to manage transactions.
                            </p>
                            <a href="{{ route('shops.create') }}" 
                               class="add-first-shop-btn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Your First Shop
                            </a>
                        </div>
                    @else
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">My Shops ({{ $shops->count() }})</h3>
                            </div>
                            <a href="{{ route('shops.create') }}" 
                               class="add-another-shop-btn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Shop
                            </a>
                        </div>

                        <div class="shop-cards">
                            @foreach($shops as $shop)
                                <div class="shop-card">
                                    <div class="shop-card-header">
                                        <div class="flex justify-between items-start">
                                            <h4 class="shop-name">{{ $shop->name }}</h4>
                                            <span class="shop-category 
                                                @if($shop->category == 'retail') category-retail
                                                @elseif($shop->category == 'restaurant') category-restaurant
                                                @elseif($shop->category == 'grocery') category-grocery
                                                @else category-other @endif">
                                                {{ ucfirst($shop->category) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="shop-card-body">
                                        <div class="shop-info-item">
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="shop-address">{{ Str::limit($shop->address, 60) }}</span>
                                        </div>
                                        
                                        @if($shop->notes)
                                        <div class="shop-info-item mt-3">
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="shop-notes">{{ Str::limit($shop->notes, 50) }}</span>
                                        </div>
                                        @endif
                                        
                                        <div class="shop-info-item mt-3">
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="shop-date">Added {{ $shop->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="shop-card-footer">
                                        <a href="{{ route('shops.show', $shop) }}" class="view-shop-btn">
                                            Enter Shop
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notification = document.getElementById('success-notification');
            
            if (notification) {
                function showNotification() {
                    notification.classList.remove('-translate-y-full');
                    notification.classList.add('translate-y-0');
                }
                
                function hideNotification() {
                    notification.classList.remove('translate-y-0');
                    notification.classList.add('-translate-y-full');
                    
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 500);
                }
                
                function autoCloseNotification() {
                    setTimeout(hideNotification, 4000);
                }
                
                window.closeNotification = function() {
                    hideNotification();
                };
                
                setTimeout(showNotification, 100);
                
                autoCloseNotification();
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        hideNotification();
                    }
                });

                document.addEventListener('click', function(e) {
                    if (notification && !notification.contains(e.target)) {
                        hideNotification();
                    }
                });
            }
        });
    </script>
    @endif
    <style>
        #success-notification {
            pointer-events: auto;
        }
        
        #success-notification .bg-green-500 {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            }
            50% {
                box-shadow: 0 10px 25px rgba(16, 185, 129, 0.5);
            }
        }
        
        #success-notification button:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }

        .text-center{
            display: flex;
            justify-content: space-between;
        }

        .add-first-shop-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .add-first-shop-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
        }

        .add-first-shop-btn:active {
            transform: translateY(0);
        }

        /* .dashboard-container {
            padding-top: 2rem;
            padding-bottom: 2rem;
            background: #f9fafb;
        }

        .dashboard-card {
            background: white;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        } */

        .dashboard-content {
            padding: 1.5rem;
        }

        .dashboard-content .text-center .add-first-shop-btn {
            padding: 12px 24px;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
        }

        .dashboard-content .text-center .add-first-shop-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.4);
        }
        
        .add-another-shop-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .add-another-shop-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
        }


        /* Shop Card Styles */
        .shop-cards{
            margin-top: 15px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 250px));
            gap: 20px;
            margin-bottom: 30px;
        }
        .shop-card {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
            width: 100%;
        }

        .shop-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #dc2626;
        }

        .shop-card-header {
            padding: 1.25rem 1.25rem 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .shop-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .shop-category {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
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

        .shop-card-body {
            padding: 1rem 1.25rem;
        }

        .shop-info-item {
            display: flex;
            align-items: flex-start;
        }

        .shop-address {
            font-size: 0.875rem;
            color: #4b5563;
            line-height: 1.4;
        }

        .shop-notes {
            font-size: 0.875rem;
            color: #6b7280;
            font-style: italic;
            line-height: 1.4;
        }

        .shop-date {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .shop-card-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid #f3f4f6;
            background-color: #dc2626;
            margin-top: auto;
        }

        .view-shop-btn {
            display: flex; 
            justify-content: center; 
            align-items: center;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s;
            color: #ffffff;
        }

        .view-shop-btn:hover {
            color: #fef2f2; 
        } 

        @media (max-width: 768px) {
            .shop-cards {
                grid-template-columns: 1fr;
            }
            .flex.justify-between.items-center.mb-8 {
                flex-direction: column;
                align-items: flex-start;
            }
            .add-another-shop-btn {
                margin-top: 1rem;
            }
            #success-notification .mx-auto {
                margin-left: 1rem;
                margin-right: 1rem;
            }
        }
    </style>
</x-app-layout>