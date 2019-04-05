<header id="header-area">
    <!-- Header Top Starts -->
    <div class="header-top">
        <!-- Nested Container Starts -->
        <div class="container clearfix text-center text-sm-left">
            <!-- Top Links Starts -->
            <ul class="list-unstyled list-inline header-links mb-0 float-sm-left">
                <li class="list-inline-item"><a href="index.blade.php"><i class="fa fa-home d-block d-lg-none" title="Home"></i><span class="d-none d-lg-block">Home</span></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-heart d-block d-lg-none" title="Wish List(0)"></i><span class="d-none d-lg-block">Wish List(0)</span></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-user d-block d-lg-none" title="My Account"></i><span class="d-none d-lg-block">My Account</span></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-shopping-cart d-block d-lg-none" title="Shopping Cart"></i><span class="d-none d-lg-block">Shopping Cart</span></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-crosshairs d-block d-lg-none" title="Checkout"></i><span class="d-none d-lg-block">Checkout</span></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-unlock d-block d-lg-none" title="Register"></i><span class="d-none d-lg-block">Register</span></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-lock d-block d-lg-none" title="Login"></i><span class="d-none d-lg-block">Login</span></a></li>
            </ul>
            <!-- Top Links Ends -->
            <!-- Currency & Languages Starts -->
            <div class="float-sm-right">
                <!-- Currency Starts -->
                <div class="btn-group">
                    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown">Currency</button>
                    <ul class="dropdown-menu dropdown-menu-right rounded-0">
                        <a href="#" class="dropdown-item">Pound</a>
                        <a href="#" class="dropdown-item">US Dollar</a>
                        <a href="#" class="dropdown-item">Euro</a>
                    </ul>
                </div>
                <!-- Currency Ends -->
                <!-- Languages Starts -->
                <div class="btn-group">
                    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown">Language</button>
                    <ul class="dropdown-menu dropdown-menu-right rounded-0">
                        <a href="#" class="dropdown-item">English</a>
                        <a href="#" class="dropdown-item">French</a>
                    </ul>
                </div>
                <!-- Languages Ends -->
            </div>
            <!-- Currency & Languages Ends -->
        </div>
        <!-- Nested Container Ends -->
    </div>
    <!-- Header Top Ends -->
    <!-- Main Header Starts -->
    <div class="main-header">
        <!-- Nested Container Starts -->
        <div class="container">
            <!-- Nested Row Starts -->
            <div class="row">
                <!-- Search Starts -->
                <div class="col-xl-3 col-md-4 col-sm-12">
                    <div id="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
									<button class="btn" type="button">
										<i class="fa fa-search"></i>
									</button>
								  </span>
                        </div>
                    </div>
                </div>
                <!-- Search Ends -->
                <!-- Logo Starts -->
                <div class="col-xl-6 col-md-4 col-sm-12 text-center">
                    <div id="logo"><a href="index.blade.php"><img src="{{URL::asset('storage/images/logo.png')}}" title="Electro Shoppe" alt="Electro Shoppe" class="img-fluid" /></a></div>
                </div>
                <!-- Logo Starts -->
                <!-- Shopping Cart Starts -->
                <div class="col-xl-3 col-md-4 col-sm-12">
                    @include( $global_data['project_data']['template_name'] .'.modules.shop_basket.default')
                </div>
                <!-- Shopping Cart Ends -->
            </div>
            <!-- Nested Row Ends -->
        </div>
        <!-- Nested Container Ends -->
    </div>
    <!-- Main Header Ends -->
    <!-- Main Menu Starts -->
    <nav id="main-menu" class=" navbar navbar-expand-md rounded-0">
        <!-- Nested Container Starts -->
        <div class="container">
            @if(isset($menus['top_menu']) && $menus['top_menu'] !== null)
                @include( $global_data['project_data']['template_name'] .'.modules.menu.navbar', ['menu' => $menus['top_menu']])
            @endif
        </div>
        <!-- Nested Container Ends -->
    </nav>
    <!-- Main Menu Ends -->
</header>