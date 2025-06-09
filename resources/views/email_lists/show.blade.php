<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-white">
                {{ $emailList->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('email-lists.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-white text-black text-sm font-medium rounded-xl shadow-xl hover:bg-gray-100 hover:scale-105 transition-all duration-300
">
                    Back to Lists
                </a>
                <form method="POST" action="{{ route('email-lists.destroy', $emailList) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to delete this list?')" 
                            class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-xl shadow-xl hover:bg-red-700 hover:scale-105 transition-all duration-300">
                        Delete List
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 p-6">
                    <div class="text-gray-400 text-sm font-medium">Total Emails</div>
                    <div class="mt-2 text-3xl font-bold text-white">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 p-6">
                    <div class="text-gray-400 text-sm font-medium">Valid Emails</div>
                    <div class="mt-2 text-3xl font-bold text-green-400">{{ $stats['valid'] }}</div>
                </div>
                <div class="bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 p-6">
                    <div class="text-gray-400 text-sm font-medium">Invalid Emails</div>
                    <div class="mt-2 text-3xl font-bold text-red-400">{{ $stats['invalid'] }}</div>
                </div>
                <div class="bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 p-6">
                    <div class="text-gray-400 text-sm font-medium">Valid Percentage</div>
                    <div class="mt-2 text-3xl font-bold text-blue-400">{{ $stats['valid_percentage'] }}%</div>
                </div>
            </div>

            <!-- Email List Table -->
            <div class="bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#232326]">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Checked</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#232326]">
                                @foreach($entries as $entry)
                                <tr class="hover:bg-[#232326] transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $entry->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $entry->is_valid ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                                            {{ $entry->is_valid ? 'Valid' : 'Invalid' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                        {{ $entry->updated_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $entries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('emailStatsChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Valid', 'Invalid'],
                    datasets: [{
                        data: [{{ $stats['valid'] }}, {{ $stats['invalid'] }}],
                        backgroundColor: [
                            'rgb(34, 197, 94)',  // green-500
                            'rgb(239, 68, 68)'   // red-500
                        ],
                        borderColor: [
                            'rgb(22, 163, 74)',  // green-600
                            'rgb(220, 38, 38)'   // red-600
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e5e7eb'
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 