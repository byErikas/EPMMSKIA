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
                            <h1 class="display-3">Redaguoti vartotoją</h1>

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

                            <form method="post" action="{{ route('user.update', $user->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label for="name">Vardas:</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                                </div>

                                <div class="form-group">
                                    <label for="role">Rolė:</label>
                                    <select name="role" class="form-control">
                                        <option value='0'>Vartotojas</option>
                                        <option value='1'>Administratorius</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">El. paštas:</label>
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}" />
                                </div>

                                <div class="form-group">
                                    <label for="address">Adresas:</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ $user->address }}" />
                                </div>

                                <div class="form-group">
                                    <label for="city">Miestas:</label>
                                    <input type="text" class="form-control" name="city" value="{{ $user->city }}" />
                                </div>

                                <div class="form-group">
                                    <label for="state">Rajonas:</label>
                                    <input type="text" class="form-control" name="state" value="{{ $user->state }}" />
                                </div>

                                <div class="form-group">
                                    <label for="zip_code">Pašto kodas:</label>
                                    <input type="text" class="form-control" name="zip_code"
                                        value="{{ $user->zip_code }}" />
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
