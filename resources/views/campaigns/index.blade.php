<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-white">
                {{ __('Campaigns') }}
            </h2>
            <a href="{{ route('campaigns.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white text-black text-sm font-medium rounded-xl shadow-xl hover:bg-gray-100 hover:scale-105 transition-all duration-300">
                + Create Campaign
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

            @if ($campaigns->isEmpty())
                <div class="text-center p-8 bg-[#18181b] rounded-2xl shadow-xl border border-[#232326]">
                    <div class="text-gray-400 text-lg mb-4">
                        No campaigns found. Create your first campaign!
                    </div>
                    <a href="{{ route('campaigns.create') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-[#232326] text-white text-sm font-medium rounded-xl shadow-xl hover:bg-[#23232c] hover:scale-105 transition-all duration-300">
                        + Create Campaign
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($campaigns as $campaign)
                        <div class="bg-[#18181b] rounded-2xl shadow-xl border border-[#232326] hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-white hover:text-gray-200 transition-colors">
                                    {{ $campaign->subject }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-400">
                                    <span class="font-medium">Template:</span> 
                                    <span class="hover:text-gray-200 transition-colors">{{ $campaign->template->name }}</span><br>
                                    <span class="font-medium">List:</span> 
                                    <span class="hover:text-gray-200 transition-colors">{{ $campaign->emailList->name }}</span><br>
                                    <span class="font-medium">Scheduled:</span> 
                                    <span class="hover:text-gray-200 transition-colors">
                                        {{ $campaign->scheduled_at ? $campaign->scheduled_at->format('M d, Y H:i') : 'Immediately' }}
                                    </span>
                                </p>

                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-900 text-yellow-200',
                                        'processing' => 'bg-blue-900 text-blue-200',
                                        'completed' => 'bg-green-900 text-green-200',
                                        'failed' => 'bg-red-900 text-red-200',
                                    ];
                                    $statusColor = $statusColors[$campaign->status] ?? 'bg-gray-700 text-gray-200';
                                @endphp

                                <div class="flex justify-between items-center mt-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }} transition-colors duration-300">
                                        {{ ucfirst($campaign->status) }}
                                    </span>

                                    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this campaign?')"
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
