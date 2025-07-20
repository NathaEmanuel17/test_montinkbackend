<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Editar Produto</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Nome -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Nome</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Preço -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Preço</label>
                    <input name="price" type="number" step="0.01"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $product->price) }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Upload Imagens -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Adicionar Imagens</label>
                    <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror"
                           multiple>
                    @error('images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Imagens Existentes -->
            @if($product->images->count())
                <div class="mb-4">
                    <label class="form-label d-block">Imagens atuais:</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($product->images as $image)
                            <div class="position-relative" data-image-id="{{ $image->id }}">
                                <img src="{{ asset('storage/' . $image->path) }}" width="100" height="100" class="rounded border">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-image-btn"
                                        data-image-id="{{ $image->id }}">
                                    ×
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Variações -->
            <div class="mb-3">
                <h5>Variações</h5>
                <table class="table table-bordered" id="variation-table">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Estoque</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->variations as $i => $variation)
                        <tr>
                            <td>
                                <input type="hidden" name="variations[{{ $i }}][id]" value="{{ $variation->id }}">
                                <input name="variations[{{ $i }}][name]" class="form-control"
                                       value="{{ old("variations.$i.name", $variation->name) }}">
                            </td>
                            <td>
                                <input name="variations[{{ $i }}][quantity]" type="number" class="form-control"
                                       value="{{ old("variations.$i.quantity", $variation->stock->quantity ?? 0) }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-secondary" id="add-variation">+ Adicionar Variação</button>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </form>

        <form id="delete-image-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let index = {{ $product->variations->count() }};

        $('#add-variation').on('click', function () {
            $('#variation-table tbody').append(`
                <tr>
                    <td><input name="variations[${index}][name]" class="form-control" placeholder="Nome da Variação"></td>
                    <td><input name="variations[${index}][quantity]" type="number" class="form-control" placeholder="Estoque"></td>
                </tr>
            `);
            index++;
        });

        $('.delete-image-btn').on('click', function () {
            const imageId = $(this).data('image-id');
            const url = `{{ url('products/' . $product->id . '/images') }}/${imageId}`;
            const token = $('meta[name="csrf-token"]').attr('content');

            Swal.fire({
                title: 'Tem certeza?',
                text: "Essa ação não pode ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, apagar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: token,
                        },
                        success: function () {
                            $(`[data-image-id="${imageId}"]`).fadeOut(300, function () {
                                $(this).remove();
                                Swal.fire('Deletado!', 'Imagem removida com sucesso.', 'success');
                            });
                        },
                        error: function () {
                            Swal.fire('Erro', 'Não foi possível remover a imagem.', 'error');
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
