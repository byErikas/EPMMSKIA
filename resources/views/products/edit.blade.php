<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="row">
                        <div class="col-sm-8 offset-sm-2">
                            <h1 class="display-3">Update a product</h1>

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
                            <form method="post" action="{{ route('product.update', $product->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label for="name"> Name:</label>
                                    <input type="text" class="form-control" name="name" value={{ $product->name }} />
                                </div>

                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select name="category" class="form-control">
                                        @foreach($categories as $category)
                                        <option value={{$category->id}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <input type="text" class="form-control" name="description"
                                        value={{ $product->description }} />
                                </div>

                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="text" class="form-control" name="price"
                                        value={{ $product->price }} />
                                </div>
                                <div class="form-group">
                                    <label for="img_path">Image path:</label>
                                    <input type="text" class="form-control" name="img_path"
                                        value={{ $product->img_path }} />
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
