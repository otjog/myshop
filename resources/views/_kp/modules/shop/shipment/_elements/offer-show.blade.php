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

    <div class="col">
        <div class="blur">
            <div class="d-flex flex-row">
                <div class="px-2">
                    <span class="shipment-price">{{$service->name}}</span>
                </div>
                <div class="px-2">
                    <span class="shipment-days">{{$service->description}}</span>
                </div>
            </div>
        </div>

    </div>

</div>