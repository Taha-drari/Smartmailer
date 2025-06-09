<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white sm:text-3xl sm:truncate">Create Email Template</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('email-templates.index') }}" class="inline-flex items-center px-5 py-2 rounded-full font-semibold text-base text-white bg-[#232326] hover:bg-[#23232c] focus:bg-[#23232c] active:bg-[#23232c] shadow-xl transition-all duration-200">
                        Back to Templates
                    </a>
                </div>
            </div>

            <form action="{{ route('email-templates.store') }}" method="POST" class="space-y-8 bg-[#18181b] shadow-xl rounded-2xl p-8">
                @csrf
                <div>
                    <label for="name" class="block text-base font-semibold text-white">Template Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow rounded-xl border-[#232326] bg-[#232326] text-white text-base px-4 py-3 @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-base font-semibold text-white">Email Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        class="mt-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow rounded-xl border-[#232326] bg-[#232326] text-white text-base px-4 py-3 @error('subject') border-red-400 @enderror">
                    @error('subject')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-base font-semibold text-white">Email Body</label>
                    <textarea name="body" id="body" rows="10" required
                        class="mt-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow rounded-xl border-[#232326] bg-[#232326] text-white text-base px-4 py-3 @error('body') border-red-400 @enderror">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-5 py-2 rounded-full font-semibold text-base text-white bg-blue-600 hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-800 shadow-xl transition-all duration-200">
                        Create Template
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
