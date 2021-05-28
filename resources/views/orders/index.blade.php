<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administratoriaus meniu') }}
        </h2>
    </x-slot>

    <div class="container col-lg-12" style="margin-top: 40px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Namai</a></li>
                <li class="breadcrumb-item"><a href="/admin">Administracija</a></li>
                <li class="breadcrumb-item active" aria-current="page">Užsakymai</li>
            </ol>
        </nav>

        @if (session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="display-3">Užsakymai</h1>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>ID:</td>
                                            <td>Būsena:</td>
                                            <td>Vartotojo ID:</td>
                                            <td>Užsakymo nr.:</td>
                                            <td>Produktai:</td>
                                            <td>Kiekis vnt.:</td>
                                            <td>Suma:</td>
                                            <td>Pateikimo data:</td>
                                            <td colspan=2>Veiksmai:</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>@switch($order->state)
                                                        @case(0)
                                                            Neatliktas
                                                        @break
                                                        @case(1)
                                                            Atliktas
                                                        @break
                                                        @default
                                                @break
                                            @endswitch</td>
                                            <td>{{ $order->user_id }}</td>
                                            <td>{{ $order->transaction_id }}</td>
                                            <td>
                                                @foreach (json_decode($order->products) as $prd)
                                                    {{ $prd->name }} <br>

                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach (json_decode($order->products) as $prd)
                                                    {{ $prd->pivot->quantity }} <br>
                                                @endforeach
                                            </td>
                                            <td>{{ $order->total }}€</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>
                                                <a href="{{ route('order.edit', $order->id) }}"
                                                    class="btn btn-primary">Redaguoti</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('order.destroy', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Pašalinti</button>
                                                </form>
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center">
                                {!! $orders->links() !!}
                            </div>
                        </div>
                    </div>
    </x-app-layout>
