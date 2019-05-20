@php
    $page = $modules[$module['resource']];
@endphp
    <div class="p-3 shadow rounded">
        <h2 class=" rounded text-center" style="background: #4bac52; color: white;">
            {{$page->name}}
        </h2>
        {!! $page->description !!}
    </div>