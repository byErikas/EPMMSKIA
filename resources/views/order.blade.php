<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if (count($orders) == 0)
                        <div class="p-6 bg-white border-b border-gray-200">
                            You have no orders.
                        </div>
                    @endif

                    @foreach ($orders as $order)
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p>Order placed date: {{ $order->created_at }}</p>
                            <p>Transaction ID: {{ $order->transaction_id }}</p>
                            <p>Items ordered: |@foreach (json_decode($order->products) as $item)
                                    {{ $item->pivot->quantity }} <a
                                        href="/items/{{ $item->slug }}">{{ $item->name }}</a>
                                    |
                                @endforeach</p>
                            <p>Total cost: {{ $order->total }}€</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
