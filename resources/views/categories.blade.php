<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Items') }}
        </h2>
    </x-slot>
    <<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                        <div class="container col-lg-12" style="margin-top: 40px">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                                </ol>
                            </nav>
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <hr>
                                    <div class="row">
                                        @foreach ($categories as $pro)
                                            <div class="col-lg-3">
                                                <div class="card" style="margin-bottom: 20px; height: auto;">
                                                    <div class="card-body">
                                                        <a href="/categories/{{ $pro->slug }}">
                                                            <h6 class="card-title">{{ $pro->name }}</h6>
                                                        </a>
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

</x-app-layout>
