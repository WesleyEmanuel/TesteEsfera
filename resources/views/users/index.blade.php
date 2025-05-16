<x-app-layout>
    @if(session('success'))
        <x-alert color="success" :text="session('success')"></x-alert>
    @endif
    
    @if(session('error'))
        <x-alert color="danger" :text="session('error')"></x-alert>
    @endif
    
    <x-slot name="header">
        <div class="d-flex justify-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuários
            </h2>
            @if(auth()->user()->role == 'admin')
                <form action="{{route('users.create')}}" method="GET">
                    <button class="btn btn-outline-secondary" type="submit">Novo Usuário</button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col" class="text-center">Status</th>
                                @if(auth()->user()->role == 'admin')
                                    <th scope="col" class="text-center">Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td class="ellipsis">{{ $user->name }}</td>
                                    <td class="ellipsis">{{ $user->email }}</td>
                                    <td class="flex justify-center">
                                        <p class="status {{ $user->status ? 'active' : 'inactive' }}">
                                            {{ $user->status ? 'Ativo' : 'Inativo' }}
                                        </p>
                                    </td>
                                    @if(auth()->user()->role == 'admin')
                                        <td>
                                            <div class="flex justify-center gap-4">
                                                <form action="{{ route('profile.edit', $user->id) }}" method="GET" >
                                                    @csrf
                                                    @method('get')
                                                    <button tooltip="Editar" data-toggle="tooltip" data-placement="top" title="Visualizar">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" >
                                                    @csrf
                                                    @method('delete')
                                                    <button tooltip="Excluir" data-toggle="tooltip" data-placement="top" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
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

    .status{
        padding: 5px;
        width: 80px;
        border-radius: 14px;
        background-color: #333;
        font-size: 14px;
        text-align: center;
    }

    .active{
        background-color: #5cb85c;
    }
    .inactive{
        background-color: #f0ad4e;
    }
    
</style>