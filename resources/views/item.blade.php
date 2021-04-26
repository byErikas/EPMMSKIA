<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $item->name }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <link rel="stylesheet" href="{{ asset('css/item.css') }}">
        <div class="container col-lg-12" style="margin-top: 40px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/categories/{{ $category }}">{{ $category }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
                </ol>
            </nav>
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
            @if (count($errors) > 0)
                @foreach ($errors0 > all() as $error)
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="itcontainer col-lg-12" style="margin-top: 40px">

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
                        <h4>Rating: {{ number_format((float) $ratings, 1, '.', '') }}</h4>
                        @if (Auth::check())
                            <form action="{{ route('single.item.rate', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                <div style="display: flex;">
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <select name="rating" class="form-control" style="width: 100px; margin-left: 15px;">
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                        <option value='3'>3</option>
                                        <option value='4'>4</option>
                                        <option value='5'>5</option>
                                    </select>
                                    <button class="btn btn-block btn-success" type="submit" style="margin-left: 15px;">
                                        Rate
                                    </button>
                                </div>
                            </form>
                        @endif

                    </div>

                    <!-- would be rating field-->
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
                        <div class="card-footer" style="background-color: white;">
                            <div class="row">
                                <button class="btn btn-block btn-success" type="submit">
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-striped">
                    <p style="margin-top: 20px;">Simillar to <b>{{ $item->name }}</b></p>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Category</td>
                            <td>Price</td>
                            <td>Rating</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($similar as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                @foreach (json_decode($product->categories) as $item)
                                    <td>{{ $item->name }}</td>
                                @endforeach
                                <td>{{ $product->price }}</td>
                                <td>{{ number_format((float) $product->averageRating, 1, '.', '') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-app-layout>
