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
                <div id="logo"><a href="{{route('home')}}"><img src="{{URL::asset('storage/images/logo.png')}}" title="Electro Shoppe" alt="Electro Shoppe" class="img-fluid" /></a></div>
            </div>
            <!-- Logo Starts -->
            <!-- Shopping Cart Starts -->
            <div class="col-xl-3 col-md-4 col-sm-12">
                @include( '_raduga.modules.shop_basket.index',  ['module' => ['module' => 'shop_basket','template' => 'default']])
            </div>
            <!-- Shopping Cart Ends -->
        </div>
        <!-- Nested Row Ends -->
    </div>
    <!-- Nested Container Ends -->
</div>
<!-- Main Header Ends -->