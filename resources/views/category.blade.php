<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kategorijos') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="container col-lg-12" style="margin-top: 40px">

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Namai</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $category }}</li>
                                </ol>
                            </nav>

                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <h4>{{ $category }} kategorijos produktai:</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @foreach ($products as $pro)
                                            <div class="col-lg-3">
                                                <div class="card" style="margin-bottom: 20px; height: auto;">
                                                    <img src="{{ $pro->img_path }}" class="card-img-top mx-auto"
                                                        style="height: 150px; width: 200px;display: block;">
                                                    <div class="card-body">
                                                        <a href="/items/{{ $pro->slug }}">
                                                            <h6 class="card-title">{{ $pro->name }}</h6>
                                                        </a>
                                                        <p>{{ $pro->price }}€</p>
                                                        <form action="{{ route('cart.store') }}" method="POST">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" value="{{ $pro->id }}" id="id"
                                                                name="id">
                                                            <input type="hidden" value="{{ $pro->name }}" id="name"
                                                                name="name">
                                                            <input type="hidden" value="{{ $pro->price }}" id="price"
                                                                name="price">
                                                            <input type="hidden" value="{{ $pro->img_path }}"
                                                                id="img" name="img">
                                                            <input type="hidden" value="{{ $pro->slug }}" id="slug"
                                                                name="slug">
                                                            <input type="hidden" value="1" id="quantity"
                                                                name="quantity">
                                                            <div class="card-footer" style="background-color: white;">
                                                                <div class="row">
                                                                    <button class="btn btn-secondary btn-sm"
                                                                        class="tooltip-test" title="add to cart"
                                                                        type="submit">
                                                                        <i class="fa fa-shopping-cart"></i> Į krepšelį
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
