<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __($task->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('tasks.update', $task->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="title" :value="__('Título')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title', $task->title)" required autofocus autocomplete="title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Descrição')" />
                            <x-textarea id="description" name="description" class="mt-1 block w-full"
                                value="{{ old('description', $task->description) }}"
                                autocomplete="description"></x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select id="status" class="block mt-1 w-full" name="status" required
                                autocomplete="status">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected="true"' : '' }}>
                                    {{ __('Pendente') }}</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected=true' : '' }}>
                                    {{ __('Concluída') }}</option>
                            </x-select>

                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                        </div>
                    </form>
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
