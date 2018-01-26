@extends("layout")
@section("content")
    <div class="title m-b-md">
        <i class="fa fa-github"></i> GitHub Repo Analizer
    </div>
    <div class="row m-b-md">
        <div class="col-lg-3 col-md-6 col-xs-12 text-center">
            <a href="{{ url($result['owner']['html_url']) }}" alt="{{ url($result['owner']['login']) }}">
                <img src="{{ asset($result['owner']['avatar_url']) }}" alt="{{ asset($result['owner']['login']) }}" class="img-thumbnail">
            </a>
        </div>
        <div class="col-lg-9 col-md-6 col-xs-12 text-left">
            <h1>
                <a href="{{ url($result['html_url']) }}" class="text-secondary">
                    {{ $result['full_name'] }} <i class="fa fa-external-link"></i>
                </a>
            </h1>
            <h1 class="display-3 text-{{ $color }}">{{ $score }} %</h1>
            <div class="progress" style="height: 1px;">
                <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $score }}%;" aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
@endsection