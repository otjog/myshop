@extends('_raduga.index')

@section('component')
    <!-- Main Heading Starts -->
        <h2 class="main-heading2 page-title">
            {{$header_page}}
        </h2>
    <!-- Main Heading Ends -->

    @include( $global_data['project_data']['template_name'] .'.components.shop.product.list')
@endsection