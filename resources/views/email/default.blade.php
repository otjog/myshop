<ul>
    @foreach($data as $name => $value)
        <li>
            {{$name}} : {!!$value!!}
        </li>
    @endforeach
</ul>