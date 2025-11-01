<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot:header>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- (แสดงข้อความ Success/Error) --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{-- (แนะนำ) ทำให้ ID เป็นลิงก์ไปหน้า Show --}}
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->user->first_name }} {{ $order->user->last_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">฿{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                            @if($order->status == 'processing') bg-blue-100 text-blue-800 @endif
                                            @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                            @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{-- เพิ่ม Logic การ Disabled --}}
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <select name="status" 
                                                    onchange="this.form.submit()" 
                                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                           @if($order->status == 'completed' || $order->status == 'cancelled') bg-gray-100 cursor-not-allowed @endif"
                                                    
                                                    {{-- นี่คือส่วนที่สำคัญที่สุด --}}
                                                    @if($order->status == 'completed' || $order->status == 'cancelled')
                                                        disabled
                                                    @endif
                                            >
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

