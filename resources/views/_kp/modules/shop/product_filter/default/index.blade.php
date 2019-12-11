@if (isset($filters) && count($filters) > 0 )

    @php
        $filterPrefix = $global_data['components']['shop']['filter_prefix'];
    @endphp

    <div class ="product-filter d-none d-md-block">
        <form
                class="product-filter-form"
                name="product_filter"
                role="form"
                method="GET"
                action="{{Request::url()}}"
                data-ajax
                data-ajax-push-state="1"
                data-ajax-event-name="submit"
                data-ajax-method="get"
                data-ajax-name="shop-filter-product"
                data-ajax-reload-class="product-list"
                data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                data-ajax-effects="spinner"
        >

            @foreach ($filters as $filter)

                <div class="mx-1 pt-1 border-bottom filter filter-{{$filter['alias']}} filter-{{$filter['type']}} @if($filter['type'] === 'slider-range')filter-slider @endif">

                    <div class="filter-header my-2">
                            <span>
                                <a
                                        class="collapsed"
                                        data-toggle="collapse"
                                        data-target="#collapse-{{$filter['alias']}}"
                                        aria-expanded="{{$filter['expanded']}}"
                                        aria-controls="collapse-{{$filter['alias']}}">

                                    {{$filter['name']}}

                                    <span class="pl-1">
                                        <i class="fas fa-angle-down collapse-arrow-down"></i>
                                        <i class="fas fa-angle-up collapse-arrow-up"></i>
                                    </span>
                            </a>
                            </span>
                        <small class="filter-clear float-right border-bottom-dotted" style="display: none;">Очистить</small>
                    </div>
                    <div class="collapse pb-3 @if($filter['expanded'] === 'true') show @endif" id="collapse-{{$filter['alias']}}">
                        @include( $global_data['template']['name'] .'.modules.shop.product_filter.elements.'.$filter['type'], [$filter])
                    </div>

                </div>
            @endforeach

        {{-- Filter's Button --}}
            @include( $global_data['template']['name'] .'.modules.shop.product_filter.elements.button')

        </form>
    </div>
    {{-- Фильтр для мобильных --}}
    @include( $global_data['template']['name'] .'.modules.shop.product_filter.responsive.index')

@endif