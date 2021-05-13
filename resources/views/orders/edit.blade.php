<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administratoriaus meniu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="row">
                        <div class="col-sm-8 offset-sm-2">
                            <h1 class="display-3">Redaguoti užsakymą</h1>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <br />
                            @endif

                            <form method="post" action="{{ route('order.update', $order->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label for="state">Būsena:</label>
                                    <select name="state" class="form-control">
                                        <option value='0'>Neatliktas</option>
                                        <option value='1'>Atliktas</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Atnaujinti</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
