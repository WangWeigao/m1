<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lesson;

class ReleaseAccreditController extends Controller
{
    /**
     * 取得未审批的所有课程
     * @method lessons
     * @return Array(json)  所有未审批的课程
     */
    public function lessons()
    {
        /**
        * 取得所有未审批的课程
        * 现在表中默认值为1, 建议设置为null
        * 便于审批后, 1 同意, 0 否决
        * 暂时设定为0, 便于测试
        */
        $lessons = Lesson::where('valid', 0)->get();

        return $lessons;
    }


    /**
     * 进行审批
     * @method permit
     * @return boolean  操作是否成功
     */
    public function accredit(Request $request, $id)
    {
        /**
         * 是否同意
         * 1 同意, 0 否决
         */
        $agree = $request->get('agree');

        //更新课程状态
        $result = Lesson::where('lid', $id)->update(['valid' => $agree]);

        // 返回审批是否成功
        return $result;
    }
}
