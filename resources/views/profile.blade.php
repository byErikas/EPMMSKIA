<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="bg-white border-b border-gray-200">You're in the profile page!</p>

                    {!! Form::open(['route' => ['profile.update'], 'method' => 'PATCH']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                        {!! Form::text('name', $value = $user->name, ['id' => 'name', 'class' => 'form-control']) !!}

                        <p style="margin-top: 1rem">{!! Form::label('name', 'Email:', ['class' => 'control-label']) !!}
                            {!! Form::text('email', $value = $user->email, ['id' => 'email', 'class' => 'form-control']) !!}</p>

                        <p style="margin-top: 1rem">{!! Form::label('name', 'Address:', ['class' => 'control-label']) !!}
                            {!! Form::text('address', $value = $user->address, ['id' => 'address', 'class' => 'form-control']) !!}</p>

                        <p style="margin-top: 1rem">{!! Form::label('name', 'City:', ['class' => 'control-label']) !!}
                                {!! Form::text('city', $value = $user->city, ['id' => 'city', 'class' => 'form-control']) !!}</p>

                        <p style="margin-top: 1rem">{!! Form::label('name', 'State:', ['class' => 'control-label']) !!}
                            {!! Form::text('state', $value = $user->state, ['id' => 'state', 'class' => 'form-control']) !!}</p>

                        <p style="margin-top: 1rem">{!! Form::label('name', 'Zip Code:', ['class' => 'control-label']) !!}
                            {!! Form::text('zip_code', $value = $user->zip_code, ['id' => 'zip_code', 'class' => 'form-control']) !!}</p>

                            <div class="row">
                                    <div style="display: flex; flex-wrap: nowrap; margin-top: 10px;">
                                        <button type="submit" class="btn btn-block btn-success"><a>Save Changes</a></button>
                                        {!! Form::close() !!}
                                        <form action="change-password">
                                            <button type="submit" class="btn btn-block btn-warning" style="margin-left: 10px">Change Password</button>
                                        </form>


                                    </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
