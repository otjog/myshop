<header id="header-area">
        @if(isset($template['top']) && $template['top'] !== null)
            @foreach($template['top'] as $module)
                @if(count($module) > 0)
                    @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
                @endif
            @endforeach
        @endif
</header>