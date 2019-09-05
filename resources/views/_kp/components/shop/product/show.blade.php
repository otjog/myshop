@extends('_kp.index')

@section('component')

    <?php
        $product =& $global_data['shop']['product'];
        $parcelData =& $global_data['shop']['parcelData'];
    ?>

    <div class="single_product">
        <div class="container">
            <div class="row">

                <h1 class="product_name">
                    @isset($product->manufacturer['name'])
                        {{ $product->manufacturer['name'] . ' ' }}
                    @endisset

                    {{ $product->name }}

                    @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)

                        @foreach($product->brands as $brand)
                            {{ ' | ' . $brand->name}}
                        @endforeach

                    @endif
                </h1>

                {{-- Images --}}
                <div class="col-lg-7">
                    <div class="row">
                        @include( $global_data['template']['name']. '.components.shop.product.elements.images.gallery')
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div>Категория: <span class="text-muted">{{$product->category['name']}}</span></div>
                        <div>Артикул: <span class="text-muted">{{$product->scu}}</span></div>

                        {{-- Price And Buy --}}
                        @include( $global_data['template']['name']. '.components.shop.product.elements.price.show')

                        {{-- Best Shipment Offer --}}
                        <div id="shipment-best-offer" class="py-1">
                            @include($global_data['template']['name']. '.modules.shop.shipment._elements.best-offer')
                        </div>

                    </div>
                </div>

                {{-- TABS --}}
                <div class="col-lg-12 order-4 my-4">

                    <ul class="nav nav-tabs" id="tabs">
                        @if(isset($product->description) && $product->description !== '')
                            <li class="nav-item">
                                <a class="nav-link" data-tabIndex="description">Описание</a>
                            </li>
                        @endif
                        @if( isset($product->parameters) && count($product->parameters) > 0)
                            <li class="nav-item">
                                <a class="nav-link" data-tabIndex="parameters">Характеристики</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" data-tabIndex="shipment">Доставка</a>
                        </li>
                    </ul>

                    <div class="pt-3" id="tab-data">

                        {{-- Description Tab --}}
                        <div class="tab-data data-description">
                            @if(isset( $product->description ))
                                <p>{!! $product->description  !!}</p>
                            @endif
                        </div>

                        {{-- Parameters Tab --}}
                        <div class="tab-data data-parameters">

                            @if( isset($product->parameters) && count($product->parameters) > 0)
                                @php $product->parameters = $product->parameters->groupBy('alias'); @endphp
                                <div class="container">
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
                        </div>

                        {{-- Shipment Tab --}}
                        <div class="tab-data data-shipment">
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
        </div>
    </div>

@endsection