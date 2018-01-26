@extends("layout")
@section("content")
    <div class="title-sub m-b-md">
        <ul class="list-group list-group-flush text-left">
            @foreach($config as $key => $item)
                <li class="list-group-item text-capitalize">
                    {{ $key }} <span class="text-info">{{ $item }}%</span>
                </li>
            @endforeach
            <li class="list-group-item">
                Total <span class="text-{{ $color }}">{{ $total }}%</span>
            </li>
        </ul>
        <code>
            <small>Last update is acceptable until <strong>{{ config("project.update.deadline") }} {{ str_plural(title_case(config("project.update.unit")), config("project.update.deadline")) }}</strong> ago.</small>
        </code>
    </div>
@endsection