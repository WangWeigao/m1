@extends('layouts.app')

@section('content')
    <div class="container">
        <div class='col-md-5'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker6'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class='col-md-5'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker7'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css">
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js" charset="utf-8"></script>
<script src="{{ url('js/order.js') }}" charset="utf-8"></script>
@endsection
