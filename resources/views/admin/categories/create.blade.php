<x-admin-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Category') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">Please correct the errors below:</span>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="list-disc ml-5">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="parent_product_category_id" class="block text-sm font-medium text-gray-700">Parent Category (Optional)</label>
                            <select name="parent_product_category_id" id="parent_product_category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- None (Top Level) --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('parent_product_category_id') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-6 ">
                            <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded shadow-lg transition duration-300 ease-in-out">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded shadow-lg transition duration-300 ease-in-out">
                                Save Category
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>