@if(isset($ajax->offer) && count($ajax->offer) > 0 && $ajax->offer !== null)
    <div class="row p-2 border-bottom">
        <div class="col-2">
            <img src="{{ '/storage/img/elements/delivery/' . $ajax['alias'] . '/' . $ajax['alias'] .'_logo.jpg' }}" class="img-fluid" alt="{{$ajax->name}}">
        </div>

        <div class="col">
            <div class="blur">

                <div class="row">
                    <div class="col text-center">
                        <span class="shipment-price">{{$ajax->offer['price']}}</span> {{$global_data['components']['shop']['currency']['symbol']}}
                    </div>
                    <div class="col text-center">
                        <span class="shipment-days">{{$ajax->offer['days']}}</span> {{$ajax->offer['declision']}}
                    </div>
                </div>

            </div>

        </div>

    </div>
@endif