<x-app-layout>
    @if (session('success'))
        <x-alert color="success" :text="session('success')"></x-alert>
    @endif
    <x-slot name="header">
        <div class="d-flex justify-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas
            </h2>
            <form action="{{ route('tasks.create') }}" method="GET">
                <button class="btn btn-outline-secondary" type="submit">Nova Tarefa</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table">
                        <div class="flex items-center gap-2 mb-3">
                            <form action="{{ route('tasks.index') }}" method="get">
                                @csrf
                                @method('get')

                                <x-text-input id="title" class="block mt-1 w-75" type="text"
                                    placeholder="Pesquiar tarefa" name="title" :value="request('title')" required autofocus
                                    autocomplete="name" />

                                <x-select id="user" class="block mt-1 w-50" name="user" autocomplete="user"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ request('user') == 'all' ? 'selected' : '' }}>Todos
                                    </option>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == request('user')
                                                ? 'selected'
                                                : ($user->id == auth()->user()->id && (request('user') == $user->id || !request('user'))
                                                    ? 'selected'
                                                    : '') }}>
                                            {{ $user->name }}</option>
                                    @empty
                                    @endforelse
                                </x-select>

                                <x-select id="status" class="block mt-1 w-full w-50" name="status"
                                    autocomplete="status" onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>
                                        {{ __('Todas') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        {{ __('Pendente') }}</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        {{ __('Concluída') }}</option>
                                </x-select>
                            </form>
                        </div>

                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Título</th>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <th scope="row">{{ $task->id }}</th>
                                    <td class="ellipsis">{{ $task->title }}</td>
                                    <td class="ellipsis">{{ $task->description ?? '-' }}</td>
                                    <td class="flex justify-center">
                                        <p class="status {{ $task->status }}">
                                            {{ $task->status == 'pending' ? 'Pendente' : 'Concluida' }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-4">
                                            <form action="{{ route('tasks.edit', $task->id) }}" method="GET">
                                                @csrf
                                                @method('get')
                                                <button tooltip="Editar" data-toggle="tooltip" data-placement="top"
                                                    title="Visualizar">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button tooltip="Editar" data-toggle="tooltip" data-placement="top"
                                                    title="Excluir"
                                                    onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $tasks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .ellipsis {
        max-width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .status {
        padding: 5px;
        width: 80px;
        border-radius: 14px;
        background-color: #333;
        font-size: 14px;
        text-align: center;
    }

    .pending {
        background-color: #f0ad4e;
    }

    .completed {
        background-color: #5cb85c;
    }
</style>
