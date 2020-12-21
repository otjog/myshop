<div class="d-block d-sm-none fixed-bottom bg-light pb-1 pt-1 shadow">
    <div class="my-1 d-flex flex-row justify-content-center">

        <div class="mx-1">
            @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.contact')
        </div>
        @if( isset($product->stores) && $product->stores !== null && count($product->stores) > 0 )
            <div class="mx-1">
                @include( $global_data['template']['name']. '.components.shop.product.show.sell_block.fastbuy')
            </div>
        @endif

    </div>
</div>