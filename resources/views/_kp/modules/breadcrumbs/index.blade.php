<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-0 bg-transparent">

        @if(count($breadcrumbs) > 0)
            <li class="breadcrumb-item p-0 p-sm-1"><a href="{{$global_data['site_url']}}">Главная</a></li>
        @endif

        @foreach($breadcrumbs as $item)
            @if($loop->last)
                <li class="breadcrumb-item active p-0 p-sm-1 d-none d-sm-inline" aria-current="page">{{$item['name']}}</li>
            @else
                <li class="breadcrumb-item p-0 p-sm-1"><a href="{{$item['href']}}">{{$item['name']}}</a></li>
            @endif
        @endforeach
    </ol>
</nav>