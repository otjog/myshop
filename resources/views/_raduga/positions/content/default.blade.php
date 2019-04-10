<div id="main-container-home" class="container">

    @if(isset( $template['banner'] ))
        @include('_raduga.modules.banner.default')
    @endif

        <div class="row">
            @if(isset($template['sidebar']))
                <div class="col-md-3 col-sm-12">
                    @include('_raduga.modules.'.$template['sidebar'].'.default')
                </div>
                @php $colMdComponent = '9'; @endphp
            @else
                @php $colMdComponent = '12'; @endphp
            @endif

            <div class="col-md-{{$colMdComponent}} col-sm-12">
                @yield('component')
            </div>

        </div>

    @if(isset( $template['modules'] ) && count( $template['modules'] ) > 0)
        @foreach($template['modules'] as $folder => $file)

            @include('_raduga.modules.' . $folder . '.' . $file)

        @endforeach
    @endif
</div>

