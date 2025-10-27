@extends('layouts.admin')

@section('title', 'Edit Category') 

@section('admin_content')

    @if ($errors->any())
        @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 shadow-md rounded">
        @csrf
        @method('PUT') 

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="parent_product_category_id" class="block text-sm font-medium text-gray-700">Parent Category (Optional)</label>
            <select name="parent_product_category_id" id="parent_product_category_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- None (Top Level) --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" 

                            @if (old('parent_product_category_id', $category->parent_product_category_id) == $cat->id) selected @endif>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="submit" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Update Category 
            </button>
        </div>
    </form>

@endsection