@extends("layout")
@section("content")
    <div class="title m-b-md">
        <i class="fa fa-github"></i> GitHub Repo Analizer
        <form action="{{ url("/analyze") }}" method="POST" id="form">
            <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text">https://github.com/</span>
                </div>
                {{ csrf_field() }}
                <input type="text" class="form-control" name="repo" id="repo" aria-label="Large" placeholder="octocat/Hello-World" value="{{ old("repo") }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="check">Check</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        var repo = $('#repo');

        function check_repo() {
            $.get("https://api.github.com/repos/" + repo.val(), function(){
                $("#form").submit();
            });
        }

        $('#check').click(function (e) {
            e.preventDefault();
            check_repo();
        });
    </script>
@endsection