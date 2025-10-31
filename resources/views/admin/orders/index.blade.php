<x-admin-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full table-auto border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Order ID</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Customer</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Total</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Order Date</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Update Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $order->user->first_name ?? 'Guest' }}</td>
                                        <td class="px-6 py-4">฿{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                                @if($order->status == 'processing') bg-blue-100 text-blue-800 @endif
                                                @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                                @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="rounded-md border-gray-300 shadow-sm text-sm" onchange="this.form.submit()">
                                                    <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                                    <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                                                    <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                                                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center">No orders found.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>