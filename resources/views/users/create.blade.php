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
                            <h1 class="display-3">Add a user</h1>
                            <div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div><br />
                                @endif
                                <form method="post" action="{{ route('user.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name"> Name:</label>
                                        <input type="text" class="form-control" name="name" value="" />
                                    </div>

                                    <div class="form-group">
                                        <label for="is_admin">Role:</label>
                                        <select name="is_admin" class="form-control">
                                            <option value='0'>User</option>
                                            <option value='1'>Admin</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="email"> E-mail:</label>
                                        <input type="text" class="form-control" name="email" value="" />
                                    </div>

                                    <div class="form-group">
                                        <label for="password"> Password:</label>
                                        <input type="password" class="form-control" name="password" value="" />
                                    </div>

                                    <div class="form-group">
                                        <label for="address"> Address:</label>
                                        <input type="text" class="form-control" name="address" value="" />
                                    </div>

                                    <div class="form-group">
                                        <label for="city"> City:</label>
                                        <input type="text" class="form-control" name="city" value="" />
                                    </div>

                                    <div class="form-group">
                                        <label for="state"> State:</label>
                                        <input type="text" class="form-control" name="state" value="" />
                                    </div>

                                    <div class="form-group">
                                        <label for="zip_code"> Zip Code:</label>
                                        <input type="text" class="form-control" name="zip_code" value="" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
