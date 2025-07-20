<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Cadastrar Produto</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Nome -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Nome</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Preço -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Preço</label>
                    <input name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Imagens -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Imagens</label>
                    <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple>
                    @error('images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

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
                    @php $variationIndex = old('variations') ? count(old('variations')) : 1; @endphp
                    @for ($i = 0; $i < $variationIndex; $i++)
                        <tr>
                            <td>
                                <input name="variations[{{ $i }}][name]" class="form-control @error("variations.$i.name") is-invalid @enderror"
                                       value="{{ old("variations.$i.name") }}" placeholder="Nome da Variação">
                                @error("variations.$i.name") <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </td>
                            <td>
                                <input name="variations[{{ $i }}][quantity]" type="number"
                                       class="form-control @error("variations.$i.quantity") is-invalid @enderror"
                                       value="{{ old("variations.$i.quantity") }}" placeholder="Estoque">
                                @error("variations.$i.quantity") <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-secondary" id="add-variation">+ Adicionar Variação</button>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- jQuery para adicionar variações -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let index = {{ $variationIndex }};
        $('#add-variation').on('click', function () {
            $('#variation-table tbody').append(`
                <tr>
                    <td><input name="variations[${index}][name]" class="form-control" placeholder="Nome da Variação"></td>
                    <td><input name="variations[${index}][quantity]" type="number" class="form-control" placeholder="Estoque"></td>
                </tr>
            `);
            index++;
        });
    </script>
</x-app-layout>
