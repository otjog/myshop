@extends('_kp.index')

@section('component')
    <?php
        $order =& $global_data['shop']['order'];
    ?>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h2>Номер заказа: {{$order->id}}-{{$order->shop_basket_id}}-{{strtotime($order->created_at)}} </h2>
    <div class="row">
        <div class="col-lg-6">
            Данные о покупателе:
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Имя: {{$order->customer->full_name}}</li>
                <li class="list-group-item">Телефон: {{$order->customer->phone}}</li>
                <li class="list-group-item">E-Mail: {{$order->customer->email}}</li>
                <li class="list-group-item">Адрес: {{$order->customer->address}}</li>
            </ul>
        </div>

        <div class="col-lg-6">
            Данные об оплате
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Способ оплаты: {{$order->payment->name}}</li>
                <li class="list-group-item">Статус оплаты: @if($order->paid) Оплачен @else Не оплачен @endif</li>
            </ul>
            Данные о доставке
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Способ доставки: {{$order->shipment->name}}</li>
                <li class="list-group-item">Адрес: {{$order->delivery_address}}</li>
                <li class="list-group-item">
                    Срок доставки:
                    @if($order->shipment_days === "-1")
                        <span class="text-danger">Необходимо уточнить адрес</span>
                    @else
                        {{$order->shipment_days}}
                    @endif
                </li>
                <li class="list-group-item">
                    Стоимость доставки:
                    @if($order->shipment_price === -1)
                        <span class="text-danger">Необходимо уточнить адрес</span>
                    @else
                        {{$order->shipment_price}}{{$global_data['components']['shop']['currency']['symbol']}}
                    @endif
                </li>
            </ul>
        </div>
    </div>
    @if($order->comment !== null && $order->comment !== '')
        <hr>
        Комментарий:
        <p>
            {{$order->comment}}
        </p>
        <hr>
    @endif
    <div class="row">
        <div class="col-lg-12">
            Данные о товарах в заказе:
            <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                <div class="col-lg-2 py-1 px-2">
                    Изображение
                </div>

                <div class="col-lg-4">
                    Название
                </div>

                <div class="col-lg-2 text-center">
                    Цена
                </div>

                <div class="col-lg-2 text-center">
                    Количество
                </div>

                <div class="col-lg-2 text-center">
                    Стоимость
                </div>

            </div>

            @foreach($order->products as $product)

                <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                    <div class="col-lg-1 py-1 px-2">
                        @php
                            if (count($product->images) > 0)
                                $imageSrc = $product->images[0]->src;
                            else
                                $imageSrc = 'noimage';
                        @endphp
                        <img
                                class='img-fluid mx-auto my-auto d-block'
                                src="{{route('getImage', ['product', 'xs', $imageSrc, $product->id])}}"
                                alt="{{$product->images[0]->alt or $product->name}}"
                        />
                    </div>

                    <div class="col-lg-5">
                        <a href="{{ route('products.show', $product->id) }}">
                            {{ $product->name }}
                        </a>
                        @if( isset($product->pivot['order_attributes_collection']) && count( $product->pivot['order_attributes_collection'] ) > 0)
                            <br>
                            @foreach($product->pivot['order_attributes_collection'] as $attribute)

                                <span class="text-muted small">

                                        {{$attribute->name}} : {{$attribute->pivot->value}}

                                </span>

                            @endforeach

                        @endif
                    </div>

                    <div class="col-lg-2 text-center">
                        <span class="text-muted">{{ $product->price['value'] }}</span>
                        <span class="text-muted small"><small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
                    </div>

                    <div class="col-lg-2 text-center">
                        <span class="text-muted">{{ $product->pivot['quantity'] }}
                            <span class="text-muted small"><small>шт.</small></span>
                        </span>
                    </div>

                    <div class="col-lg-2 text-center">
                        <span>{{ $product->price['value'] * $product->pivot['quantity'] }}</span>
                        <span class="text-muted small"><small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
                    </div>

                </div>

            @endforeach

            <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                <div class="col-lg-10 text-right">
                    Стоимость товаров:
                </div>

                <div class="col-lg-2 text-center">
                    <span>{{ $order->total }}</span>
                    <span class="text-muted small"><small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
                </div>

            </div>

            @if($order->shipment_price !== -1)
                <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                    <div class="col-lg-10 text-right">
                        Стоимость доставки:
                    </div>

                    <div class="col-lg-2 text-center">
                        <span>{{$order->shipment_price}}</span>
                        <span class="text-muted small"><small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
                    </div>

                </div>
            @endif

            @if($order->payment->tax !== 0)

                <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                    <div class="col-lg-10 text-right">
                        @if($order->payment->tax < 0 ) Дополнительная скидка: @else Комиссия: @endif
                    </div>

                    <div class="col-lg-2 text-center">
                        <span>
                            @if($order->payment->tax_type === 'percent')
                                {{round($order->total * $order->payment->tax/100, 0)}}
                            @else
                                {{ $order->payment->tax }}
                            @endif
                        </span>
                        <span class="text-muted small"><small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
                    </div>

                </div>

                <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                    <div class="col-lg-10 text-right">
                        Итого:
                    </div>

                    <div class="col-lg-2 text-center">
                        <span>
                            @if($order->payment->tax_type === 'percent')
                                {{ round($order->total + $order->shipment_price - $order->total * $order->payment->tax/100*-1, 0) }}
                            @else
                                {{ round($order->total + $order->shipment_price + $order->payment->tax) }}
                            @endif
                        </span>
                        <span class="text-muted small"><small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
                    </div>

                </div>

            @endif


        </div>

    </div>
@endsection