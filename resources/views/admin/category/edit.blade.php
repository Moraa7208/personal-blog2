<x-app-layout>
    <x-slot name="header">
        Edit category
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                        @method('PUT')
                        @csrf
                        <div>
                            <x-label class="block text-sm text-gray-600" for="category_name"/>Name
                            <x-input id="category_name" class="block w-full mt-1" name="category_name" type="text" value="{{ $category->category_name }}" required/>
                            @error('category_name')
                            <span class="font-medium text-red-600" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-6">
                            <x-button>Submit</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
