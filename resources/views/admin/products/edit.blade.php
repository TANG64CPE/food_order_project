<x-admin-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}: {{ $product->name }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                       @endif

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label for="product_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="product_category_id" id="product_category_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{-- เช็กค่าเก่า --}}
                                            @if(old('product_category_id', $product->product_category_id) == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (Baht)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" 
                                       step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label for="stock_qty" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                <input type="number" name="stock_qty" id="stock_qty" value="{{ old('stock_qty', $product->stock_qty) }}" 
                                       min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="image_url" class="block text-sm font-medium text-gray-700">Product Image (Optional - Leave blank to keep old image)</label>
                            @if ($product->image_url)
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded my-2">
                            @endif
                            <input type="file" name="image_url" id="image_url" 
                                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('products.index') }}" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded shadow-lg">Cancel</a>
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded shadow-lg">
                                Update Product </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>