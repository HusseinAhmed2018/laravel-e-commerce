@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ $edit ? route('store.update',['slug' => $store->slug]) : route('stores.store') }}" method="post">
            @if($edit)
                {{ method_field("PUT") }}
            @endif

            <!-- CSRF TOKEN -->
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? 'was-validated' : ''}}">
                <label for="name">{{ __('Store Name') }}:</label>
                <input type="text" class="form-control" id="name" placeholder="{{__('Enter Store Name')}}" name="name" value="{{ old('name') ? old('name') : (($store)? $store->name : '') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
    </div>
@endsection
