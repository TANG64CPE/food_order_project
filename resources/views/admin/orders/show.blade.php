<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- (ส่วนหัว) --}}
            <div class="flex justify-between items-center">
                <span>Order Details #{{ $order->id }}</span>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    &larr; Back to all orders
                </a>
            </div>
        </h2>
    </x-slot:header>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- (คอลัมน์ซ้าย: ข้อมูล Order และ ลูกค้า) --}}
                <div class="md:col-span-1 space-y-6">
                    {{-- Order Summary --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg mb-4 border-b pb-2">Order Summary</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Order ID:</span>
                                    <span class="font-medium">#{{ $order->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Order Date:</span>
                                    <span class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Status:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                        @if($order->status == 'processing') bg-blue-100 text-blue-800 @endif
                                        @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                        @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between pt-2 border-t mt-2">
                                    <span class="font-bold text-base">Total Amount:</span>
                                    <span class="font-bold text-base">฿{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg mb-4 border-b pb-2">Customer & Shipping</h3>
                            <div class="space-y-2 text-sm">
                                <p class="font-medium">{{ $order->user->name }}</p>
                                <p class="text-gray-500">{{ $order->user->email }}</p>
                                <p class="text-gray-500">{{ $order->shipping_phone }}</p>
                                
                                <div class="pt-2 border-t mt-2">
                                    <p class="font-medium">Shipping Address:</p>
                                    <address class="not-italic text-gray-600">
                                        {{ $order->shipping_street_address }}<br>
                                        ต.{{ $order->shipping_subdistrict }}, อ.{{ $order->shipping_district }}<br>
                                        จ.{{ $order->shipping_province }} {{ $order->shipping_postcode }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- (คอลัมน์ขวา: รายการสินค้า) --}}
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg mb-4 border-b pb-2">Order Items</h3>
                            <div class="space-y-4">
                                @forelse ($order->orderDetails as $item)
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex items-center">
                                            @if($item->product->image_url)
                                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded mr-4"></div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-base">{{ $item->product->name }}</p>
                                                {{-- (ข้อผิดพลาดเล็กน้อยที่อาจเกิดขึ้น) ตรวจสอบว่าคุณมี unit_price และ line_total ใน OrderDetail --}}
                                                {{-- ถ้าไม่มี ให้ใช้ $item->product->price --}}
                                                <p class="text-sm text-gray-600">Qty: {{ $item->order_qty }} x ฿{{ number_format($item->unit_price ?? $item->product->price, 2) }}</p>
                                            </div>
                                        </div>
                                        <p class="font-medium text-lg">฿{{ number_format($item->line_total ?? ($item->order_qty * $item->product->price), 2) }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No items found for this order.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

