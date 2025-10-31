<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Shopping Cart') }}
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
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('cart') && count(session('cart')) > 0)
                        
                        <table class="w-full table-auto border-collapse text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900" colspan="2">Product</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Price</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Quantity</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Subtotal</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                
                                @php $total = 0; @endphp
                                @foreach (session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            @if ($details['image_url'])
                                                <img src="{{ asset('storage/' . $details['image_url']) }}" alt="{{ $details['name'] }}" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded"></div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $details['name'] }}</td>
                                        <td class="px-6 py-4">฿{{ number_format($details['price'], 2) }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                                       min="1" class="w-16 text-center border-gray-300 rounded-md shadow-sm">
                                                <button type="submit" class="ml-2 text-sm text-blue-600 hover:text-blue-900">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">฿{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-right mt-6">
                            <h3 class="text-xl font-bold">Total: ฿{{ number_format($total, 2) }}</h3>
                            
                            <a href="{{ route('checkout.index') }}" 
                            class="mt-4 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg transition duration-300 ease-in-out">
                                Proceed to Checkout
                            </a>
                        </div>

                    @else
                        <p class="text-center text-gray-500">Your cart is empty.</p>
                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-900">Continue Shopping</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>