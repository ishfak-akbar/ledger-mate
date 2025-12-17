<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shop Settings - {{ $shop->name }}
            </h2>
            <a href="{{ route('shops.show', $shop) }}" class="back-btn">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Shop
            </a>
        </div>
    </x-slot>

    <div class="settings-container">
        <div class="settings-form">

            @if(session('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('shops.settings.update', $shop) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <!-- Shop Name -->
                    <div class="form-group">
                        <label>Shop Name</label>
                        <input type="text" name="name" value="{{ old('name', $shop->name) }}" required />
                        @error('name')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category">
                            <option value="retail" {{ old('category') == 'retail' ? 'selected' : '' }}>Retail</option>
                            <option value="wholesale" {{ old('category') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                            <option value="restaurant" {{ old('category') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                            <option value="cafe" {{ old('category') == 'cafe' ? 'selected' : '' }}>Cafe</option>
                            <option value="grocery" {{ old('category') == 'grocery' ? 'selected' : '' }}>Grocery</option>
                            <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                            <option value="pharmacy" {{ old('category') == 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                            <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group full-width">
                        <label>Address (Optional)</label>
                        <textarea name="address" rows="2">{{ old('address', $shop->address) }}</textarea>
                        @error('address')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="form-group full-width">
                        <label>Notes (Optional)</label>
                        <textarea name="notes" rows="3">{{ old('notes', $shop->notes) }}</textarea>
                        @error('notes')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <a href="{{ route('shops.show', $shop) }}" class="back-btn-large">
                        Back to Shop
                    </a>

                    <button type="submit" class="save-btn">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .settings-container {
            background: #ffffff;
            min-height: calc(100vh - 64px);
            padding: 40px 20px;
        }

        .settings-form {
            max-width: 900px;
            margin: 0 auto;
        }

        .success-alert {
            background: #d1fae5;
            color: #065f46;
            padding: 14px 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            margin-bottom: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .error-msg {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .back-btn-large {
            display: inline-flex;
            align-items: center;
            padding: 12px 28px;
            background: transparent;
            color: #6b7280;
            font-weight: 600;
            font-size: 15px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-btn-large:hover {
            border-color: #9ca3af;
            color: #374151;
        }

        .save-btn {
            display: inline-flex;
            align-items: center;
            padding: 14px 36px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            font-weight: 600;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .save-btn:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-2px);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            color: #dc2626;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: #991b1b;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-app-layout>