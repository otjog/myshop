@if(isset($menus[$menu_name]) && $menus[$menu_name] !== null)
    <h3 class="side-heading">{{$menus[$menu_name]['header']}}</h3>
    <div class="list-group categories">
        @if(isset($menus[$menu_name]->models) && $menus[$menu_name]->models !== null)
            @foreach($menus[$menu_name]->models as $menu_model)
                @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
                    @foreach($menu_model[$menu_model->name] as $item)
                        <a href="{{Route($menu_model->name . '.show', $item['id'])}}" class="list-group-item">
                            <i class="fa fa-angle-right"></i>
                            {{$item['name']}}
                        </a>
                    @endforeach
                @endif
            @endforeach
        @endif
    </div>
@endif