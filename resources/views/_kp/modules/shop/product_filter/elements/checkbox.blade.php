<div class="row">
    @php $i = 0; @endphp
    @foreach($filter['values'] as $id =>$value)
        <div class="col-6">
            <label class="small">
                <input
                        type="checkbox"
                        name="{{$filter['alias']}}[{{$i}}]"
                        value="{{$id}}"
                        data-filter-type="{{$filter['type']}}"
                        @php
                            if(isset($filter['old_values']) && in_array($id, $filter['old_values']))
                                echo 'checked';
                        @endphp
                />
                {{$value}}
            </label>
        </div>
        @php $i++; @endphp
    @endforeach
</div>