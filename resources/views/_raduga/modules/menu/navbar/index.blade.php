<!-- Main Menu Starts -->
<nav id="main-menu" class=" navbar navbar-expand-md rounded-0">
    <!-- Nested Container Starts -->
    <div class="container">
        @if(isset($menus[$menu_alias]) && $menus[$menu_alias] !== null)
            <!-- Navbar Toggler Starts -->
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target=".navbar-cat-collapse" aria-controls=".navbar-cat-collapse" aria-expanded="false" aria-badge="Toggle navigation">
                <span class="navbar-toggler-icon fa fa-bars"></span>
            </button>
            <!-- Navbar Toggler Ends -->
            <!-- Navbar Cat collapse Starts -->
            <div class="collapse navbar-collapse navbar-cat-collapse">
                <ul class="nav navbar-nav">
                    @if(isset($menus[$menu_alias]->models) && $menus[$menu_alias]->models !== null)
                        @foreach($menus[$menu_alias]->models as $menu_model)
                            @include('_raduga.modules.menu.navbar.elements.' . $menu_model->view)
                        @endforeach
                    @endif
                </ul>

            </div>
            <!-- Navbar Cat collapse Ends -->
        @endif
    </div>
    <!-- Nested Container Ends -->
</nav>
<!-- Main Menu Ends -->