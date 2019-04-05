@foreach($model[$model->name] as $item)
    <li class="nav-item"><a href="{{Route($model->name . '.show', $item['id'])}}" class="nav-link">{{$item['name']}}</a></li>
@endforeach