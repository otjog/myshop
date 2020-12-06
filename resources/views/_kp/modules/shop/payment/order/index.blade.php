<div class="col-lg-12">

    @if(isset($payments) && count($payments) > 0 && $payments !== null)

        <h4 class="mb-3">Способ оплаты</h4>

        <div class="my-4">

            @foreach($payments as $service)
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
                                src="{{route('getImage', ['default', 's', $imageSrc, $service->id])}}"
                                alt="{{$service->images[0]->alt or $service->name}}"
                        />
                    </div>

                    <div class="col-4">
                        <div class="custom-control custom-radio">
                            <input id="payment_{{ $service->id }}" name="payment_id" value="{{ $service->id }}" type="radio" class="custom-control-input" >
                            <label class="custom-control-label" for="payment_{{ $service->id }}">{{ $service->name }}</label>
                        </div>
                    </div>

                    <div class="col">

                        @if($service->tax !== 0)
                            <span class="@if($service->tax < 0 ) text-success @else text-danger @endif">
                                @if($service->tax < 0 ) Дополнительная скидка: @else Комиссия: @endif

                                <strong>
                                    @if($service->tax_type === 'percent')
                                        {{round($global_data['shop']['basket']['total'] * $service->tax/100*-1, 0)}}
                                    @else
                                        {{ $service->tax }}
                                    @endif
                                    {{$global_data['components']['shop']['currency']['symbol']}}
                                </strong>

                            </span>
                            <br>
                        @endif

                        <span class="text-muted">
                            {{ $service->description }}
                        </span>
                    </div>

                </div>
            @endforeach
        </div>

    @endif

</div>