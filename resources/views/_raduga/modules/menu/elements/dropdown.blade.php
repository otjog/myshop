<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        {{$model->header}}
    </a>

    <div class="dropdown-menu rounded-0">
        @foreach($model[$model->name] as $item)
            <a href="{{Route($model->name . '.show', $item['id'])}}" class="dropdown-item">{{$item['name']}}</a>
        @endforeach
    </div>
</li>