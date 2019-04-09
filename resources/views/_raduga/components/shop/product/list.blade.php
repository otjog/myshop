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
                    <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="product-col">
                        <div class="image">
                            <a href="{{ route( 'products.show', $product->id ) }}">

                                @if( isset($product->images[0]->name) && $product->images[0]->name !== null )
                                    <img
                                            class="img-fluid"
                                            src="{{route('models.sizes.images.show', ['product', 's', $product->images[0]->name])}}"
                                            alt="product"
                                    />
                                @else
                                    <img
                                            class="img-fluid"
                                            src="{{route('models.sizes.images.show', ['product', 's', 'no_image.jpg'])}}"
                                            alt="product"
                                    />
                                @endif

                            </a>
                        </div>
                        <div class="caption">
                            <h4>
                                <a href="{{ route( 'products.show', $product->id ) }}">
                                    @isset($product->manufacturer['name'])
                                        {{ $product->manufacturer['name'] . ' ' }}
                                    @endisset
                                    {{ $product->name }}
                                    @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)
                                        @foreach($product->brands as $brand)
                                            {{ ' | ' . $brand->name}}
                                        @endforeach
                                    @endif
                                </a>
                            </h4>
                            @if( isset($product->price['value']) && $product->price['value'] !== null)
                                <div class="price">
                                    <span class="price-new">{{ $product->price['value']}}{{$global_data['project_data']['components']['shop']['currency']['symbol']}}
                                    </span>
                                    <span class="price-old">
                                        @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                                            {{$product->price['value'] + $product->price['sale']}}{{$global_data['project_data']['components']['shop']['currency']['symbol']}}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            <div class="cart-button button-group">
                                @if( !isset($product->basket_parameters) || count($product->basket_parameters) === 0)
                                    <form method="post" role="form" action="{{route('baskets.store')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="product_id"       value="{{ $product->id}}">
                                        <input type="hidden" name="quantity" value="1" >
                                        <button type="submit" class="btn btn-cart">
                                            В корзину
                                        </button>
                                    </form>
                                @else
                                    <a class="pt-2 d-block" href="{{ route( 'products.show', $product->id ) }}">
                                        Перейти к товару
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Ends -->
            @endforeach
        </div>
    @endforeach
    <!-- Product Grid Display Ends -->

    <!-- Shop Page Navigation -->
    @include($global_data['project_data']['template_name'] .'.modules.pagination.default')
@endif