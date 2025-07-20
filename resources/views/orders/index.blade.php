<x-app-layout>
    <div class="container py-5">
        <h2 class="mb-4">Meus Pedidos</h2>

        {{-- Alertas bonitos com ícones --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        {{-- Filtro de status --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Todos os Status</option>
                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ ucfirst($status->value) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if($orders->count())
            <div class="table-responsive">
                <table class="table table-striped align-middle shadow-sm">
                    <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Frete</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status->value === 'pending' ? 'warning' : ($order->status->value === 'paid' ? 'success' : ($order->status->value === 'canceled' ? 'danger' : 'secondary')) }}">
                                    {{ ucfirst($order->status->value) }}
                                </span>
                            </td>
                            <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($order->shipping_price, 2, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($order->status->value === 'pending')
                                    <form method="POST" action="{{ route('orders.cancel', $order) }}" class="d-inline cancel-form">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-cancelar">Cancelar</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>Nenhum pedido encontrado.</div>
            </div>
        @endif
    </div>

    {{-- SweetAlert2 --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-cancelar').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('.cancel-form');

            Swal.fire({
                title: 'Cancelar pedido?',
                text: 'Você tem certeza que deseja cancelar este pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, cancelar',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
</x-app-layout>
