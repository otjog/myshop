@extends('_raduga.index')

@section('component')
    <!-- Main Heading Starts -->
        <h2 class="main-heading2 page-title">
            {{$header_page}}
        </h2>
    <!-- Main Heading Ends -->

    @include('_raduga.components.shop.product.elements.product_list')
@endsection