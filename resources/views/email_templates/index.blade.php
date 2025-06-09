<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-white">
                {{ __('Email Templates') }}
            </h2>
            <a href="{{ route('email-templates.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white text-black text-sm font-medium rounded-xl shadow-xl hover:bg-gray-100 hover:scale-105 transition-all duration-300">
                + Create Template
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-900 text-green-200 border border-green-700 shadow-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($templates->isEmpty())
                <div class="text-center p-8 bg-[#18181b] rounded-2xl shadow-xl border border-[#232326]">
                    <div class="text-gray-400 text-lg mb-4">
                        No templates found. Create your first template!
                    </div>
                    <a href="{{ route('email-templates.create') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-[#232326] text-white text-sm font-medium rounded-xl shadow-xl hover:bg-[#23232c] hover:scale-105 transition-all duration-300">
                        + Create Template
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templates as $template)
                        <div class="bg-[#18181b] rounded-2xl shadow-xl border border-[#232326] hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-white hover:text-gray-200 transition-colors">
                                    {{ $template->name }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-400">{{ $template->subject }}</p>
                                <div class="flex justify-end space-x-3 mt-4">
                                    <a href="{{ route('email-templates.edit', $template) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-white text-black text-sm font-medium rounded-xl shadow-xl hover:bg-gray-100 hover:scale-105 transition-all duration-300">
                                        Edit
                                    </a>
                                    <form action="{{ route('email-templates.destroy', $template) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this template?')"
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
