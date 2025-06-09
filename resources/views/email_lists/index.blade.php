<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-white">
                {{ __('Email Lists') }}
            </h2>
            <a href="{{ route('email-lists.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white text-black text-sm font-medium rounded-xl shadow-xl hover:bg-gray-100 hover:scale-105 transition-all duration-300
">
                + Create List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-900 text-green-200 border border-green-700 shadow-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($emailLists->isEmpty())
                <div class="text-center p-8 bg-[#18181b] rounded-2xl shadow-xl border border-[#232326]">
                    <div class="text-gray-400 text-lg mb-4">
                        No email lists found. Create your first list!
                    </div>
                    <a href="{{ route('email-lists.create') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-[#232326] text-white text-sm font-medium rounded-xl shadow-xl hover:bg-[#23232c] hover:scale-105 transition-all duration-300">
                        + Create List
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($emailLists as $list)
                        <div class="p-6 bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold text-white hover:text-gray-200 transition-colors">
                                        {{ $list->name }}
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-400">
                                        Total: {{ $list->entries_count }} 
                                        (Valid: <span class="text-green-400 font-semibold">{{ $list->valid_entries_count }}</span>, 
                                        Invalid: <span class="text-red-400 font-semibold">{{ $list->invalid_entries_count }}</span>)
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('email-lists.show', $list) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-white text-black text-sm font-medium rounded-xl shadow-xl hover:bg-gray-100 hover:scale-105 transition-all duration-300">
                                        View Details
                                    </a>
                                    <form method="POST" action="{{ route('email-lists.destroy', $list) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this list?')"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-xl shadow-xl hover:bg-red-700 hover:scale-105 transition-all duration-300">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>