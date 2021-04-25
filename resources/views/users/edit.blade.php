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
                            <h1 class="display-3">Update a user</h1>

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

                            <form method="post" action="{{ route('category.update', $user->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label for="name"> Name:</label>
                                    <input type="text" class="form-control" name="name" value={{ $user->name }} />
                                </div>

                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select name="role" class="form-control">
                                        <option value='0'>User</option>
                                        <option value='1'>Admin</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email"> E-mail:</label>
                                    <input type="text" class="form-control" name="email" value={{ $user->email }} />
                                </div>

                                <div class="form-group">
                                    <label for="address"> Address:</label>
                                    <input type="text" class="form-control" name="address"
                                        value={{ $user->address }} />
                                </div>

                                <div class="form-group">
                                    <label for="city"> City:</label>
                                    <input type="text" class="form-control" name="city" value={{ $user->city }} />
                                </div>

                                <div class="form-group">
                                    <label for="state"> State:</label>
                                    <input type="text" class="form-control" name="state" value={{ $user->state }} />
                                </div>

                                <div class="form-group">
                                    <label for="zip_code"> Zip Code:</label>
                                    <input type="text" class="form-control" name="zip_code"
                                        value={{ $user->zip_code }} />
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
