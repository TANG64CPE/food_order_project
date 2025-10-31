<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Order History') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @forelse ($orders as $order)
                        <div class="border rounded-lg p-4 mb-6 shadow">
                            <div class="flex justify-between items-center border-b pb-3 mb-3">
                                <div>
                                    <h3 class="font-bold text-lg">Order #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-500">Placed on: {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                    @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                    @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="mb-4">
                                @foreach ($order->orderDetails as $item)
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex items-center">
                                            @if($item->product->image_url)
                                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded mr-4">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded mr-4"></div>
                                            @endif
                                            <div>
                                                <p class="font-medium">{{ $item->product->name }}</p>
                                                <p class="text-sm text-gray-600">Qty: {{ $item->order_qty }} x ฿{{ number_format($item->unit_price, 2) }}</p>
                                            </div>
                                        </div>
                                        <p class="font-medium">฿{{ number_format($item->line_total, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t pt-3 text-sm text-gray-600">
                                <p><strong>Ship to:</strong> {{ $order->shipping_address }}</p>
                                <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                            </div>
                            
                            <div class="text-right font-bold text-xl mt-4">
                                Total: ฿{{ number_format($order->total_amount, 2) }}
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">You have no orders yet.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>