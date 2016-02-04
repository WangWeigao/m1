@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="" action="/getorders" method="post">
            {!! csrf_field() !!}
            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' class="form-control" name="from_time" id="from_time"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' class="form-control" name="to_time" id="to_time"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" name="button" class="btn btn-info" id="search">查询</button>
                </div>
            </div>
        </form>
    </div>
@yield('orderList')
@endsection
