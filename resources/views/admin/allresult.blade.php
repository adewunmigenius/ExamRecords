@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="myresult">
            <div id="showprogress"></div>

            @if(count($results))<button class="btn btn-primary btn-sm float-right" onclick="download_csv()">Export as CSV</button>@endif
            <div>
                <a class="btn btn-primary btn-sm" href="{{route('admin.home')}}"><i class="fas fa-arrow-alt-circle-left"></i> Admin's Dashboard</a>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-8 offset-md-2">
                <canvas class="allchart" id="myChart" style="max-height:450px" height="250"></canvas>
            </div>

            <hr>

            <div class="col-md-10 offset-md-1">
                <h5 class="m-4">All Results</h5>
                @if(count($results))
                    <div class="bal_table">
                        <table class="table table-striped table-sort">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Score</th>
                                <th>Result (%)</th>
                                <th>Grade</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($results as $score)
                                <tr>
                                    <td>{{ date('l\, jS \of F Y, h:i A', strtotime($score->created_at)) }}</td>
                                    <td>{{$score->user->name}}</td>
                                    <td>{{$score->user->email}}</td>
                                    <td>{{$score->correct_questions." / ".$score->total_questions}}</td>
                                    <td>{{ round(($score->correct_questions/$score->total_questions)*100) }}</td>
                                    <td><?php echo round(($score->correct_questions/$score->total_questions)*100) > 50 ? "<btn class=\"btn btn-sm btn-success\">passed</button>" : "<btn class=\"btn btn-sm btn-danger\">failed</button>"?></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No results record found</p>
                @endif
            </div>
        </div>

    </div>

    <script>
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


        // to download csv file
        var data = <?php echo $results_csv; ?>

        function download_csv() {
            console.log('Dowloading.....');
            document.getElementById('showprogress').innerText = 'Dowloading in progress.....'

            var csv = 's/n,Date,Name,Email,Score,Total,Result (%),Grade\n';
            data.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
            });

            console.log(csv);
            var disdate = new Date()
            var dhour = disdate.getHours()
            var chour = dhour > 12 ? dhour - 12 : dhour
            var zonin = dhour > 12 ? 'PM' : 'AM';
            var dfilename = 'results_'+disdate.getFullYear()+'-'+disdate.getMonth()+'-'+disdate.getDay()+'_'+chour+'.'+disdate.getMinutes()+'.'+disdate.getSeconds()+zonin+'.csv'
            var hiddenElement = document.createElement('a');
            hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
            hiddenElement.target = '_blank';
            hiddenElement.download = dfilename;
            hiddenElement.click();

            console.log('Download completed');

            setTimeout(function(){
                document.getElementById('showprogress').innerText = 'Downloading completed'
            },1100);

            setTimeout(function(){
                document.getElementById('showprogress').innerText = 'Downloaded '+dfilename
            },1300);
        }

    </script>
@endsection