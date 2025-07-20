<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Cupons de Desconto</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">Novo Cupom</a>
        </div>

        <table class="table table-bordered table-striped align-middle">
            <thead>
            <tr>
                <th>Código</th>
                <th>Desconto (%)</th>
                <th>Valor Mínimo</th>
                <th>Validade</th>
                <th>Status</th>
                <th>Criado por</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->discount }}%</td>
                    <td>R$ {{ number_format($coupon->min_value, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}</td>
                    <td>
                        @if($coupon->status)
                            <span class="badge bg-success">Ativo</span>
                        @else
                            <span class="badge bg-secondary">Inativo</span>
                        @endif
                    </td>
                    <td>{{ $coupon->creator->name ?? '-' }}</td>
                    <td class="d-flex gap-2">
                        <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-btn">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Nenhum cupom cadastrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $coupons->links() }}
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Excluir cupom?',
                    text: "Essa ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
