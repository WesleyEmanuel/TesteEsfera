<x-app-layout>
    @if (session('success'))
        <x-alert color="success" :text="session('success')"></x-alert>
    @endif
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __($task->title) }}
        </h2>
    </x-slot>

    <div class="py-12 flex items-center justify-center">
        <div class="py-12 w-50">
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
        <div class="py-12 w-50">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white h-[400px] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="table-header flex items-center justify-between pb-2">
                            <h1 class="text-lg">Usuários vinculados</h1>
                            <form action="{{ route('tasks.user', ['taskId' => $task->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <x-select id="users" class="block mt-1" name="users" required autocomplete="users"
                                    onchange="this.form.submit()">
                                    <option value="" selected>Vincular usuário</option>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                    @endforelse
                                </x-select>
                            </form>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($usersTask as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td class="ellipsis">{{ $user->name }}</td>
                                        <td>
                                            <form
                                                action="{{ route('tasks.user.unlink', ['task' => $task->id, 'user' => $user->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <button tooltip="Desvincular" data-toggle="tooltip" data-placement="top"
                                                    title="Desvincular usuário da tarefa"
                                                    onclick="return confirm('Tem certeza que deseja desvincular este usuário dessa tarefa?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
