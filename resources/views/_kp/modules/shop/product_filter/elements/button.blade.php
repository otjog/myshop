<div class="row">
    <div class="col-6">
        <a
                href="{{Request::url()}}"
                data-ajax
                data-ajax-push-state="1"
                data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                data-ajax-event-name="click"
                data-ajax-method="get"
                data-ajax-name="shop-filter-product"
                data-ajax-reload-class="product-list"
                class="btn btn-outline-danger btn-block btn-xs my-3"
                role="button">
            Очистить
        </a>
    </div>
    <div class="col-6">
        <div class="filter-button filter ">
            <button class="btn btn-success btn-block btn-xs filter-action my-3" type="submit">Показать</button>
        </div>
    </div>
</div>