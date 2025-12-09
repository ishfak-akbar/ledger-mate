<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('shops.create') }}" 
               class="add-shop-btn">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Shop
            </a>
        </div>
    </x-slot>

    <div class="dashboard-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dashboard-card">
                <div class="dashboard-content">
                    <div class="text-center">
                        <div class="shop-icon">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <a href="{{ route('shops.create') }}" 
                           class="add-first-shop-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-center{
            display: flex;
            justify-content: space-between;
        }
        .add-shop-btn {
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

        .add-shop-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
        }

        .add-shop-btn:active {
            transform: translateY(0);
        }

        /* .dashboard-container {
            padding-top: 2rem;
            padding-bottom: 2rem;
            background: #f9fafb;
        } */

        /* .dashboard-card {
            background: white;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        } */

        .dashboard-content {
            padding: 1.5rem;
        }

        .shop-icon {
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .dashboard-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: #6b7280;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .add-first-shop-btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
        }

        .add-first-shop-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.4);
        }

        .add-first-shop-btn:active {
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .dashboard-container {
                padding: 1rem;
            }
            
            .dashboard-content {
                padding: 1rem;
            }
            
            .add-shop-btn,
            .add-first-shop-btn {
                padding: 8px 16px;
                font-size: 0.875rem;
            }
            
            .dashboard-title {
                font-size: 1.125rem;
            }
        }
    </style>
</x-app-layout>