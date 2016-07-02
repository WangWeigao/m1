<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TrainingTeacher;
use App\TrainingInstitution;

class TeacherInvitationController extends Controller
{
    /**
     * 获取搜索结果
     * @method getRsearchResult
     * @param  Request          $request [description]
     * @return [type]                    [description]
     */
    public function getRsearchResult(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $province = $request->get('province', '');
        $teacher = $request->get('teacher', '');

        $result = TrainingTeacher::select('id', 'name', 'cell_phone', 'email', 'invite_code', 'payment_account', 'invite_code_status');

        if (!empty($keyword)) {
            $result->where('name', 'like', "%$keyword%")
            ->orWhere('subbranch', 'like', "%$keyword%");
        }
        if (!empty($province)) {
            $result->where('province', $province);
        }
        if (!empty($teacher)) {
            $result->where('name', $teacher);
        }
        $result = $result->paginate(15)->appends([
                                                'keyword' => $keyword,
                                                'province' => $province,
                                                'teacher' => $teacher
                                            ]);
        return view('teach_invite_codes')->with(['result' => $result])->withInput($request->all());
    }

    /**
     * 添加教师
     * @method postTeacher
     * @param  Request         $request [description]
     * @return [type]                   [description]
     */
    public function postTeacher(Request $request)
    {
        $teacher                  = new TrainingTeacher();
        $teacher->name            = $request->get('teacher_name', '');
        $teacher->cell_phone      = $request->get('cell_phone', '');
        $teacher->email           = $request->get('email', '');
        $teacher->invite_code     = $request->get('invite_code', '');
        $teacher->bank_name       = $request->get('bank_name', '');
        $teacher->payment_account = $request->get('payment_account', '');
        if ($teacher->save()) {
            return redirect($_SERVER['HTTP_REFERER'])->withInput($request->all());
        }
    }


    /**
     * 批量更新激活码状态为"已发行"
     * @method updateInvitecodeStatus
     * @param  Reqeust                $request [description]
     * @return [type]                          [description]
     */
    public function updateInvitecodeStatus(Request $request)
    {
        $ids = $request->get('ids', []);
        $data['status'] = 0;
        foreach ($ids as $id) {
            $ins = TrainingTeacher::find($id);
            $ins->invite_code_status = 1;
            $result = $ins->save();
            if (!$result) {
                $data['status'] = 1;
                $data['msg'] = '更新失败';
            }
        }
        return $data;
    }


    /**
     * 更新单个机构的邀请码状态为"已发行"
     * @method updateOneInviteCodeStatus
     * @param  TrainingTeacher       $id [description]
     * @return [type]                        [description]
     */
    public function updateOneInviteCodeStatus(TrainingTeacher $id)
    {
        $id->invite_code_status = 1;
        if (!$id->save()) {
            $data['status'] = 10000;
            $data['msg'] = '操作失败';
        }else {
            $data['status'] = 0;
        }
        return $data;
    }


    /**
     * 获取单个机构的信息
     * @method getInsInfo
     * @param  TrainingTeacher $id [description]
     * @return [type]                  [description]
     */
    public function getInsInfo(TrainingTeacher $id)
    {
        $result['data']['id']         = $id->id;
        $result['data']['name']       = $id->name;
        $result['data']['cell_phone'] = $id->cell_phone;
        $result['data']['address']    = $id->address;
        $result['data']['email']      = $id->email;
        $result['status']             = 0;
        return $result;
    }


    /**
     * 更新单个机构的信息
     * @method updateInsInfo
     * @param  TrainingTeacher $id [description]
     * @return [type]                  [description]
     */
    public function updateInsInfo(TrainingTeacher $id, Request $request)
    {
        $id->name       = $request->teacher_name;
        $id->cell_phone = $request->cell_phone;
        $id->email      = $request->email;
        $id->save();
        return redirect($_SERVER['HTTP_REFERER']);
    }
}
