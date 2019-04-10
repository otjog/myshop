@extends('_raduga.index')

@section('component')
    <!-- Product Info Starts -->
    <div class="row product-info full">
        <!-- Left Starts -->
        <div class="col-sm-6 images-block">

            <p>
                @if( isset($product->images[0]->name) && $product->images[0]->name !== null)
                    <a href="{{route('models.sizes.images.show', ['product', 'l', $product->images[0]->name])}}" title="">
                        <img
                                src="{{route('models.sizes.images.show', ['product', 'm', $product->images[0]->name])}}"
                                alt=""
                        />
                    </a>
                @else
                    <img
                            src="{{route('models.sizes.images.show', ['product', 'm', 'no_image.jpg'])}}"
                            alt=""
                    />
                @endif
            </p>
            @if( isset( $product->images ) && count( $product->images ) > 1)
                <ul class="list-unstyled list-inline">
                    @foreach( $product->images as $image)
                        <li class="list-inline-item">
                            <a href="{{route('models.sizes.images.show', ['product', 'l', $image->name])}}">
                                <img src="{{route('models.sizes.images.show', ['product', 'xxs', $image->name])}}" alt="Image" class="img-fluid img-thumbnail rounded-0" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!-- Left Ends -->
        <!-- Right Starts -->
        <div class="col-sm-6 product-details">
            <div class="panel-smart">
                <!-- Product Name Starts -->
                <h2>
                    @isset($product->manufacturer['name'])
                        {{ $product->manufacturer['name'] . ' ' }}
                    @endisset

                    {{ $product->name }}


                </h2>
                <!-- Product Name Ends -->
                <hr />
                <!-- Manufacturer Starts -->
                <ul class="list-unstyled manufacturer">
                    @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)

                        @foreach($product->brands as $brand)
                            <li>
                                <span>Brand:</span> {{$brand->name}}
                            </li>
                        @endforeach

                    @endif

                    <li><span>Артикул:</span>{{$product->scu}}</li>
                </ul>
                <!-- Manufacturer Ends -->
                <hr />
            @if( isset($product->price['value']) && $product->price['value'] !== null)
                <!-- Price Starts -->
                    <div class="price">
                        <span class="price-head">Цена :</span>
                        <span class="price-new">{{ $product->price['value'] }}{{$global_data['project_data']['components']['shop']['currency']['symbol']}}</span>
                        @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                            <span class="price-old">{{$product->price['value'] + $product->price['sale']}}{{$global_data['project_data']['components']['shop']['currency']['symbol']}}</span>
                        @endif
                    </div>
                <!-- Price Ends -->
                <div class="my-4">
                    <form id="buy-form" method="post" role="form" action="{{route('baskets.store')}}">
                        <div class="row mx-0">
                            <div class="product_quantity col-3">
                                <span>Кол-во: </span>
                                <input type="text"      name="quantity"     value="1" size="5" pattern="[0-9]*" class="quantity_input">
                                <input type="hidden"    name="product_id"   value="{{$product->id}}">
                                <input type="hidden"    name="_token"       value="{{csrf_token()}}">
                                <div class="quantity_buttons">
                                    <div
                                            class="quantity_inc quantity_control"
                                    >
                                        <i class="fas fa-chevron-up"></i>
                                    </div>
                                    <div
                                            class="quantity_dec quantity_control"
                                            data-quantity-min-value="1"
                                    >
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-button button-group col-3">
                                <button type="submit" class="btn btn-cart">
                                    В корзину
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
            </div>
        </div>
        <!-- Right Ends -->
    </div>
    <!-- Product Info Ends -->
    <!-- Tabs Starts -->
    <div class="tabs-panel panel-smart">
        <!-- Nav Tabs Starts -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#tab-description" class="nav-link active">Описание</a>
            </li>
            <li class="nav-item"><a href="#tab-review" class="nav-link">Отзывы</a></li>
        </ul>
        <!-- Nav Tabs Ends -->
        <!-- Tab Content Starts -->
        <div class="tab-content clearfix">
            <!-- Description Starts -->
            <div class="tab-pane active" id="tab-description">
                @if(isset( $product->description ))
                    <p>{{ $product->description }}</p>
                @endif
            </div>
            <!-- Description Ends -->
            <!-- Review Starts -->
            <div class="tab-pane" id="tab-review">
                <form>
                    <div class="form-group required row">
                        <label class="col-sm-2 col-form-label text-right" for="input-name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="" id="input-name" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required row">
                        <label class="col-sm-2 col-form-label text-right" for="input-review">Review</label>
                        <div class="col-sm-10">
                            <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                            <div class="help-block">
                                Some note goes here..
                            </div>
                        </div>
                    </div>
                    <div class="form-group required row">
                        <label class="col-sm-2 col-form-label text-right ratings">Ratings</label>
                        <div class="col-sm-10">
                            Bad&nbsp;
                            <input type="radio" name="rating" value="1" />
                            &nbsp;
                            <input type="radio" name="rating" value="2" />
                            &nbsp;
                            <input type="radio" name="rating" value="3" />
                            &nbsp;
                            <input type="radio" name="rating" value="4" />
                            &nbsp;
                            <input type="radio" name="rating" value="5" />
                            &nbsp;Good
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="button" id="button-review" class="btn btn-main">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Review Ends -->
        </div>
        <!-- Tab Content Ends -->
    </div>
    <!-- Tabs Ends -->
@endsection