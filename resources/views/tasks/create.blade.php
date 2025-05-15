<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            Nova Tarefa
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @method('POST')
                        @csrf
                
                        <div>
                            <x-input-label for="title" :value="__('Titulo')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição')" />
                            <x-textarea id="description" class="block mt-1 w-full" name="description" :value="old('description')" autocomplete="description"></x-textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                
                            <x-select id="status" class="block mt-1 w-full"
                                            name="status"
                                            required autocomplete="status" >
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pendente') }}</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('Concluída') }}</option>                            
                            </x-select>
                
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                
                        <div class="flex items-center justify-center mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Salvar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
