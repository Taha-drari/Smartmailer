<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Campaigns') }}
            </h2>
            <a href="{{ route('campaigns.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg shadow hover:bg-gray-800 dark:hover:bg-gray-200 transition">
                + Create Campaign
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 border border-green-300 dark:border-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($campaigns->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400 text-lg">
                    No campaigns found. Create your first campaign!
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($campaigns as $campaign)
                        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition">

                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $campaign->subject }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                        <strong>Template:</strong> {{ $campaign->template->name }}<br>
                                        <strong>List:</strong> {{ $campaign->emailList->name }}<br>
                                        <strong>Scheduled:</strong> {{ $campaign->scheduled_at ? $campaign->scheduled_at->format('M d, Y H:i') : 'Immediately' }}
                                    </p>

                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        ];
                                        $statusColor = $statusColors[$campaign->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                    @endphp

                                    <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>

                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this campaign?')">
    @csrf
    @method('DELETE')
    <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md shadow hover:bg-red-700 transition">
        Delete
    </button>
</form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
