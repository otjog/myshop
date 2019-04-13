@if( isset($offers[$offer_alias]) & $offers[$offer_alias] !== null)
    @if( isset($offers[$offer_alias]->products) && count($offers[$offer_alias]->products) > 0)
        <section class="product-carousel">
            <!-- Heading Starts -->
            <h2 class="product-head">{{$offers[$offer_alias]->header}}</h2>
            <!-- Heading Ends -->
            <!-- Products Row Starts -->
            <div class="row">
                <div class="col-12">
                    <!-- Product Carousel Starts -->
                    <div class="owl-carousel">
                    @foreach($offers[$offer_alias]->products as $product)
                        <!-- Product Starts -->
                        @include('_raduga.components.shop.product.elements.product_card', ['wrapClass' => 'item'])
                        <!-- Product Ends -->
                        @endforeach
                    </div>
                    <!-- Product Carousel Ends -->
                </div>
            </div>
            <!-- Products Row Ends -->
        </section>
    @endif
@endif