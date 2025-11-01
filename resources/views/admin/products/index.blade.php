<x-admin-layout>
    <x-slot:header>
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>

            <a href="{{ route('products.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded shadow-lg transition duration-300 ease-in-out">
                + Create New Product
            </a>
        </div>
    </x-slot:header>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full table-auto border-collapse bg-white text-center text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Image</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Name</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Category</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Price</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Stock</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 ">
                                        <td class="px-6 py-4 ">
                                            @if ($product->image_url)
                                                <img src="{{ asset('storage/' . $product->image_url) }}" 
                                                    alt="{{ $product->name }}" 
                                                    class="w-16 h-16 object-cover rounded object-center mx-auto">
                                            @else
                                                <span class="text-xs text-gray-400">No Image</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4">
                                            {{ $product->productCategory->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">{{ number_format($product->price, 2) }}</td>
                                        <td class="px-6 py-4">{{ $product->stock_qty }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-4">
                                                <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No products found.
                                        </td>
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