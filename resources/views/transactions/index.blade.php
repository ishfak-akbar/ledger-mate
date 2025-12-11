<div class="overflow-x-auto">
    <table class="transactions-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date->format('M d, Y') }}</td>
                <td>
                    <div class="font-medium">{{ $transaction->customer_name ?: 'Walk-in' }}</div>
                    @if($transaction->customer_phone)
                    <div class="text-xs text-gray-500">{{ $transaction->customer_phone }}</div>
                    @endif
                </td>
                <td class="font-semibold">₹{{ number_format($transaction->total_amount, 2) }}</td>
                <td class="text-green-600 font-semibold">₹{{ number_format($transaction->paid_amount, 2) }}</td>
                <td class="{{ $transaction->due_amount > 0 ? 'text-red-600' : 'text-green-600' }} font-semibold">
                    ₹{{ number_format($transaction->due_amount, 2) }}
                    @if($transaction->due_amount > 0)
                    <div class="text-xs {{ $transaction->due_amount > 0 ? 'text-red-500' : 'text-green-500' }}">
                        (Pending)
                    </div>
                    @else
                    <div class="text-xs text-green-500">
                        (Paid)
                    </div>
                    @endif
                </td>
                <td>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</td>
                <td>
                    <a href="{{ route('transactions.show', [$shop, $transaction]) }}" class="view-link">
                        View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>