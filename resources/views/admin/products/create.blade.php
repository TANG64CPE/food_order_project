<x-admin-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Product') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="list-disc ml-5">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label for="product_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="product_category_id" id="product_category_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(old('product_category_id') == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (Baht)</label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" 
                                       step="0.01" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label for="stock_qty" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                <input type="number" name="stock_qty" id="stock_qty" value="{{ old('stock_qty') }}" 
                                       min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="product_number" class="block text-sm font-medium text-gray-700">Product Number (SKU) (Optional)</label>
                            <input type="text" name="product_number" id="product_number" value="{{ old('product_number') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="image_url" class="block text-sm font-medium text-gray-700">Product Image (Optional)</label>
                            <input type="file" name="image_url" id="image_url" 
                                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Save Product
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>