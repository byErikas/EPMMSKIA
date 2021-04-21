<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$item->name}}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <link rel="stylesheet" href="{{ asset('css/item.css') }}">
        <div class="container col-lg-12"style="margin-top: 40px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/categories/{{$category}}">{{$category}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$item->name}}</li>
            </ol>
        </nav>
        </div>

    <div class="itcontainer col-lg-12" style="margin-top: 40px">

  <!-- Left Column / Image -->
  <div class="left-column">
    <img src="https://dummyimage.com/600x600/828282/ffffff">
  </div>

  <!-- Right Column -->
  <div class="right-column">

    <!-- Product Description -->
    <div class="product-description">
      <span>{{$category}}</span>
      <h1>{{$item->name}}</h1>
      <!--<h3>{{$ratings}}</h3> --> <!-- would be rating field-->
      <p>{{$item->description}}</p>

    </div>

    <!-- Product Pricing -->
    <div class="product-price">
      <span>{{$item->price}} Eur.</span>
      <form action="{{ route('cart.store') }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" value="{{ $item->id }}" id="id" name="id">
        <input type="hidden" value="{{ $item->name }}" id="name" name="name">
        <input type="hidden" value="{{ $item->price }}" id="price" name="price">
        <input type="hidden" value="https://dummyimage.com/600x600/828282/ffffff" id="img" name="img">
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
</div>
</div>
</x-slot>
</x-app-layout>
