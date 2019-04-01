@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row myresult">
            <div class="col-md-6" style="border-right:1px solid #ccc">
                <div class="text-center">
                    <p class="">current test result on: {{ date('l\, jS \of F Y, h:i A', strtotime($result->created_at)) }}</p>

                    <h4 class="m-4">{{$percentage > 50 ? 'CONGRATULATIONS' : 'UNFORTUNATELY'}}</h4>
                    <h2>{{$percentage}}%</h2>
                    <progress class="{{$percentage > 50 ? 'pr-green' : 'pr-red'}}" value="{{$result->correct_questions}}" max="{{$result->total_questions}}"></progress>
                    <h2><small>score</small> {{$result->correct_questions." / ".$result->total_questions}}</h2>
                </div>
            </div>
            <div class="col-md-6">
                {{--<div class="text-center">--}}
                    {{--<p id="restl">Results over time</p>--}}
                {{--</div>--}}

                <canvas id="myChart" width="300" height="300"></canvas>
            </div>
        </div>

    </div>

    <script>
        var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var config = {
            type: 'line',
            data: {
                labels: <?php echo $thedate; ?>,
                datasets: [{
                    label: 'results dataset',
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    data: <?php echo $plotscore; ?>,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Results over time'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value (%)'
                        }
                    }]
                }
            }
        };
        window.onload = function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            window.myLine = new Chart(ctx, config);
        };

    </script>
@endsection