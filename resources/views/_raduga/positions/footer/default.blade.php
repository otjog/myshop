@php
    $template = $global_data['template']['schema']['current']['footer'];
@endphp
<footer id="footer-area">
    <!-- Footer Links Starts -->
    <div class="footer-links">
        <!-- Container Starts -->
        <div class="container text-center text-sm-left">
            <!-- Nested Row Starts -->
            <div class="row">
                @if(isset($template['top']) && $template['top'] !== null)
                    @foreach($template['top'] as $module)
                        @if(count($module) > 0)
                            @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
                        @endif
                    @endforeach
                @endif
            </div>
            <!-- Nested Row Ends -->
        </div>
        <!-- Container Ends -->
    </div>
    <!-- Footer Links Ends -->
    @if(isset($template['bottom']) && $template['bottom'] !== null)
        @foreach($template['bottom'] as $module)
            @if(count($module) > 0)
                @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
            @endif
        @endforeach
    @endif
</footer>