<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administratoriaus meniu') }}
        </h2>
    </x-slot>

    <div class="container col-lg-12" style="margin-top: 40px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Namai</a></li>
                <li class="breadcrumb-item"><a href="/admin">Administracija</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vartotojai</li>
            </ol>
        </nav>

        @if (session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="display-3">Vartotojai</h1>
                                <a style="margin: 19px;" href="{{ route('user.create') }}"
                                    class="btn btn-primary">Naujas vartotojas</a>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>ID:</td>
                                            <td>Vardas:</td>
                                            <td>Rolė:</td>
                                            <td>El. paštas:</td>
                                            <td>Adresas:</td>
                                            <td>Miestas:</td>
                                            <td>Rajonas:</td>
                                            <td>Pašto kodas:</td>
                                            <td>Užsakymai:</td>
                                            <td colspan=2>Veiksmai:</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>@switch($user->is_admin)
                                                        @case(0)
                                                            Vartotojas
                                                        @break
                                                        @case(1)
                                                            Administratorius
                                                        @break
                                                        @default
                                                @break
                                            @endswitch</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->city }}</td>
                                            <td>{{ $user->state }}</td>
                                            <td>{{ $user->zip_code }}</td>
                                            <td>
                                                @foreach (json_decode($user->orders) as $order)
                                                    {{ $order->transaction_id }} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-primary">Redaguoti</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Pašalinti</button>
                                                </form>
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
    </x-app-layout>
