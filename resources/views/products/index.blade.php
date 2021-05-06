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
                <li class="breadcrumb-item active" aria-current="page">Produktai</li>
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
                                <h1 class="display-3">Produktai</h1>
                                <a style="margin: 19px;" href="{{ route('product.create') }}"
                                    class="btn btn-primary">Naujas produktas</a>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>ID:</td>
                                            <td>Vardas:</td>
                                            <td>Nuorodos vardas:</td>
                                            <td>Kategorijos ID:</td>
                                            <td>Aprašymas:</td>
                                            <td>Kaina:</td>
                                            <td>Įvertinimas:</td>
                                            <td style="word-wrap: break-word; max-width: 100px;">Paveikslėlio nuoroda:
                                            </td>
                                            <td colspan=2>Veiksmai:</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->slug }}</td>
                                                <td>{{ $product->category_id }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>{{ $product->price }}€</td>
                                                <td>{{ $product->averageRating }}</td>
                                                <td style="word-wrap: break-word; max-width: 110px;">
                                                    {{ $product->img_path }}</td>
                                                <td>
                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                        class="btn btn-primary">Redaguoti</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('product.destroy', $product->id) }}"
                                                        method="post">
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
                            {!! $products->links() !!}
                        </div>
                    </div>
                </div>
</x-app-layout>
