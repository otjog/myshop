@extends('_raduga.index')

@section('component')
    <!-- Product Filter Starts -->
    <div class="product-filter">
        <div class="row">
            <div class="col-md-4">
                <div class="display">
                    <a href="category-list.html">
                        <i class="fa fa-th-list" title="List View"></i>
                    </a>
                    <a href="category-grid.html" class="active">
                        <i class="fa fa-th" title="Grid View"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-2 text-right">
                <label class="control-label">Sort</label>
            </div>
            <div class="col-md-3 text-right">
                <select class="form-control custom-select rounded-0">
                    <option value="default" selected="selected">Default</option>
                    <option value="NAZ">Name (A - Z)</option>
                    <option value="NZA">Name (Z - A)</option>
                </select>
            </div>
            <div class="col-md-1 text-right">
                <label class="control-label" for="input-limit">Show</label>
            </div>
            <div class="col-md-2 text-right">
                <select id="input-limit" class="form-control custom-select rounded-0">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3" selected="selected">3</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Product Filter Ends -->
    @if(isset($products) && count($products) > 0)
        <!-- Product Grid Display Starts -->
        @foreach($products->chunk($global_data['project_data']['components']['shop']['chunk_products']) as $products_row)
            <div class="row">
                @foreach( $products_row as $key => $product )
                    <!-- Product Starts -->
                        @include('_raduga.components.shop.product.elements.product_card', ['wrapClass' => 'col-lg-4 col-md-6 col-sm-12 p-1'])
                    <!-- Product Ends -->
                @endforeach
            </div>
        @endforeach
        <!-- Product Grid Display Ends -->

        <!-- Shop Page Navigation -->
        @include('_raduga.modules.pagination.index', ['module' => ['module' => 'pagination','template' => 'default']])
    @endif
@endsection