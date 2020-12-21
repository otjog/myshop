@extends('_kp.index')

@section('component')

    <?php
        $product =& $global_data['shop']['product'];
        $parcelData =& $global_data['shop']['parcelData'];
    ?>

    <div class="single_product">
        <div class="container">
            <div class="row">

                {{-- Name --}}
                <div class="order-2 order-sm-1">
                    @include( $global_data['template']['name']. '.components.shop.product.show.name')
                </div>

                {{-- Images --}}
                <div class="col-lg-7 order-1 order-sm-2">
                    @include( $global_data['template']['name']. '.components.shop.product.show.image')
                </div>

                {{-- Right Column --}}
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div>Категория: <span class="text-muted">{{$product->category['name']}}</span></div>
                        <div>Артикул: <span class="text-muted">{{$product->scu}}</span></div>

                        {{-- Sell Block RELOAD--}}
                        <div class="shop-basket-button-group"
                             data-route="{{route('products.views.show', [$product->id, $global_data['template']['name']. '.components.shop.product.show.sell_block'])}}">
                            @include( $global_data['template']['name']. '.components.shop.product.show.sell_block')
                        </div>

                        {{-- Quantity Discounts --}}
                        @include( $global_data['template']['name']. '.components.shop.product.show.quantity_discount')

                        @if( isset($product->stores) && $product->stores !== null && count($product->stores) !== 0 )
                            {{-- Best Shipment Offer --}}
                            <div id="shipment-best-offer" class="py-1">
                                @include($global_data['template']['name']. '.modules.shop.shipment._elements.best-offer')
                            </div>
                        @endif

                    </div>
                </div>

                {{-- DESCRIPTION --}}
                    @include($global_data['template']['name']. '.components.shop.product.show.description')
            </div>
        </div>
    </div>

@endsection