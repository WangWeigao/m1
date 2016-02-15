@extends('layouts.app')
@section('content')
    <div class="container">
        <form class="" action="/music/store" method="post">
            {!! csrf_field() !!}
            <fieldset>
                <legend>导入CVS文件</legend>
                <div class="form-group">
                    <input type="file" name="cvs" value="" class="form-control">

                </div>
                <button type="submit" name="button">导入</button>
            </fieldset>
        </form>

    </div>

@endsection
