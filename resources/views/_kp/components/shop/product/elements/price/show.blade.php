@if( isset($product->price['value']) && $product->price['value'] !== null)

    @if( isset($product->price['sale']) && $product->price['sale'] > 0)

        <div class="product_price text-muted mr-3 clearfix">
            <s>
                <small>{{$product->price['value'] + $product->price['sale']}}</small><small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
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
        <div class="my-1 d-flex flex-row">
            <form id="buy-form" method="post" role="form" action="{{route('baskets.store')}}">

                <div class="product_quantity">
                    <span>Кол-во: </span>
                    <input type="text"      name="quantity"     value="1" size="5" pattern="[0-9]*" class="quantity_input">
                    <input type="hidden"    name="product_id"   value="{{$product->id}}">
                    <input type="hidden"    name="_token"       value="{{csrf_token()}}">

                    <div class="quantity_buttons">
                        <div
                                class="quantity_inc quantity_control"
                        >
                            <i class="fas fa-chevron-up"></i>
                        </div>
                        <div
                                class="quantity_dec quantity_control"
                                data-quantity-min-value="1"
                        >
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="button_container">
                    <button type="submit" class="button cart_button">Купить</button>
                </div>

                @if( isset($product->basket_parameters) && count($product->basket_parameters) > 0)
                    <div class="order_parameters my-3 float-left">
                        @foreach($product->basket_parameters as $key => $parameter)
                            @if($key === 0 || $product->basket_parameters[$key -1 ]->name !== $parameter->name)
                                <strong>{{$parameter->name}}: </strong>
                            @endif

                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input
                                            class="custom-control-input"
                                            type="radio"
                                            required=""
                                            name="order_attributes[]"
                                            id="{{ $parameter->pivot->id }}"
                                            value="{{ $parameter->pivot->id }}"
                                    >
                                    <label class="custom-control-label" for="{{ $parameter->pivot->id }}">{{$parameter->pivot->value }}</label>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif

            </form>
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
                                    <div class="col">
                                        <form id="buy-form" method="post" role="form" action="{{route('baskets.store')}}">
                                            <input type="hidden" name="quantity"     value="{{$quantity_discount->pivot['quantity']}}">
                                            <input type="hidden" name="product_id"   value="{{$product->id}}">
                                            <input type="hidden" name="_token"       value="{{csrf_token()}}">
                                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                                Купить за {{$quantity_discount->pivot['quantity'] * $quantity_discount->pivot['totalPrice']}}
                                                {{$global_data['components']['shop']['currency']['symbol']}}
                                            </button>
                                        </form>

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