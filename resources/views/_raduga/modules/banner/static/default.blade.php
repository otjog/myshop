@if($banner->img !== null)
    <div class="carousel-item @if ($loop->first) active @endif">
        <a href="{{$banner->source}}">
            <img src="{{ URL::asset('storage/img/banners/default/l/' . $banner->img) }}">
        </a>
    </div>
@endif