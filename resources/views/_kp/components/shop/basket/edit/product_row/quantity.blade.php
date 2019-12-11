<div class="btn-group" role="group" aria-label="Buy Button Group">

    <form
            class="shop-buy-form"
            method="post"
            role="form"
            action="{{route('baskets.products.update', [csrf_token(), $product->id])}}"

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
        <input type="hidden" name="add" value="-1">
        <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input class="btn bg-grey" type="submit" value="-" />
    </form>

    <form
            class="shop-buy-form mx-1"
            method="post"
            role="form"
            action="{{route('baskets.products.update', [csrf_token(), $product->id])}}"

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
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="add" value="0">
        <input
                type="text"
                name="quantity"
                value="{{$product->baskets[0]->pivot['quantity']}}"
                class="form-control quantity_input text-center"
                size="4">
    </form>

    <form
            class="shop-buy-form"
            method="post"
            role="form"
            action="{{ route('baskets.products.update', [csrf_token(), $product->id]) }}"
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
        <input type="hidden" name="add" value="1" >
        <input type="hidden" name="quantity" value="{{$product->baskets[0]->pivot['quantity']}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <input class="btn bg-primary" type="submit" value="+" />
    </form>

</div>