@if($product->price['value'] !== 0.00)
        <div class="
                product_price
                clearfix
                @if( !isset($product->stores) || $product->stores === null || count($product->stores) === 0 )
                        text-black-50
                @endif
        ">
                {{ $product->price['value'] }}
                <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
        </div>
@else
        <div class="pt-3">
                <span class="text-dark m-0">
                        <i class="fas fa-exclamation-circle"></i>
                        Цена не установлена
                </span>
        </div>
@endif