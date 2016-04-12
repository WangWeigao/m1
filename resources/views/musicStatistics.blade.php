@extends('layouts.app')

@section('content')
    <div class="breadcrumb">
        <li>曲库管理</li>
        <li class="active">曲库统计</li>
    </div>

    <div class="container" style="margin-left:20%; line-height:25px;">
        <p>
            库内所有乐曲总数：{{  $data['allCount'] }}首
        </p>
        <p>
            库内所有已上架的乐曲总数：{{  $data['onshelfCount'] }}首
        </p>
        <br/>
        <select class="" name="" id="stat_instrument">
            <option value="0">所有乐器</option>
        </select>
        <div class="stat_result_instrument">
            <p>
                列表内乐曲总数：<span>{{ $data['allCount'] }}</span> 首
            </p>
            <p>
                已上架总数：<span>{{ $data['onshelfCount'] }}</span>首
            </p>
            <p>
                待审核总数：<span>{{ $data['waitForCheck'] }}</span>首
            </p>
            <p>
                已删除总数：<span>{{ $data['deleteCount'] }}</span>首
            </p>
            <br/>

            <p style="font-weight: bold">
                业余考级乐曲情况：
            </p>
            <p>
                上架总数：<span>{{ $data['amateur_onshelfCount'] }}</span>首
            </p>
            <p>
                待审核总数：<span>{{ $data['amateur_waitForCheck'] }}</span>首
            </p>
            <p>
                已删除总数：<span>{{ $data['amateur_deleteCount'] }}</span>首
            </p>
            <br/>

            <p style="font-weight: bold">
                专业考级乐曲情况：
            </p>
            <p>
                上架总数：<span>{{ $data['pro_onshelfCount'] }}</span>首
            </p>
            <p>
                待审核总数：<span>{{ $data['pro_waitForCheck'] }}</span>首
            </p>
            <p>
                已删除总数：<span>{{ $data['pro_deleteCount'] }}</span>首
            </p>
            <br/>

            <p style="font-weight: bold">
                热门曲目情况：
            </p>
            <p>
                上架总数：<span>{{ $data['hot_onshelfCount'] }}</span>首
            </p>
            <p>
                待审核总数：<span>{{ $data['hot_waitForCheck'] }}</span>首
            </p>
            <p>
                已删除总数：<span>{{ $data['hot_deleteCount'] }}</span>首
            </p>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ elixir('js/musicStatistics.js') }}"></script>
@endsection
