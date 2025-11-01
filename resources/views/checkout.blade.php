<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot:header>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Your Order Summary</h3>
                        
                        @php $total = 0; @endphp
                        <ul class="divide-y divide-gray-200">
                            @foreach(session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <li class="py-4 flex">
                                    <img src="{{ asset('storage/' . $details['image_url']) }}" alt="{{ $details['name'] }}" class="w-16 h-16 object-cover rounded mr-4">
                                    <div class="flex-1">
                                        <h4 class="font-medium">{{ $details['name'] }}</h4>
                                        <p class="text-sm text-gray-500">Qty: {{ $details['quantity'] }}</p>
                                    </div>
                                    <span class="text-gray-900 font-medium">฿{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xl font-bold text-right">Total: ฿{{ number_format($total, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- <h3 class="text-lg font-semibold mb-4">Shipping Information</h3> -->
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="font-bold">Please correct the errors below:</span>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div class="p-3 bg-white rounded-lg shadow-md">
                            <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- บ้านเลขที่ / ถนน (ช่องนี้ให้กว้างหน่อย) -->
                                <div class="md:col-span-2">
                                    <label for="shipping_street_address" class="block text-sm font-medium text-gray-700 mb-1">
                                        ที่อยู่ (บ้านเลขที่, หมู่บ้าน, ถนน) *
                                    </label>
                                    <input type="text" id="shipping_street_address" name="shipping_street_address" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                </div>

                                <!-- ตำบล/แขวง -->
                                <div>
                                    <label for="shipping_subdistrict" class="block text-sm font-medium text-gray-700 mb-1">
                                        ตำบล/แขวง *
                                    </label>
                                    <input type="text" id="shipping_subdistrict" name="shipping_subdistrict" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                </div>

                                <!-- อำเภอ/เขต -->
                                <div>
                                    <label for="shipping_district" class="block text-sm font-medium text-gray-700 mb-1">
                                        อำเภอ/เขต *
                                    </label>
                                    <input type="text" id="shipping_district" name="shipping_district" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                </div>

                                <!-- จังหวัด -->
                                <div>
                                    <label for="shipping_province" class="block text-sm font-medium text-gray-700 mb-1">
                                        จังหวัด *
                                    </label>
                                    <input type="text" id="shipping_province" name="shipping_province" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                </div>

                                <!-- รหัสไปรษณีย์ -->
                                <div>
                                    <label for="shipping_postcode" class="block text-sm font-medium text-gray-700 mb-1">
                                        รหัสไปรษณีย์ *
                                    </label>
                                    <input type="text" id="shipping_postcode" name="shipping_postcode" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="shipping_phone" id="shipping_phone" 
                                       value="{{ old('shipping_phone', auth()->user()->phone) }}" {{-- ดึงเบอร์โทรที่สมัครไว้มาโชว์ --}}
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <div class="mt-2 p-4 border border-gray-300 rounded-md bg-gray-50">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="payment_method" value="cash_on_delivery" class="form-radio" checked>
                                        <span class="ml-2">Cash on Delivery (COD)</span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">We are only supporting Cash on Delivery at this moment.</p>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>