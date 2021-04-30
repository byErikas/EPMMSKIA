<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Recommendations') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <link rel="stylesheet" href="{{ asset('css/item.css') }}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    {{-- CONTENT --}}


                    <div class="p-6 bg-white border-b border-gray-200">
                        @if (count($rating_based) != 0)
                            {{-- END IF THERE ARE TOP ITEMS CHECK --}}
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="product-description">
                                    <span>
                                        <h5>Based on users with similar interests:</h5>
                                    </span>
                                </div>
                                <div class="row">
                                    @foreach ($rating_based as $item)
                                        <div class="col-lg-3">
                                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                                <img src="{{ $item->img_path }}" class="card-img-top mx-auto"
                                                    style="height: 150px; width: 150px;display: block;"
                                                    alt="{{ $item->img_path }}">
                                                <div class="card-body">
                                                    <a href="/items/{{ $item->slug }}">
                                                        <h6 class="card-title">{{ $item->name }}</h6>
                                                    </a>
                                                    <p>{{ $item->price }}€</p>
                                                    <form action="{{ route('cart.store') }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" value="{{ $item->id }}" id="id"
                                                            name="id">
                                                        <input type="hidden" value="{{ $item->name }}" id="name"
                                                            name="name">
                                                        <input type="hidden" value="{{ $item->price }}" id="price"
                                                            name="price">
                                                        <input type="hidden" value="{{ $item->img_path }}" id="img"
                                                            name="img">
                                                        <input type="hidden" value="{{ $item->slug }}" id="slug"
                                                            name="slug">
                                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                                        <div class="card-footer" style="background-color: white;">
                                                            <div class="row">
                                                                <button class="btn btn-secondary btn-sm"
                                                                    class="tooltip-test" title="add to cart"
                                                                    type="submit">
                                                                    <i class="fa fa-shopping-cart"></i> Add to cart
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

                        @if (count($rating_based) == 0)
                            <div class="p-6 bg-white border-b border-gray-200">
                                Not enough items rated to form recommendation.
                            </div>
                        @endif

                    </div>
                    {{-- END CONTENT --}}

                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
