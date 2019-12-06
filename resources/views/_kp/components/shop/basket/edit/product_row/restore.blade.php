<span class="text-muted">Товар был удален из корзины.</span>
<form
        class="shop-buy-form"
        method="post"
        role="form"
        action="{{ route('baskets.products.store', csrf_token()) }}"

        data-ajax
        data-ajax-event-name="submit"
        data-ajax-method="post"
        data-ajax-name="shop-basket-add_product-{{$product->id}}"

        data-ajax-method1="get"
        data-ajax-action1="{{route('products.show', $product->id)}}"
        data-ajax-name1="shop-basket-update_html_buy-button-{{$product->id}}"
        data-ajax-reload-class1="shop-basket-button-group"
        data-ajax-view1="{{$global_data['template']['name']. '.components.shop.basket.edit.product_row._reload'}}"

        data-ajax-method2="get"
        data-ajax-action2="{{route('baskets.show', csrf_token())}}"
        data-ajax-name2="shop-basket-update_html_module"
        data-ajax-reload-class2="shop-module-basket"
        data-ajax-view2="{{$global_data['template']['name']. '.modules.shop.basket._elements.module'}}"

        data-ajax-method3="get"
        data-ajax-action3="{{route('baskets.show', csrf_token())}}"
        data-ajax-name3="shop-basket-update_html_total-block"
        data-ajax-reload-class3="shop-basket-total"
        data-ajax-view3="{{$global_data['template']['name']. '.components.shop.basket.edit.total_block._reload'}}"
>
    <input type="hidden" name="product_id" value="{{ $product->id}}">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    <input class="btn btn-link" type="submit" value="Восстановить" />
</form>