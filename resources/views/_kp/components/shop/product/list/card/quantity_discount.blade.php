@if(isset($product->quantity_discounts) && $product->quantity_discounts !== null && count($product->quantity_discounts) > 0)
    <span class="small border-bottom-dotted">
            @php $quantity_discount = $product->quantity_discounts->last(); @endphp
        <a class="text-dark" href="#" data-toggle="modal" data-target="#productBasketModal" data-json="{{$product->toJson()}}">
                Крупный опт от
            {{$quantity_discount->pivot['totalPrice']}}
            <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
            </a>
        </span>

@else
    <div class="mt-3">{{-- Если нет скидки, этот блок опускает цену вниз --}}</div>
@endif