@if(isset($global_data['ajax']->offer) && count($global_data['ajax']->offer) > 0 && $global_data['ajax']->offer !== null)
    <div class="row p-2 border-bottom">

        <div class="col-2">
            @php
                if (count($global_data['ajax']->images) > 0)
                    $imageSrc = $global_data['ajax']->images[0]->src;
                else
                    $imageSrc = 'noimage';
            @endphp
            <img
                    class="img-fluid"
                    src="{{route('getImage', ['default', 'xxs', $imageSrc, $global_data['ajax']->id])}}"
                    alt="{{$global_data['ajax']->images[0]->alt or $global_data['ajax']->name}}"
            />
        </div>

        <div class="col-5">
            <div class="custom-control custom-radio">
                <input
                        id="shipment_{{$global_data['ajax']['alias'] }}_{{$global_data['ajax']->offer['type']}}"
                        class="custom-control-input"
                        name="shipment_id"
                        value="{{$global_data['ajax']['id']}}_{{$global_data['ajax']->offer['type']}}_{{$global_data['ajax']->offer['price']}}_{{$global_data['ajax']->offer['days']}}"
                        type="radio"
                        required="">

                <label
                        for="shipment_{{$global_data['ajax']['alias'] }}_{{$global_data['ajax']->offer['type']}}"
                        class="custom-control-label">
                    {{$global_data['ajax']['name']}}
                </label>
            </div>
        </div>

        <div class="col">
            <div class="blur">

                <div class="row">
                    <div class="col text-center">
                        <span class="shipment-price">{{$global_data['ajax']->offer['price']}}</span> {{$global_data['components']['shop']['currency']['symbol']}}
                    </div>
                    <div class="col text-center">
                        <span class="shipment-days">{{$global_data['ajax']->offer['days']}}</span> {{$global_data['ajax']->offer['declision']}}
                    </div>
                </div>

            </div>

        </div>

    </div>
@endif