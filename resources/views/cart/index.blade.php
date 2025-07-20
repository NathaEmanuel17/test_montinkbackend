<x-app-layout>
    <div class="container py-5">
        <h2 class="mb-4">Carrinho de Compras</h2>

        @if(empty($cart))
            <p class="text-muted">Seu carrinho está vazio.</p>
        @else
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erro ao enviar os dados:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Variação</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['variation'] ?? '-' }}</td>
                            <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @php $total = collect($cart)->sum('subtotal'); @endphp

                <input type="hidden" name="coupon" id="hidden_coupon">
                <input type="hidden" name="shipping_value" id="shipping_value">

                <div class="row mt-4">
                    <!-- CUPOM -->
                    <div class="col-md-6 mb-3">
                        <label for="coupon_code" class="form-label">Cupom de Desconto</label>
                        <div class="input-group">
                            <input type="text" id="coupon_code" class="form-control" placeholder="Digite o cupom">
                            <button type="button" class="btn btn-outline-secondary" id="apply_coupon">Aplicar</button>
                        </div>
                        <div id="coupon_feedback" class="mt-2 small"></div>
                    </div>

                    <!-- FRETE -->
                    <div class="col-md-6 mb-3">
                        <label for="cep" class="form-label">Calcular Frete (CEP)</label>
                        <div class="input-group">
                            <input type="text" id="cep" name="zipcode" class="form-control" placeholder="Digite seu CEP" required>
                            <button type="button" class="btn btn-outline-primary" id="calc_shipping">Buscar</button>
                        </div>
                    </div>

                    <!-- ENDEREÇO -->
                    <div class="col-md-12">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" id="rua" name="address" class="form-control" placeholder="Rua" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="numero" name="number" class="form-control" placeholder="Número" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="bairro" name="neighborhood" class="form-control" placeholder="Bairro" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="cidade" name="city" class="form-control" placeholder="Cidade" required>
                            </div>
                            <div class="col-md-1">
                                <input type="text" id="uf" name="state" class="form-control" placeholder="UF" required>
                            </div>
                        </div>
                    </div>

                    <!-- RESUMO -->
                    <div class="col-md-12 mt-4">
                        <p><strong>Subtotal:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
                        <p id="frete_info"></p>
                        <p><strong>Total com desconto e frete:</strong> R$ <span id="total_price"></span></p>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success w-100">Finalizar Pedido</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let originalTotal = {{ $total }};
        let desconto = 0;
        let frete = 0;

        function calcularFretePorSubtotal(subtotal) {
            if (subtotal >= 52 && subtotal <= 166.59) return 15;
            if (subtotal > 200) return 0;
            return 20;
        }

        function atualizarResumo() {
            const subtotal = originalTotal - (originalTotal * (desconto / 100));
            frete = calcularFretePorSubtotal(subtotal);
            const totalFinal = subtotal + frete;

            $('#frete_info').html(frete === 0 ? 'Frete: <strong>Grátis</strong>' : 'Frete: <strong>R$ ' + frete.toFixed(2).replace('.', ',') + '</strong>');
            $('#total_price').text(totalFinal.toLocaleString('pt-BR', {minimumFractionDigits: 2}));

            $('#shipping_value').val(frete);
        }

        $(document).ready(function () {
            $('#apply_coupon').click(function () {
                const code = $('#coupon_code').val();
                if (!code) return alert('Informe um cupom.');

                $.get('/api/coupon/validate/' + code, function (data) {
                    if (data.valid) {
                        desconto = data.discount;
                        $('#hidden_coupon').val(code);
                        $('#coupon_feedback').removeClass('text-danger').addClass('text-success').text('Cupom de ' + desconto + '% aplicado.');
                    } else {
                        desconto = 0;
                        $('#hidden_coupon').val('');
                        $('#coupon_feedback').removeClass('text-success').addClass('text-danger').text('Cupom inválido.');
                    }
                    atualizarResumo();
                });
            });

            $('#calc_shipping').click(function () {
                const cep = $('#cep').val().replace(/\D/g, '');
                if (cep.length !== 8) return alert('CEP inválido');

                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
                    if (!data.erro) {
                        $('#rua').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#uf').val(data.uf);
                        atualizarResumo();
                    } else {
                        alert('CEP não encontrado.');
                    }
                }).fail(function () {
                    alert('Erro ao consultar o CEP.');
                });
            });

            atualizarResumo();
        });
    </script>
</x-app-layout>
