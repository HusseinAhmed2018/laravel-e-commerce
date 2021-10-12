@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ __('Create Product') }}</h1>
        <form action="{{ route('products.store') }}" method="post">

            <!-- CSRF TOKEN -->
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? 'was-validated' : ''}}">
                <label for="name">{{ __('Product Name') }}:</label>
                <input type="text" class="form-control" id="name" placeholder="{{__('Enter Product Name')}}" name="name" value="{{ old('name') ? old('name') : '' }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group {{ $errors->has('price') ? 'was-validated' : ''}}">
                <label for="name">{{ __('Product Price') }}:</label>
                <input type="text" class="form-control" id="price" placeholder="{{__('Enter Product Price')}}" name="price" value="{{ old('price') ? old('price') : '' }}" required>
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group {{ $errors->has('description') ? 'was-validated' : ''}}">
                <label for="name">{{ __('Product Price') }}:</label>
                <textarea class="form-control" name="description" placeholder="{{__('Enter Product description')}}" id="" cols="30" rows="10">{{ old('description') ? old('description') : '' }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
    </div>
@endsection
