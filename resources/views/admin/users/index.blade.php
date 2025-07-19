<x-app-layout>
    <div class="container">
        <h2 class="mb-4">Usuários cadastrados</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.users') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Filtrar por nome" value="{{ request('name') }}">
            </div>
            <div class="col-md-4">
                <input type="email" name="email" class="form-control" placeholder="Filtrar por e-mail" value="{{ request('email') }}">
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Limpar</a>
            </div>
        </form>

        {{-- Tabela de usuários --}}
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Função</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-success">Admin</span>
                        @else
                            <span class="badge bg-secondary">Usuário</span>
                        @endif
                    </td>
                    <td>
                        @if($user->role !== 'admin')
                            <form method="POST" action="{{ route('admin.users.promote', $user) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    Tornar Admin
                                </button>
                            </form>
                        @else
                            <em class="text-muted">Nenhuma ação</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{-- Paginação --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
