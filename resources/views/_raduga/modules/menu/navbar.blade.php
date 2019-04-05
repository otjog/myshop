<!-- Navbar Toggler Starts -->
<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target=".navbar-cat-collapse" aria-controls=".navbar-cat-collapse" aria-expanded="false" aria-badge="Toggle navigation">
    <span class="navbar-toggler-icon fa fa-bars"></span>
</button>
<!-- Navbar Toggler Ends -->
<!-- Navbar Cat collapse Starts -->
<div class="collapse navbar-collapse navbar-cat-collapse">
    <ul class="nav navbar-nav">
        @if(isset($menu->models) && $menu->models !== null)
            @foreach($menu->models as $model)
                @include( $global_data['project_data']['template_name'] .'.modules.menu.elements.' . $model->view)
            @endforeach
        @endif
    </ul>

</div>
<!-- Navbar Cat collapse Ends -->
