<x-mail::message>
    # Olá {{ $order->user->name }},

    Seu pedido **#{{ $order->id }}** foi realizado com sucesso!

    ---

    **Total do Pedido:** R$ {{ number_format($order->total, 2, ',', '.') }}
    **Frete:** R$ {{ number_format($order->shipping_price, 2, ',', '.') }}
    **Status:** {{ ucfirst($order->status->value) }}

    <x-mail::panel>
        **Endereço de Entrega:**
        {{ $order->address }}, {{ $order->number ?? '-' }}
        {{ $order->neighborhood }} - {{ $order->city }}/{{ $order->state }}
        CEP: {{ $order->zip_code }}
    </x-mail::panel>

    <x-mail::button :url="route('orders.pay', $order)">
        Pagar Agora
    </x-mail::button>

    Se tiver dúvidas, estamos à disposição para ajudar.

    Atenciosamente,
    **{{ config('app.name') }}**
</x-mail::message>
