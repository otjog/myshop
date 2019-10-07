@if(isset($product) && $product !== null)

    <form method="POST" id="basket_form" role="form" accept-charset="UTF-8">

        <div class="row py-3">
            <div class="order-1 col-6   order-lg-1 col-lg-1     py-lg-1 px-lg-2">
                @php
                    if (count($product->images) > 0)
                        $imageSrc = $product->images[0]->src;
                    else
                        $imageSrc = 'noimage';
                @endphp
                <img
                        class="img-fluid"
                        src="{{route('getImage', ['product', 's', $imageSrc, $product->id])}}"
                        alt="{{$product->images[0]->alt or $product->name}}"
                />
            </div>
            <div class="order-3 col-12  order-lg-2 col-lg-5">
                <a href="{{ route('products.show', $product->id) }}">
                    {{ $product->name }}
                </a>
                {{-- Атрибуты --}}
                @if( isset($product['pivot']['order_attributes_collection']) && count( $product['pivot']['order_attributes_collection'] ) > 0)
                    <br>
                    @foreach($product['pivot']['order_attributes_collection'] as $attribute)

                        <span class="text-muted small">

                                            {{$attribute->name}} : {{$attribute->pivot->value}}

                                    </span>

                    @endforeach

                @endif

            </div>
            <div class="order-2 col-6   order-lg-3 col-lg-6">
                <div class="row">
                    <div class="col-12 col-lg-6 py-2 text-muted">
                        <div class="row no-gutters">
                            <div class="col-4 text-center py-2">
                                <div
                                        class="icon quantity_control quantity_dec"
                                        data-quantity-min-value="0">
                                    <i class="far fa-minus-square"></i>
                                </div>
                            </div>
                            <div class="col-4 text-center">

                                <input
                                        type="hidden"
                                        name="product_id"
                                        value="{{ $product->id }}">
                                <input
                                        type="text"
                                        name="quantity"
                                        value="{{$quantity}}"
                                        class="form-control quantity_input text-center px-1"
                                        size="5" >

                            </div>
                            <div class="col-4 text-center py-2">
                                <div
                                        class="icon quantity_control quantity_inc">
                                    <i class="far fa-plus-square"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-lg-4 py-3 text-center">
                        <span>{{ $product->price['value'] * $quantity}}</span>
                        <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
                    </div>
                </div>
            </div>
        </div>
    </form>

        {{-- Кнопки действий --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Продолжить покупки</button>
        <a href="{{route('baskets.edit', csrf_token())}}" class="btn btn-danger">Перейти в корзину</a>
    </div>

        {{-- Блок оптовой покупки --}}

        @if( isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0 )
            <div class="border-top py-3 ">
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
                                        <form class="shop-buy-form" method="post" role="form" action="{{route('baskets.store')}}">
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
