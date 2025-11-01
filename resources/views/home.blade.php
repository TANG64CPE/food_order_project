<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Our Menu') }}
        </h2>
    </x-slot:header>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- (1. ส่วนของ Filter Categories ที่เราทำไป) --}}
            <div class="flex flex-wrap gap-2 mb-8">
                {{-- ปุ่ม "All" --}}
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium 
                          {{ !request('category') ? 'bg-indigo-600 text-white shadow' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    All
                </a>

                {{-- วน Loop Categories --}}
                @foreach ($categories as $category)
                    <a href="{{ route('home', ['category' => $category->name]) }}"
                       class="px-4 py-2 rounded-md text-sm font-medium 
                              {{ request('category') == $category->name ? 'bg-indigo-600 text-white shadow' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            {{-- (2. ส่วนของ Product Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @forelse ($products as $product)
                    {{-- ▼▼▼ [แก้ไข] เพิ่ม class 4 ตัวนี้ลงไปใน div หลัก ▼▼▼ --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden
                                transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        
                        {{-- (ส่วนรูปภาพ) --}}
                        @if($product->image_url)
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        
                        {{-- (ส่วนเนื้อหาการ์ด) --}}
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $product->productCategory->name ?? 'Uncategorized' }}</p>
                            <p class="text-sm text-gray-700 h-20 overflow-hidden mb-4">{{ $product->description }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xl font-bold text-indigo-600">฿{{ number_format($product->price, 2) }}</span>
                            </div>

                            {{-- (ปุ่ม Add to Cart - ซ่อนถ้าเป็น Admin) --}}
                            @if( ! (auth()->user()?->is_admin ?? false) )
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg font-semibold 
                                                   hover:bg-indigo-700 focus:outline-none focus:ring-2 
                                                   focus:ring-indigo-500 focus:ring-opacity-50 transition-colors">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 md:col-span-3">No products found for this category.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
