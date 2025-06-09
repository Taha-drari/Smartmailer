<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-white">Create Email List</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-[#18181b] shadow-xl rounded-2xl">
                <form action="{{ route('email-lists.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf

                    <div class="space-y-8">
                        <div>
                            <label for="name" class="block text-base font-semibold text-white">List Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="block w-full rounded-xl border-[#232326] bg-[#232326] text-white shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-3">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-base font-semibold text-white">Description (Optional)</label>
                            <div class="mt-2">
                                <textarea name="description" id="description" rows="3"
                                    class="block w-full rounded-xl border-[#232326] bg-[#232326] text-white shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-3">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="csv_file" class="block text-base font-semibold text-white">Upload CSV File</label>
                            <div class="mt-2">
                                <div class="relative">
                                    <input type="file" name="csv_file" id="csv_file" accept=".csv" required
                                        class="block w-full text-base text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-base file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:transition-colors file:duration-200 file:focus:outline-none file:focus:ring-2 file:focus:ring-blue-500 file:focus:ring-offset-2 cursor-pointer border border-[#232326] rounded-xl bg-[#232326] shadow">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-400">Upload a CSV file containing email addresses</p>
                            </div>
                            @error('csv_file')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-8">
                            <a href="{{ route('email-lists.index') }}" 
                                class="inline-flex items-center px-5 py-2 rounded-full font-semibold text-base text-white bg-[#232326] hover:bg-[#23232c] focus:bg-[#23232c] active:bg-[#23232c] shadow-xl transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2 rounded-full font-semibold text-base text-white bg-blue-600 hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-800 shadow-xl transition-all duration-200">
                                Create List
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>