@extends('layouts.app')

@section('content')
    <!------ Include the above in your HEAD tag ---------->
    <div class="container mb-4">
        <div class="row">
            @foreach($products as $product)
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h3 class="text-warning">{{ __('Store') }} {{ $product->store->name }}</h3>
                        <a href="#">
                            <img class="card-img-top" src="https://images.pexels.com/photos/2078268/pexels-photo-2078268.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" alt="">
                        </a>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <a class="text-reset" href="#"><h3 class="card-title display-4">{{$product->name}}</h3></a>
                        <h6>${{$product->price}} </h6>
                        <div>
                            <add-to-cart :product-id="'{{$product->id}}'" />
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-12 mt-4 text-center">
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-img-top{
            width: 70% !important;
        }
    </style>
@endpush
