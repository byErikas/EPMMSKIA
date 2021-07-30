<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produktai') }}
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
                            <span>
                                <h2>Katalogas:</h2>
                            </span>

                        </div>
                    </div>
                    {{-- POPULAR ITEMS START --}}
                    {{-- IF THERE ARE TOP ITEMS CHECK --}}
                    @if (count($top) > 0)
                        {{-- END IF THERE ARE TOP ITEMS CHECK --}}
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="product-description">
                                <span>
                                    <h5>Populiarūs produktai:</h5>
                                </span>
                            </div>
                            {{-- SPLIDE --}}
                            <div class="row">
                                <div id="card-slider" class="splide">
                                    <div class="splide__slider">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                @foreach ($top as $cat_item)
                                                    <li class="splide__slide">
                                                        <div class="col-lg">
                                                            <div class="card">
                                                                <div class="splide__slide__container">
                                                                    <img src="{{ $cat_item->img_path }}"
                                                                        class="card-img-top mx-auto"
                                                                        style="height: 150px; width: 200px;display: block;"
                                                                        alt="{{ $cat_item->img_path }}">
                                                                </div>
                                                                <div class="card-body">
                                                                    <a href="/items/{{ $cat_item->slug }}">
                                                                        <h6 class="card-title">{{ $cat_item->name }}
                                                                        </h6>
                                                                    </a>
                                                                    <p>{{ $cat_item->price }}€</p>
                                                                    <form action="{{ route('cart.store') }}"
                                                                        method="POST">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden"
                                                                            value="{{ $cat_item->id }}" id="id"
                                                                            name="id">
                                                                        <input type="hidden"
                                                                            value="{{ $cat_item->name }}" id="name"
                                                                            name="name">
                                                                        <input type="hidden"
                                                                            value="{{ $cat_item->price }}" id="price"
                                                                            name="price">
                                                                        <input type="hidden"
                                                                            value="{{ $cat_item->img_path }}"
                                                                            id="img" name="img">
                                                                        <input type="hidden"
                                                                            value="{{ $cat_item->slug }}" id="slug"
                                                                            name="slug">
                                                                        <input type="hidden" value="1" id="quantity"
                                                                            name="quantity">
                                                                        <div class="card-footer"
                                                                            style="background-color: white;">
                                                                            <div class="row">
                                                                                <x-cart-button>
                                                                                    Į krepšelį
                                                                                </x-cart-button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="splide__progress" style="margin-top: 0.5rem;">
                                            <div class="splide__progress__bar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-white border-b border-gray-200">
                                    </div>

                                </div>
                                {{-- SPLIDE END --}}
                            </div>
                        </div>
                    @endif
                    {{-- POPULAR ITEMS END --}}
                    {{-- ALL ITEMS START --}}
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="product-description">
                            <span>
                                <h5>Visi produktai:</h5>
                            </span>
                        </div>
                        <div class="row">
                            @foreach ($products as $cat_item)
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
                                                <input type="hidden" value="{{ $cat_item->id }}" id="id" name="id">
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
                                                        <x-cart-button>
                                                            Į krepšelį
                                                        </x-cart-button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- ALL ITEMS END --}}
                    {{-- PAGINATION LINKS --}}
                    <div class="d-flex justify-content-center" style="margin-top: 15px;">
                        {!! $products->links() !!}
                    </div>
                    {{-- END PAGINATION LINKS --}}
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('#card-slider', {
                    type: 'loop',
                    perPage: 4,
                    autoplay: true,
                    breakpoints: {
                        600: {
                            perPage: 1,
                        }
                    },
                }).mount();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    </x-slot>
</x-app-layout>
