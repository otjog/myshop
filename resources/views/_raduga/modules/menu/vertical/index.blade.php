@if(isset($menus[$menu_alias]) && $menus[$menu_alias] !== null)
    <h3 class="side-heading">{{$menus[$menu_alias]['name']}}</h3>
    <div class="list-group categories">
        @if(isset($menus[$menu_alias]->models) && $menus[$menu_alias]->models !== null)
            @foreach($menus[$menu_alias]->models as $menu_model)
                @foreach($menu_model[$menu_model->name] as $item)
                    <a href="{{Route($menu_model->name . '.show', $item['id'])}}" class="list-group-item">
                        <i class="fa fa-angle-right"></i>
                        {{$item['name']}}
                    </a>
                @endforeach
            @endforeach
        @endif
    </div>
@endif