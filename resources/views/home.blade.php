<x-app-layout> {{-- 1. ใช้ Layout หลักของ Breeze (ที่มี Navbar) --}}

    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Our Menu') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if ($product->image_url)
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>

                            <span class="text-sm text-gray-500">{{ $product->productCategory->name ?? '' }}</span>

                            <p class="mt-2 text-gray-600">{{ $product->description }}</p>

                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-900">฿{{ number_format($product->price, 2) }}</span>

                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No products available at this moment.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>