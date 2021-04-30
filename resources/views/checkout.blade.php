<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
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
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                                </ol>
                            </nav>
                        </div>
                        {{-- END CRUMBS --}}

                        {{-- CART ITEMS SECTION --}}
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <br>
                                @if (\Cart::getTotalQuantity() > 0)
                                    <h4>{{ \Cart::getTotalQuantity() }} Product(s) In Your cart</h4><br>
                                @else
                                    <h4>No Product(s) In Your Cart</h4><br>
                                    <a href="/" class="btn btn-dark">Continue Shopping</a>
                                @endif

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
                                                <b>Price: </b>${{ $item->price }}<br>
                                                <b>Sub Total: </b>${{ \Cart::get($item->id)->getPriceSum() }}<br>
                                            </p>
                                        </div>
                                        <div class="col-lg-4"
                                            style="display: flex; justify-content: flex-end; align-items: flex-start;">
                                            <div class="row">
                                                <form action="{{ route('cart.update') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <div style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                                        <input type="hidden" value="{{ $item->id }}" id="id"
                                                            name="id">
                                                        <input type="number" class="form-control form-control-sm"
                                                            value="{{ $item->quantity }}" id="quantity"
                                                            name="quantity" style="width: 50px; margin-right: 10px;">
                                                        <button class="btn btn-secondary btn-sm"
                                                            style="margin-right: 10px;"><i
                                                                class="bi bi-arrow-clockwise"></i></button>
                                                </form>
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                                    <button class="btn btn-dark btn-sm" style="margin-right: 10px;"><i
                                                            class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <hr>
                            @endforeach
                            @if (count($cartCollection) > 0)
                                <div style="display: flex;">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-secondary btn-md">Clear Cart</button>
                                    </form>
                                    <br><a style="margin-left: 15px;" href="/dashboard"><button
                                            class="btn btn-dark">Continue
                                            Shopping</button></a>
                                    <div class="card" style="margin-left: auto;">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><b>Total: </b>{{ \Cart::getTotal() }}€</li>
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
                                <h3 style="margin-top: 5px;">Buyer details:</h3>
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

                                        <p>{!! Form::label('name', 'Name:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('name', $value = $user->name, ['id' => 'name', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Email:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('email', $value = $user->email, ['id' => 'email', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Address:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('address', $value = $user->address, ['id' => 'address', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'City:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('city', $value = $user->city, ['id' => 'city', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'State:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('state', $value = $user->state, ['id' => 'state', 'class' => 'form-control']) !!}</p>

                                        <p>{!! Form::label('name', 'Zip Code:', ['class' => 'control-label', 'class' => 'required']) !!}
                                            {!! Form::text('zip_code', $value = $user->zip_code, ['id' => 'zip_code', 'class' => 'form-control']) !!}</p>

                                        <div class="row">
                                            <div style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                                <button type="submit" class="btn btn-block btn-success">
                                                    <a>Place order</a>
                                                </button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        {{-- IF USER NOT LOGGED IN --}}
                                    @elseif ($user == null)
                                        {!! Form::open(['route' => ['order.purchase'], 'method' => 'POST']) !!}
                                        <div class="form-group">
                                            <p>{!! Form::label('name', 'Name:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('name', '', ['id' => 'name', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Email:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('email', '', ['id' => 'email', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Address:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('address', '', ['id' => 'address', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'City:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('city', '', ['id' => 'city', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'State:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('state', '', ['id' => 'state', 'class' => 'form-control']) !!}</p>

                                            <p>{!! Form::label('name', 'Zip Code:', ['class' => 'control-label', 'class' => 'required']) !!}
                                                {!! Form::text('zip_code', '', ['id' => 'zip_code', 'class' => 'form-control']) !!}</p>

                                            <div class="row">
                                                <div style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                                    <button type="submit" class="btn btn-block btn-success">
                                                        <a>Place order</a>
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
