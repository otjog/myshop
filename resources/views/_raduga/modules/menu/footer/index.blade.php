@if(isset($menus[$menu_alias]) && $menus[$menu_alias] !== null)
    <div class="col-lg-2 col-md-3 col-sm-3">
        <h5>{{$menus[$menu_alias]['name']}}</h5>
        <ul class="list-unstyled">
            @if(isset($menus[$menu_alias]->models) && $menus[$menu_alias]->models !== null)
                @foreach($menus[$menu_alias]->models as $menu_model)
                    @foreach($menu_model[$menu_model->name] as $item)
                        <li>
                            <a href="{{Route($menu_model->name . '.show', $item['id'])}}">{{$item['name']}}</a>
                        </li>
                    @endforeach
                @endforeach
            @endif
        </ul>
    </div>
@endif