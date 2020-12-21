@if( !isset($product->stores) || $product->stores === null || count($product->stores) === 0 )
    <div class="pb-3">
            <span class="text-dark">
                 <i class="fas fa-exclamation-circle"></i>
                Товар распродан
            </span>
    </div>
@endif
