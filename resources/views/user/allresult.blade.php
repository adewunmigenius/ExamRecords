@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="prog_head">Track your progress with your results overtime</h3>
        <div class="row myresult">
            <div class="col-md-6" style="border-right:1px solid #ccc">
                <h5>Results</h5>
                @if(count($results))
                    <div class="bal_table">
                        <table class="table table-striped table-sort">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Score</th>
                                <th>Result (%)</th>
                                <th>Grade</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($results as $score)
                                <tr>
                                    <td>{{ date('l\, jS \of F Y, h:i A', strtotime($score->created_at)) }}</td>
                                    <td>{{$score->correct_questions." / ".$score->total_questions}}</td>
                                    <td>{{ round(($score->correct_questions/$score->total_questions)*100) }}</td>
                                    <td><?php echo round(($score->correct_questions/$score->total_questions)*100) >= 50 ? "<btn class=\"btn btn-sm btn-success\">passed</button>" : "<btn class=\"btn btn-sm btn-danger\">failed</button>"?></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No results record found, please take test <a href="{{route('home')}}">here</a></p>
                @endif
            </div>
            <div class="col-md-6">
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