<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Coming Soon !") }}
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Send Invitation') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <table class="mt-8 w-full text-left text-sm text-gray-500 bg-indigo-200">
                        <thead class="text-xs uppercase text-gray-700">
                        <th scope="col" class="px-6 py-3 text-left">{{ __('Email') }}</th>
                        <th scope="col" class="px-6 py-3 text-left">{{ __('Sent on') }}</th>
                        <th scope="col" class="px-6 py-3 text-left">{{ __('Accepted at') }}</th>
                        </thead>
                        <tbody>
                        @foreach ($invitations as $invitation)
                            <tr  @class(['bg-green-300' => !is_null($invitation->accepted_at),'bg-red-300' => is_null($invitation->accepted_at)])>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $invitation->email }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $invitation->created_at }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $invitation->accepted_at }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
