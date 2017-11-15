@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">HUHA</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role == 'admin')
                    <ul class="nav nav-pills">
                        <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
                        <li><a data-toggle="pill" href="#menu1">Visualisation</a></li>
                      </ul>
  
                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                          <form class="form-horizontal" action="{{ route('question.store') }}" method="POST">
                        {{ csrf_field() }}
                        <fieldset>

                        <!-- Form Name -->
                        <legend>Question Bank</legend>

                        <!-- Select Basic -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="category">Category</label>
                          <div class="col-md-4">
                            <select name="category" id="category" class="form-control">
                                @foreach($categories as $category)
                                 <option value="{{ $category->id }}">{{ $category->label}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="question">Question?</label>  
                          <div class="col-md-4">
                          <input id="question" name="question" type="text" placeholder="Question?" class="form-control input-md">  
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="extras">Extras</label>  
                          <div class="col-md-4">
                          <input id="extras" name="extras" type="text" placeholder="Extras" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-block">Add Quesiton</button>
                            </div>
                        </div>
                        </fieldset>
                        </form>
                        <div class="container">
                            <div class="row">
                                <h3>Question list</h3>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $key => $value)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$value->category->label }}</td>
                                    <td>{{$value->question }}</td>
                                    <td>{{$value->extras }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                          
                        </div>
                      </div>
                        

                    @else
                    {{-- if user --}}
                        <form class="form-horizontal" action="{{ route('answer.store') }}" method="POST">
                            {{ csrf_field() }}
                            <lagend> Questionaire</lagend>
                            {{-- {{dd($questions)}} --}}
                            @foreach($questions as $key => $value)
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="q{{$key}}">{{$value->question}}</label>  
                                    <div class="col-md-4">
                                        {{-- {{dd(json_decode($value->extras))}} --}}
                                        @if(json_decode($value->extras)->type == "checkbox")
                                            @foreach(json_decode($value->extras)->answers as $listkey => $listselection)
                                                <div class="checkbox">
                                                    <label for="q[{{$key}}][{{$listkey}}]">
                                                        <input type="checkbox" name="q[{{$key}}][{{$listkey}}]" id="q[{{$key}}][{{$listkey}}]" value="{{$listselection}}">
                                                        {{$listselection}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @elseif(json_decode($value->extras)->type == "select")
                                            <select id="q[{{$key}}]" name="q[{{$key}}]" class="form-control">
                                                @foreach(json_decode($value->extras)->answers as $listkey => $listselection)
                                                    <option value="{{$listselection}}">{{$listselection}}</option>
                                                @endforeach
                                            </select>
                                        @elseif(json_decode($value->extras)->type == "rating")
                                            @foreach(json_decode($value->extras)->answers as $listkey => $listselection)
                                                <label class="checkbox-inline" for="q[{{$key}}]">
                                                    <input type="checkbox" name="q[{{$key}}]" id="q[{{$key}}]" value="{{$listselection}}">
                                                    {{$listselection}}
                                                </label>
                                            @endforeach
                                        @elseif(json_decode($value->extras)->type == "paragraph")
                                            <textarea class="form-control" id="q[{{$key}}]" name="q[{{$key}}]">Jwab!!</textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">Submit Answer</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
