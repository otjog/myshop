<div id="main-container-home" class="container">

    @if(isset( $template['banner'] ))
        @include( $global_data['project_data']['template_name'] .'.modules.banner.default')
    @endif

    @if(isset( $template['component'] ))
        <div class="row">
            @if(isset($template['sidebar']))
                <div class="col-md-3 col-sm-12">
                    @include( $global_data['project_data']['template_name'] .'.modules.'.$template['sidebar'].'.default', $data)
                </div>
                @php $colMdComponent = '9'; @endphp
            @else
                @php $colMdComponent = '12'; @endphp
            @endif

            <div class="col-md-{{$colMdComponent}} col-sm-12">
                @include( $global_data['project_data']['template_name'] .'.components.'.$template['component'].'.'.$template['resource'].'.'.$template['view'], $data)
            </div>

        </div>
    @endif

    @if(isset( $template['modules'] ) && count( $template['modules'] ) > 0)
        @foreach($template['modules'] as $folder => $file)

            @include( $global_data['project_data']['template_name'] .'.modules.' . $folder . '.' . $file)

        @endforeach
    @endif
</div>

