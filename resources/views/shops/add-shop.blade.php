{{-- resources/views/shops/add-shop.blade.php --}}
<x-guest-layout>
    @section('styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #ffd4d4, #ffe8e8, rgba(255,255,255,0.7), #ffd4d4 80%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: rgba(255,255,255,0.9);
            padding: 35px 27px;
            border-radius: 12px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.16);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.5);
            width: 600px;
            max-width: 90vw;
            margin-top: 20px;
        }
        .card h2 {
            font-size: 23px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1px;
            text-align: center;
        }

        .card p {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: #000000;
            margin-bottom: 5px;
            text-align: left;
        }
        .form-group span{
            color: #6b7280;
            font-weight: 300;
            margin-left: 7px;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 7px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 400;
            background: white;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }
        .form-input{
            margin-bottom: 7px;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 5px rgba(220,38,38,0.15);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 20px;
            padding-right: 40px;
            cursor: pointer;
            margin-bottom: 7px;
        }

        .form-textarea {
            min-height: 70px;
            resize: vertical;
        }

        .btn {
            width: 100%;
            background: radial-gradient(circle, rgba(255,71,71,1) 40%, rgba(220,38,38,1) 100%);
            color: white;
            border: none;
            padding: 7px;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 12px 35px rgba(220,38,38,0.4);
            transition: all 0.3s;
            margin-top: 8px;
        }

        .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 45px rgba(220,38,38,0.5);
        }

        .btn:active {
            transform: translateY(-2px);
        }

        .back-link {
            margin-top: 26px;
            font-size: 13px;
            text-align: center;
        }

        .back-link a {
            color: #dc2626;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .back-link a:hover {
            color: #b91c1c;
        }

        .back-link a::before {
            content: "←";
            margin-right: 6px;
            font-size: 16px;
            margin-top: -5px;
        }

        .error-message {
            font-size: 12px;
            color: #dc2626;
            margin-top: 6px;
            text-align: left;
            font-weight: 500;
        }

        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #065f46;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            text-align: center;
        }
    </style>
    @endsection

    <div class="card">
        <h2>Add New Shop</h2>
        <p>Enter the details below to add a new shop to your account</p>

        <!-- Success Message -->
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('shops.store') }}">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Shop Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Enter shop name" 
                    class="form-input @error('name') !border-red-500 @enderror" 
                    required 
                    autofocus
                >
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <textarea 
                    id="address" 
                    name="address" 
                    placeholder="Enter shop address" 
                    class="form-textarea @error('address') !border-red-500 @enderror" 
                    required
                    rows="2"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <select 
                    id="category" 
                    name="category" 
                    class="form-select @error('category') !border-red-500 @enderror" 
                    required
                >
                    <option value="" disabled selected>Select a category</option>
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
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Notes <span>(Optional)</span></label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    placeholder="Any additional notes about the shop" 
                    class="form-textarea @error('notes') !border-red-500 @enderror"
                    rows="3"
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn">
                Add Shop
            </button>

            <div class="back-link">
                <a href="{{ route('dashboard') }}">Back to Dashboard</a>
            </div>
        </form>
    </div>
</x-guest-layout>