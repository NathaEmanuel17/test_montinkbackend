<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Lista de Produtos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nome..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary">Filtrar</button>
            </div>
        </form>

        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Novo Produto</a>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead>
            <tr>
                <th style="width: 200px;">Imagens</th>
                <th>Nome</th>
                <th>Preço</th>
                <th style="width: 220px;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        <div class="d-flex">
                            @php $images = $product->images->take(3); @endphp
                            @if($images->count())
                                @foreach($images as $key => $image)
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                         class="rounded-circle border"
                                         style="width: 40px; height: 40px; margin-left: -{{ $key > 0 ? 10 : 0 }}px; z-index: {{ 10 - $key }}; position: relative;">
                                @endforeach
                            @else
                                <span class="text-muted"><i class="fas fa-image fa-2x"></i></span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Editar</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $product->id }}">Excluir</button>

                        <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->withQueryString()->links() }}
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Essa ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
