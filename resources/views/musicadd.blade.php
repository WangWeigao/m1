@extends('layouts.app')
@section('content')
    <div class="container">
        <form class="" action="/music/storecsv" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <fieldset>
                <legend>导入CSV文件<a href="/files/import.csv"><small>(下载模板)</small></a></legend>
                <div class="form-group">
                    <input type="file" name="csv" class="form-control">

                </div>
                <button type="submit" name="button">导入</button>
            </fieldset>
        </form>
        {{-- 批量上传midi文件和属性 --}}
        <div id="fileuploader">Upload</div>

    </div>

@endsection

@section('css')
    <link href="http://hayageek.github.io/jQuery-Upload-File/4.0.10/uploadfile.css" rel="stylesheet">
@endsection

@section('js')
    <script src="http://hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js"></script>
    <script src="{{ elixir('js/musicadd.js') }}"></script>
@endsection
