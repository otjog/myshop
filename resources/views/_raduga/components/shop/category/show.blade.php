@extends('_raduga.index')

@section('component')

    <?php
        $category =& $global_data['category'];
        $products =& $global_data['products'];
        $parameters =& $global_data['parameters'];
    ?>

    <!-- Main Heading Starts -->
        <h2 class="main-heading2 page-title">
            {{$global_data['header_page']}}
        </h2>
    <!-- Main Heading Ends -->

    @include('_raduga.components.shop.product.elements.product_list')
@endsection