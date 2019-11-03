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
                @include( $global_data['template']['name']. '.components.shop.product.show.name')

                {{-- Images --}}
                <div class="col-lg-7">
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

                        {{-- Best Shipment Offer --}}
                        <div id="shipment-best-offer" class="py-1">
                            @include($global_data['template']['name']. '.modules.shop.shipment._elements.best-offer')
                        </div>

                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <div class="col-lg-12 order-4 my-4">
                    @if(isset( $product->description ))
                        <div class="py-1 my-1">
                            <p>{!! $product->description  !!}</p>
                        </div>
                    @endif

                        @if( isset($product->parameters) && count($product->parameters) > 0)
                            @php $product->parameters = $product->parameters->groupBy('alias'); @endphp
                            <div class="container py-1 my-1">
                                @foreach($product->parameters as $currentParameters)

                                    @if(count($currentParameters) > 0)
                                        <div class="row">
                                            @foreach($currentParameters as $key => $parameter)
                                                @if($loop->first)
                                                    <div class="col col-lg-3 pl-0 ml-2 product_parameter_name">
                                                        <span>{{$parameter->name}}:</span>
                                                    </div>
                                                    <div class="col col-lg-3 text-muted pl-1">
                                                        @endif
                                                        <span>{{$parameter->pivot->value}}</span>
                                                        @if($loop->last)
                                                    </div>
                                                @else
                                                    <span> | </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif


                                @endforeach
                            </div>
                        @endif

                        @if(isset($global_data['modules']['shop.order.shipment.index']))
                            @include(
                                $global_data['template']['name']. '.modules.shop.shipment.index',
                                    [
                                        'shipments' => $global_data['modules']['shop.order.shipment.index'],
                                        'module' => ['template' =>'product']
                                    ]
                            )
                        @endif

                </div>
            </div>
        </div>
    </div>

@endsection