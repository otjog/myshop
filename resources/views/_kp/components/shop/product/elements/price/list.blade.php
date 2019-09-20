<?php dump($product->quantity_discounts)?>
<div class="col-6 text-center pt-2 m-auto price">
    @if( isset($product->price['value']) && $product->price['value'] !== null && $product->price['value'] !== 0.00)
        @if( isset($product->price['sale']) && $product->price['sale'] > 0)
            <span class="small text-danger">
                <s>
                    {{$product->price['value'] + $product->price['sale']}}
                    <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                </s>
            </span>
        @else
            <div class="mt-3">{{-- Если нет скидки, этот блок опускает цену вниз --}}</div>
        @endif
            <strong>{{ $product->price['value']}}</strong><small>{{$global_data['components']['shop']['currency']['symbol']}}</small>

        @if( isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0 )

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
            @endif

    @endif
</div>