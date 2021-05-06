<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Krepšelis') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <link rel="stylesheet" href="{{ asset('css/item.css') }}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        {{-- SESSION ALERTS --}}
                        @if (session()->has('success_msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session()->get('success_msg') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        @if (session()->has('alert_msg'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session()->get('alert_msg') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        {{-- END SESSION ALERTS --}}

                        {{-- CRUMBS --}}
                        <div class="product-description">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Namai</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Krepšelis</li>
                                </ol>
                            </nav>
                        </div>
                        {{-- END CRUMBS --}}

                        {{-- CART ITEMS SECTION --}}
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                @if (\Cart::getTotalQuantity() > 0)
                                    <hr>
                                    <h3>{{ \Cart::getTotalQuantity() }} Produktai(-ų) krepšelyje</h3>
                                    <hr>
                                @else
                                    <h4>Nėra produktų krepšelyje</h4><br>
                                    <a href="/" class="btn btn-dark">Toliau apsipirkinėti</a>
                                @endif

                                <div
                                    style="max-height: 55.4vh; overflow-y: auto; overflow-x: hidden; margin-bottom: 15px;">
                                    @foreach ($cartCollection as $item)
                                        <div class="row">
                                            <div class="col-lg-3">

                                                <img src="{{ $item->attributes->image }}" class="img-thumbnail"
                                                    width="200" height="200">
                                            </div>
                                            <div class="col-lg-5">
                                                <p>
                                                    <b> <a href="/shop/{{ $item->attributes->slug }}">{{ $item->name }}
                                                        </a></b><br>
                                                    <b>Kaina: </b>{{ $item->price }}€<br>
                                                    <b>Iš viso: </b>{{ \Cart::get($item->id)->getPriceSum() }}€<br>
                                                </p>
                                            </div>
                                            <div class="col-lg-4"
                                                style="display: flex; justify-content: flex-end; align-items: flex-start;">
                                                <div class="row">
                                                    <form action="{{ route('cart.update') }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <div
                                                            style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                                            <input type="hidden" value="{{ $item->id }}" id="id"
                                                                name="id">
                                                            <input type="number" class="form-control form-control-sm"
                                                                value="{{ $item->quantity }}" id="quantity"
                                                                name="quantity"
                                                                style="width: 50px; margin-right: 10px;">
                                                            <button class="btn btn-secondary btn-sm"
                                                                style="margin-right: 10px;"><i
                                                                    class="bi bi-arrow-clockwise"></i></button>
                                                    </form>
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" value="{{ $item->id }}" id="id"
                                                            name="id">
                                                        <button class="btn btn-dark btn-sm"
                                                            style="margin-right: 10px;"><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                            @if (count($cartCollection) > 0)
                                <div style="display: flex;">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-secondary btn-md">Išvalyti krepšelį</button>
                                    </form>
                                    <br><a style="margin-left: 15px;" href="/dashboard"><button
                                            class="btn btn-dark">Toliau apsipirkinėti</button></a>
                                    <div class="card" style="margin-left: auto;">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><b>Suma: </b>{{ \Cart::getTotal() }}€</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- END CART ITEMS SECTION --}}

                        {{-- BUYER DETAILS SECTION --}}
                        @if (count($cartCollection) > 0)
                            <div class="col-lg-5">
                                <hr>
                                <h3 style="margin-top: 5px;">Pirkėjo informacija:</h3>
                                @if ($errors->any())
                                    <div class="alert alert-danger" style="margin-top: 15px;">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div><br />
                                @endif
                                <hr>

                                {{-- IF LOGGED IN --}}
                                @if ($user != null)
                                    {!! Form::open(['route' => ['order.purchase'], 'method' => 'POST']) !!}
                                    <div class="form-group">

                                        <p>{!! Form::label('name', 'Vardas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('name', $value = $user->name, ['id' => 'name', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'El. paštas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('email', $value = $user->email, ['id' => 'email', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Adresas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('address', $value = $user->address, ['id' => 'address', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Miestas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('city', $value = $user->city, ['id' => 'city', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Rajonas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('state', $value = $user->state, ['id' => 'state', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Pašto kodas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('zip_code', $value = $user->zip_code, ['id' => 'zip_code', 'class' => 'form-control']) !!}</p>

                                        <div class="row">
                                            <div style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                                <button type="submit" class="btn btn-block btn-success">
                                                    <a>Pateikti užsakymą</a>
                                                </button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        {{-- IF USER NOT LOGGED IN --}}
                                    @elseif ($user == null)
                                        {!! Form::open(['route' => ['order.purchase'], 'method' => 'POST']) !!}
                                        <div class="form-group">
                                            <p>{!! Form::label('name', 'Vardas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('name', '', ['id' => 'name', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Slaptažodis:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('password', '', ['id' => 'password', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'El. paštas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('email', '', ['id' => 'email', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Adresas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('address', '', ['id' => 'address', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Miestas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('city', '', ['id' => 'city', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Rajonas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('state', '', ['id' => 'state', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Pašto kodas:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('zip_code', '', ['id' => 'zip_code', 'class' => 'form-control']) !!}</p>

                                            <div class="row">
                                                <div style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                                    <button type="submit" class="btn btn-block btn-success">
                                                        <a>Pateikti užsakymą</a>
                                                    </button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
