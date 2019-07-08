@if($slide['url'] !== null)
    <a href="{{asset($slide['url'])}}">
@endif
    <img
        @if($slide->images[0]->alt !== null) alt="{{$slide->images[0]->alt}}" @endif
        src="{{route('getImage', ['banner', 'main', $slide->images[0]->src])}}"
    >
@if($slide['url'] !== null)
    <a href="{{asset($slide['url'])}}">
@endif