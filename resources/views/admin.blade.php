<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administratoriaus meniu') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    {{-- Session alerts --}}
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
                    {{-- End session alerts --}}

                    <div class="p-6 bg-white border-b border-gray-200">
                        Jūs esate Administratoriaus meniu.
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto; margin-top: 20px;">
                            <div class="card-body">
                                <a href="/product">
                                    <h6 class="card-title">Produktų valdymas</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto; margin-top: 20px;">
                            <div class="card-body">
                                <a href="/category">
                                    <h6 class="card-title">Kategorijų valdymas</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto; margin-top: 20px;">
                            <div class="card-body">
                                <a href="/user">
                                    <h6 class="card-title">Vartotojų valdymas</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
