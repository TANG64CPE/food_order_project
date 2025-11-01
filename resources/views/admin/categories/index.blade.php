<x-admin-layout>
    <x-slot:header>
        <div class="flex justify-between items-center">
            
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Categories') }}
            </h2>
            
            <a href="{{ route('categories.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded shadow-lg transition duration-300 ease-in-out">
                + Create New Category
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
                        <table class="w-full border-collapse bg-white text-center text-sm text-gray-500">
                            <thead class="bg-gray-50 ">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">ID</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Name</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Parent ID</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                
                                @forelse ($categories as $category)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-6 py-4 ">{{ $category->id }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                                        <td class="px-6 py-4">{{ $category->parent_product_category_id ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-4">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No categories found.
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