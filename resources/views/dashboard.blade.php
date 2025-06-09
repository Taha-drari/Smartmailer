<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight tracking-tight">
            {{ __('Good afternoon, ') }}{{ Auth::user()->name ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#111112] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                @php
                    $cards = [
                        ['label' => 'Total Email Lists', 'value' => $totalEmailLists, 'route' => route('email-lists.create')],
                        ['label' => 'Total Templates', 'value' => $totalTemplates, 'route' => route('email-templates.create')],
                        ['label' => 'Total Campaigns', 'value' => $totalCampaigns, 'route' => route('campaigns.create')],
                    ];
                @endphp

                @foreach($cards as $card)
                    <div class="bg-[#18181b] rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 flex flex-col items-center justify-center py-10 cursor-pointer group">
                        <div class="text-white text-xl font-semibold mb-2 group-hover:text-gray-200 transition">{{ $card['label'] }}</div>
                        <div class="text-4xl font-bold text-white mb-4">{{ $card['value'] }}</div>
                        <a href="{{ $card['route'] }}" class="px-4 py-2 rounded-lg bg-white text-black font-semibold text-sm shadow hover:bg-gray-200 transition">Create</a>
                    </div>
                @endforeach
            </div>

            <!-- Campaign Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-900 text-yellow-200',
                        'processing' => 'bg-blue-900 text-blue-200',
                        'completed' => 'bg-green-900 text-green-200',
                        'failed' => 'bg-red-900 text-red-200'
                    ];
                @endphp

                <!-- Overall Campaign Status -->
                <div class="bg-[#18181b] rounded-2xl shadow-xl p-8">
                    <h3 class="text-lg font-semibold text-white mb-6">Campaign Status Overview</h3>
                    <div class="space-y-6">
                        @foreach(['pending', 'processing', 'completed', 'failed'] as $status)
                            <div class="flex justify-between items-center">
                                <span class="px-4 py-2 text-base font-semibold rounded-full {{ $statusColors[$status] }}">
                                    {{ ucfirst($status) }}
                                </span>
                                <span class="text-white font-bold text-lg">
                                    {{ $campaignStats[$status] ?? 0 }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Monthly Statistics -->
                <div class="bg-[#18181b] rounded-2xl shadow-xl p-8">
                    <h3 class="text-lg font-semibold text-white mb-6">This Month's Campaigns</h3>
                    <div class="space-y-6">
                        @foreach(['pending', 'processing', 'completed', 'failed'] as $status)
                            <div class="flex justify-between items-center">
                                <span class="px-4 py-2 text-base font-semibold rounded-full {{ $statusColors[$status] }}">
                                    {{ ucfirst($status) }}
                                </span>
                                <span class="text-white font-bold text-lg">
                                    {{ $monthlyStats[$status] ?? 0 }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Campaigns -->
            <div class="bg-[#18181b] rounded-2xl shadow-xl p-8">
                <h3 class="text-lg font-semibold text-white mb-6">Recent Campaigns</h3>
                <div class="space-y-4">
                    @forelse($recentCampaigns as $campaign)
                        <div class="flex items-center justify-between p-4 bg-[#232326] rounded-xl hover:bg-[#23232c] hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <div class="flex-1">
                                <div class="text-lg font-semibold text-white">
                                    {{ $campaign->subject }}
                                </div>
                                <div class="mt-1 text-sm text-gray-400">
                                    Template: {{ $campaign->template->name }} | 
                                    List: {{ $campaign->emailList->name }} |
                                    Created: {{ $campaign->created_at->format('M d, Y H:i') }}
                                </div>
                                <div class="mt-2">
                                    <span class="px-4 py-2 text-xs font-semibold rounded-full {{ $statusColors[$campaign->status] }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400">No campaigns found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
