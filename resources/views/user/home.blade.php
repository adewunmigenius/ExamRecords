@extends('layouts.app')

@section('content')
<div class="container">
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">User Dashboard</div>--}}

                {{--<div class="card-body">--}}
                    {{--@if (session('status'))--}}
                        {{--<div class="alert alert-success" role="alert">--}}
                            {{--{{ session('status') }}--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    {{--You are logged in!--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h4 class="text-center">Take test and get immediate result</h4>

            @if(count($exams))
            <form method="POST" action="{{ route('user.submit') }}">
                {{ csrf_field() }}
            <ul class="list-group m-4">
                @foreach($exams as $exam)
                <li class="list-group-item">
                    <h5 class="">{{$exam->question}}</h5>

                    <div class="form-group ans-form">
                        <label class=""> <input class="" type="radio" name="q{{$exam->id}}" value="{{strcmp($exam->answer,$exam->op_one) == 0 ? 1 : 0}}" required>
                            {{$exam->op_one}}</label>
                        <label class=""> <input class="" type="radio" name="q{{$exam->id}}" value="{{strcmp($exam->answer,$exam->op_two) == 0 ? 1 : 0}}" required>
                            {{$exam->op_two}}</label>
                        <label class=""> <input class="" type="radio" name="q{{$exam->id}}" value="{{strcmp($exam->answer,$exam->op_three) == 0 ? 1 : 0}}" required>
                            {{$exam->op_three}}</label>
                        @if($exam->op_four)
                        <label class=""> <input class="" type="radio" name="q{{$exam->id}}" value="{{strcmp($exam->answer,$exam->op_four) == 0 ? 1 : 0}}" required>
                            {{$exam->op_four}}</label>
                        @endif
                        @if($exam->op_five)
                        <label class=""> <input class="" type="radio" name="q{{$exam->id}}" value="{{strcmp($exam->answer,$exam->op_five) == 0 ? 1 : 0}}" required>
                            {{$exam->op_five}}</label>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>

                <div class="text-center">
                    {!! $exams->render() !!}
                    <button type="submit" id="submit_ans" class="m-2 btn btn-success">Submit</button>
                </div>

            </form>
            @else
                <p>No questions found</p>
            @endif
        </div>
    </div>
</div>
@endsection
