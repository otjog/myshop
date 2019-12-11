<select multiple
        class="form-control"
        name="{{$filter['alias']}}[0]"
        data-filter-type="{{$filter['type']}}"
>
    @foreach($filter['values'] as $id =>$value)

        <option
                value="{{$value}}"
            @php
                if(isset($filter['old_values']) && in_array($id, $filter['old_values']))
                    echo 'selected';
            @endphp
            >
            {{$value}}
            </option>
    @endforeach

</select>