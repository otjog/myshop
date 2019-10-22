
@if( isset($product->price['value']) && $product->price['value'] !== null)

    @if( isset($product->price['sale']) && $product->price['sale'] > 0)

        <div class="product_price text-muted mr-3 clearfix">
            <s>
                <small>{{$product->price['value'] + $product->price['sale']}}</small>
                <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
            </s>
        </div>

    @endif

    <div class="product_price clearfix">
        @if($product->price['value'] !== 0.00)
            {{ $product->price['value'] }}
            <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
        @else
            <span class="text-muted m-0">Цена не установлена</span>
        @endif
    </div>
    <div>
        @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
            <small class="text-success">В наличии</small>
        @else
            <small class="text-muted">Нет в наличии</small>
        @endif
    </div>

    @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
        <div class="my-1 d-flex flex-row shop-basket-button-group" data-view="product_show">
            @include( $global_data['template']['name']. '.components.shop.product.elements.buy_button.show')
        </div>
        @if( isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0 )
            <div class="border rounded py-2 px-3">
                <h5>Покупка оптом</h5>
                <ul>
                    @foreach($product->quantity_discounts as $quantity_discount)
                        @if(isset($quantity_discount->pivot['totalPrice']) && $quantity_discount->pivot['totalPrice'] !== null)
                            <li class="py-1">
                                <div class="row">
                                    <div class="col">
                                        <span>
                                            от
                                            <strong>{{$quantity_discount->pivot['quantity']}}</strong>
                                            шт.
                                        </span>
                                        -
                                        <span>
                                            <strong>
                                                {{$quantity_discount->pivot['totalPrice']}}
                                            </strong>
                                            <small>
                                            {{$global_data['components']['shop']['currency']['symbol']}}/шт
                                            </small>
                                        </span>
                                    </div>
                                </div>

                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    @endif

@else
    <div class="alert alert-warning">
        Мы не смогли отобразить цену. Позвоните нам и мы всё исправим.
    </div>
@endif