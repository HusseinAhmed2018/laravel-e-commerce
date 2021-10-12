@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ __('Update User Profile') }}</h1>
        <form action="{{ route('profile.update') }}" method="post">

            {{ method_field("PUT") }}

            <!-- CSRF TOKEN -->
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? 'was-validated' : ''}}">
                <label for="name">{{ __('User Name') }}:</label>
                <input type="text" class="form-control" id="name" placeholder="{{__('Enter User Name')}}" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group {{ $errors->has('price') ? 'was-validated' : ''}}">
                <label for="name">{{ __('Email') }}:</label>
                <input type="text" class="form-control" id="email" placeholder="{{__('Enter Email')}}" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
    </div>
@endsection
