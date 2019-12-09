@if( isset($product->price['value']) && $product->price['value'] !== null)

    @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.sale')

    @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.price')

    @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.store')

    @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
        <div class="my-1 d-flex flex-row">
            <div class="order-1 mr-2 ">
                @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.forms')
            </div>
            <div class="order-2">
                @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.fastbuy')
            </div>
        </div>
    @endif

@else
    <div class="alert alert-warning">
        Мы не смогли отобразить цену. Позвоните нам и мы всё исправим.
    </div>
@endif

@include( $global_data['template']['name']. '.components.shop.product.show.sell_block.mobile')
@include( $global_data['template']['name']. '.positions.modals.forms.fastbuy')