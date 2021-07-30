<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $item->name }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <link rel="stylesheet" href="{{ asset('css/item.css') }}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="product-description">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Namai</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="/categories/{{ $category }}">{{ $category }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="itcontainer col-lg-12">

                            <!-- Left Column / Image -->
                            <div class="left-column">
                                <img src="{{ $item->img_path }}">
                            </div>

                            <!-- Right Column -->
                            <div class="right-column">

                                <!-- Product Description -->
                                <div class="product-description">
                                    <span>{{ $category }}</span>
                                    <h1>{{ $item->name }}</h1>
                                    <div style="display: flex; align-items: flex-end;">
                                        <h4>Įvertinimas: {{ number_format((float) $ratings, 1, '.', '') }}</h4>
                                        @if (Auth::check())
                                            <form action="{{ route('single.item.rate', $item->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <div style="display: flex;">
                                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                                    <select name="rating" class="form-control"
                                                        style="width: 100px; margin-left: 15px;">
                                                        <option value='1'>1</option>
                                                        <option value='2'>2</option>
                                                        <option value='3'>3</option>
                                                        <option value='4'>4</option>
                                                        <option value='5'>5</option>
                                                    </select>
                                                    <x-cart-button style="margin-left: 1rem;">
                                                        Įvertinti
                                                    </x-cart-button>
                                                </div>
                                            </form>
                                        @endif

                                    </div>

                                    <p style="margin-top: 10px;">{{ $item->description }}</p>

                                </div>

                                <!-- Product Pricing -->
                                <div class="product-price">
                                    <span>{{ $item->price }}€</span>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                        <input type="hidden" value="{{ $item->name }}" id="name" name="name">
                                        <input type="hidden" value="{{ $item->price }}" id="price" name="price">
                                        <input type="hidden" value="{{ $item->img_path }}" id="img" name="img">
                                        <input type="hidden" value="{{ $item->slug }}" id="slug" name="slug">
                                        <input type="hidden" value="1" id="quantity" name="quantity">

                                        <x-cart-button>
                                            Į krepšelį
                                        </x-cart-button>
                                </div>
                            </div>
                            </form>
                            <div>
                            </div>
                        </div>
                    </div>

                    @if (count($similar) > 0)
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="product-description">
                                <hr>
                                <span>Produktai panašūs į <h5>{{ $item->name }}:</h5></span>
                            </div>
                            <div class="row">
                                @foreach ($similar as $cat_item)
                                    <div class="col-lg-3">
                                        <div class="card" style="margin-bottom: 20px; height: auto;">
                                            <img src="{{ $cat_item->img_path }}" class="card-img-top mx-auto"
                                                style="height: 150px; width: 200px;display: block;"
                                                alt="{{ $cat_item->img_path }}">
                                            <div class="card-body">
                                                <a href="/items/{{ $cat_item->slug }}">
                                                    <h6 class="card-title">{{ $cat_item->name }}</h6>
                                                </a>
                                                <p>{{ $cat_item->price }}€</p>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $cat_item->id }}" id="id"
                                                        name="id">
                                                    <input type="hidden" value="{{ $cat_item->name }}" id="name"
                                                        name="name">
                                                    <input type="hidden" value="{{ $cat_item->price }}" id="price"
                                                        name="price">
                                                    <input type="hidden" value="{{ $cat_item->img_path }}" id="img"
                                                        name="img">
                                                    <input type="hidden" value="{{ $cat_item->slug }}" id="slug"
                                                        name="slug">
                                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                                    <div class="card-footer" style="background-color: white;">
                                                        <div class="row">
                                                            <button class="btn btn-secondary btn-sm"
                                                                class="tooltip-test" title="add to cart" type="submit">
                                                                <i class="fa fa-shopping-cart"></i>Į krepšelį
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (count($cat_items) > 0)
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="product-description">
                                <span>Daugiau iš <h5>{{ $category }}:</h5></span>
                            </div>
                            <div class="row">
                                @foreach ($cat_items as $cat_item)
                                    <div class="col-lg-3">
                                        <div class="card" style="margin-bottom: 20px; height: auto;">
                                            <img src="{{ $cat_item->img_path }}" class="card-img-top mx-auto"
                                                style="height: 150px; width: 200px;display: block;"
                                                alt="{{ $cat_item->img_path }}">
                                            <div class="card-body">
                                                <a href="/items/{{ $cat_item->slug }}">
                                                    <h6 class="card-title">{{ $cat_item->name }}</h6>
                                                </a>
                                                <p>{{ $cat_item->price }}€</p>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $cat_item->id }}" id="id"
                                                        name="id">
                                                    <input type="hidden" value="{{ $cat_item->name }}" id="name"
                                                        name="name">
                                                    <input type="hidden" value="{{ $cat_item->price }}" id="price"
                                                        name="price">
                                                    <input type="hidden" value="{{ $cat_item->img_path }}" id="img"
                                                        name="img">
                                                    <input type="hidden" value="{{ $cat_item->slug }}" id="slug"
                                                        name="slug">
                                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                                    <div class="card-footer" style="background-color: white;">
                                                        <div class="row">
                                                            <button class="btn btn-secondary btn-sm"
                                                                class="tooltip-test" title="add to cart" type="submit">
                                                                <i class="fa fa-shopping-cart"></i>Į krepšelį
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
