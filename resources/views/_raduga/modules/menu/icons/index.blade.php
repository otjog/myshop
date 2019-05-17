@if(isset($menus[$menu_name]) && $menus[$menu_name] !== null)
    <div class="container">
        <div class="card-deck">
            @if(isset($menus[$menu_name]->models) && $menus[$menu_name]->models !== null)
                @foreach($menus[$menu_name]->models as $menu_model)
                    @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)

                        @foreach($menu_model[$menu_model->name]->chunk($global_data['components']['shop']['chunk_categories']) as $item_row)
                            <div class="row">
                                @foreach($item_row as $item)
                                    <div class="card mt-4 rounded-0">
                                        <a href="{{Route($menu_model->name . '.show', $item['id'])}}">
                                            <img
                                                    src="{{route('models.sizes.images.show', ['category', 's', $item['img']])}}"
                                                    class="card-img-top"
                                                    alt="{{$item['name']}}"
                                            >
                                        </a>
                                        <div class="card-body px-2">
                                            <a href="{{Route($menu_model->name . '.show', $item['id'])}}">
                                                <h6 class="card-title text-dark text-center"><u>{{$item['name']}}</u></h6>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endif