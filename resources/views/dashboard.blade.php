<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Email Lists -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Email Lists</div>
                            <a href="{{ route('email-lists.create') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalEmailLists }}</div>
                    </div>
                </div>

                <!-- Total Templates -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Templates</div>
                            <a href="{{ route('email-templates.create') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalTemplates }}</div>
                    </div>
                </div>

                <!-- Total Campaigns -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Campaigns</div>
                            <a href="{{ route('campaigns.create') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalCampaigns }}</div>
                    </div>
                </div>
            </div>

            <!-- Campaign Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Overall Campaign Status -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Campaign Status Overview</h3>
                            
                        </div>
                        <div class="space-y-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                    'processing' => 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200',
                                    'completed' => 'bg-gray-300 text-gray-800 dark:bg-gray-500 dark:text-gray-200',
                                    'failed' => 'bg-gray-400 text-gray-800 dark:bg-gray-400 dark:text-gray-200'
                                ];
                            @endphp
                            @foreach(['pending', 'processing', 'completed', 'failed'] as $status)
                                <div class="flex justify-between items-center">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$status] }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                    <span class="text-gray-900 dark:text-white font-medium">
                                        {{ $campaignStats[$status] ?? 0 }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Monthly Statistics -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">This Month's Campaigns</h3>
                            
                        </div>
                        <div class="space-y-4">
                            @foreach(['pending', 'processing', 'completed', 'failed'] as $status)
                                <div class="flex justify-between items-center">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$status] }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                    <span class="text-gray-900 dark:text-white font-medium">
                                        {{ $monthlyStats[$status] ?? 0 }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Campaigns -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Campaigns</h3>
                       
                    </div>
                    <div class="space-y-4">
                        @forelse($recentCampaigns as $campaign)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <div class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $campaign->subject }}
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Template: {{ $campaign->template->name }} | 
                                        List: {{ $campaign->emailList->name }} |
                                        Created: {{ $campaign->created_at->format('M d, Y H:i') }}
                                    </div>
                                    <div class="mt-2">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$campaign->status] }}">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">No campaigns found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
