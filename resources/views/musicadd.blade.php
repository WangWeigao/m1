@extends('layouts.app')
@section('content')
    <div class="container">
        <form class="" action="/music" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <fieldset>
                <legend>导入CVS文件<a href="/files/import.csv"><small>(下载模板)</small></a></legend>
                <div class="form-group">
                    <input type="file" name="csv" class="form-control">

                </div>
                <button type="submit" name="button">导入</button>
            </fieldset>
        </form>

    </div>

@endsection
