@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h3 class="text-center">Admin's Dashboard</h3>
            @if(count($results))<a class="btn btn-primary btn-sm" href="{{route('admin.allresults')}}"><i class="fas fa-arrow-alt-circle-right"></i> All results</a>@endif
            <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#examQuestion">Create +</button>

            <div class="clearfix"></div>
            <hr>

            <div>
                {{--@if(count($exams))<button class="btn btn-primary btn-sm float-right">Export as CSV</button>@endif--}}
                <h3>Exams Questions<small class="btn btn-success">{{count($exams)}}</small></h3>
                @if(count($exams))
                    <div class="bal_table">
                    <table class="table table-striped table-sort">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>Date</th>
                            <th>Question</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>E</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $dsn = 0;?>
                        @foreach ($exams as $exam)
                            <tr>
                                <td>{{$dsn+=1}}</td>
                                <td>{{ date('l\, jS \of F Y, h:i A', strtotime($exam->created_at)) }}</td>
                                <td>{{ $exam->question }}</td>
                                <td>{{ $exam->op_one }}</td>
                                <td>{{ $exam->op_two }}</td>
                                <td>{{ $exam->op_three }}</td>
                                <td>{{ $exam->op_four ? $exam->op_four : '--'}}</td>
                                <td>{{ $exam->op_five ? $exam->op_five : '--'}}</td>
                                <td>{{ $exam->answer }}</td>
                                <td>
                                    <form method="POST" action="{{ url('admin/exam/delete/'.$exam->id) }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="text-center">
                        {!! $exams->render() !!}
                    </div>
                @else
                    <p class="text-center">No exams record found</p>
                @endif
            </div>

            <div class="modal fade" id="examQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Question</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form id="quest_form" method="POST" action="{{ route('admin.setexam') }}">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    {{--<span id="question">1</span>--}}
                                    <label for="message-text" class="col-form-label">Question :</label>
                                    <textarea class="form-control{{ $errors->has('question') ? ' is-invalid' : '' }}" name="question" required></textarea>
                                    @if ($errors->has('question'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('question') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div id="quest_option">
                                    <div class="form-group">
                                        <label for="1op" class="col-form-label">Option 1:</label>
                                        <input type="text" class="form-control" name="op_one" id="1op" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="2op" class="col-form-label">Option 2:</label>
                                        <input type="text" class="form-control" name="op_two" id="2op" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="3op" class="col-form-label">Option <span id="label_val">3</span>:</label>
                                        <input type="text" class="form-control" name="op_three" id="3op" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-form-label">Correct Answer:</label>
                                    <div id="quest_answer">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="answer" id="answer_1" value="op_one" required>
                                            <label class="form-check-label" for="answer_1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="answer" id="answer_2" value="op_two" required>
                                            <label class="form-check-label" for="answer_2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="answer" id="answer_3" value="op_three" required>
                                            <label class="form-check-label" for="answer_3">3</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-sm btn-primary" id="add_option">Add Option</button>
                                <button type="button" class="btn btn-sm btn-danger" id="remove_option">Remove Option</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Question</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
