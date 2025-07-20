<x-app-layout>
    <div class="container py-5">
        <h2 class="mb-4">Painel de Vendas</h2>

        {{-- Métricas em cards --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm text-bg-primary">
                    <div class="card-body">
                        <h5>Total Vendido</h5>
                        <p class="fs-4">R$ {{ number_format($totalSales, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-bg-success">
                    <div class="card-body">
                        <h5>Pedidos</h5>
                        <p class="fs-4">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-bg-warning">
                    <div class="card-body">
                        <h5>Pendentes</h5>
                        <p class="fs-4">{{ $pendingOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-bg-danger">
                    <div class="card-body">
                        <h5>Cancelados</h5>
                        <p class="fs-4">{{ $canceledOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtros --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Todos os Status</option>
                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ ucfirst($status->value) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100">Filtrar</button>

                <a href="{{ route(Route::currentRouteName()) }}" class="btn btn-outline-secondary w-100">
                    Limpar
                </a>
            </div>

        </form>

        {{-- Tabela --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped shadow-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status->value === 'pending' ? 'warning' : ($order->status->value === 'paid' ? 'success' : ($order->status->value === 'canceled' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($order->status->value) }}
                            </span>
                        </td>
                        <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhum pedido encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
