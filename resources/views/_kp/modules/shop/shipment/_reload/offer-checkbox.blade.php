@if(isset($ajax->offer) && count($ajax->offer) > 0 && $ajax->offer !== null)
    <div class="row p-2 border-bottom">

        <div class="col-1">
            <img src="{{ '/storage/img/elements/delivery/' . $ajax['alias'] . '/' . $ajax['alias'] .'_logo.jpg' }}" class="img-fluid">
        </div>

        <div class="col-5">
            <div class="custom-control custom-radio">
                <input
                        id="shipment_{{$ajax['alias'] }}_{{$ajax->offer['type']}}"
                        class="custom-control-input"
                        name="shipment_id"
                        value="{{$ajax['id']}}"
                        type="radio"
                        required="">

                <label
                        for="shipment_{{$ajax['alias'] }}_{{$ajax->offer['type']}}"
                        class="custom-control-label">
                    {{$ajax['name']}}
                </label>
            </div>
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