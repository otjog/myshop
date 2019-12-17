<div class="row p-2 border-bottom">
    <div class="col-2">
        @php
            if (isset($service->images) && count($service->images) > 0)
                $imageSrc = $service->images[0]->src;
            else
                $imageSrc = 'noimage';
        @endphp
        <img
                class="img-fluid"
                src="{{route('getImage', ['default', 'xxs', $imageSrc, $service->id])}}"
                alt="{{$service->images->alt or $service->name}}"
        />
    </div>

    <div class="col-3">
        <div class="custom-control custom-radio">
            <input
                    id="shipment_{{$service->id}}"
                    class="custom-control-input"
                    name="shipment_id"
                    value="{{$service->id}}_{{$service->descripton}}"
                    type="radio"
                    required="">

            <label
                    for="shipment_{{$service->id}}"
                    class="custom-control-label">
                {{$service->name}}
            </label>
        </div>
    </div>

    <div class="col">
        <div class="blur">

            <div class="px-2">
                <span class="shipment-days">{{$service->description}}</span>
            </div>

        </div>

    </div>

</div>