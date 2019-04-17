<!-- Main Header Starts -->
<div class="main-header">
    <!-- Nested Container Starts -->
    <div class="container">
        <!-- Nested Row Starts -->
        <div class="row">
            @include('_raduga.modules.search.index', ['module' => ['module'=>'search', 'template'=>'default' ]])
            <!-- Logo Starts -->
            <div class="col-xl-6 col-md-4 col-sm-12 text-center">
                <div id="logo"><a href="{{route('home')}}"><span class="display-4">RADUGA31.RU</span></a></div>
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