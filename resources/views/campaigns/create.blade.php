<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-white">
                {{ __('Create Campaign') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-8 bg-[#18181b] border border-[#232326] rounded-2xl shadow-xl">
                <form action="{{ route('campaigns.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Campaign Name')" class="text-base font-semibold text-white" />
                        <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-xl border-[#232326] bg-[#232326] text-white shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-3" required />
                        <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="template_id" :value="__('Template')" class="text-base font-semibold text-white" />
                        <select id="template_id" name="template_id" class="mt-2 block w-full rounded-xl border-[#232326] bg-[#232326] text-white shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-3" required>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2 text-red-400" :messages="$errors->get('template_id')" />
                    </div>

                    <div>
                        <x-input-label for="email_list_id" :value="__('Email List')" class="text-base font-semibold text-white" />
                        <select id="email_list_id" name="email_list_id" class="mt-2 block w-full rounded-xl border-[#232326] bg-[#232326] text-white shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-3" required>
                            @foreach ($emailLists as $list)
                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email_list_id')" />
                    </div>

                    <div>
                        <x-input-label for="scheduled_at" :value="__('Send At')" class="text-base font-semibold text-white" />
                        <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-2 block w-full rounded-xl border-[#232326] bg-[#232326] text-white shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-3" required min="{{ now()->format('Y-m-d\TH:i') }}" />
                        <x-input-error class="mt-2 text-red-400" :messages="$errors->get('scheduled_at')" />
                    </div>

                    <div class="flex items-center gap-4 justify-end mt-8">
                        <x-primary-button class="px-5 py-2 rounded-full font-semibold text-base text-white bg-blue-600 hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-800 shadow-xl transition-all duration-200">
                            {{ __('Schedule Campaign') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>