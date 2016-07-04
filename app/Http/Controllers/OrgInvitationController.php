<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TrainingInstitution;
use App\TrainingTeacher;

class OrgInvitationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $institutions = self::getInstitutionsName();
        return view('org_invite_codes')->with(['result' => [], 'institutions' => $institutions]);
    }


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
        $institution = $request->get('institution', '');
        $institutions = self::getInstitutionsName();

        $result = TrainingInstitution::select('id', 'name', 'subbranch', 'cell_phone', 'address', 'email', 'invite_code', 'payment_account', 'invite_code_status');

        if (!empty($keyword)) {
            $result->where('name', 'like', "%$keyword%")
            ->orWhere('subbranch', 'like', "%$keyword%");
        }
        if (!empty($province)) {
            $result->where('province', $province);
        }
        if (!empty($institution)) {
            $result->where('name', $institution);
        }
        $result = $result->paginate(15)->appends($request->all());
        return view('org_invite_codes')->with(['result' => $result, 'institutions' => $institutions])->withInput($request->all());
    }


    /**
     * 获取所有的机构名称
     * @method getInstitutionsName
     * @return [type]              [description]
     */
    private static function getInstitutionsName()
    {
        $names = TrainingInstitution::select('name')->distinct()->get();
        $data_arr = array();
        foreach ($names as $v) {
            $data_arr[] = $v->name;
        }
        return $data_arr;
    }

    /**
     * 获取邀请码
     * @method getInviteCode
     * @return [type]        [description]
     */
    public function getInviteCode()
    {
        // 获取邀请码
        $invite_code        = self::generateInviteCode();
        // 校验邀请码是否已被使用
        $org_invite_codes   = TrainingTeacher::select('invite_code')->get();
        $teach_invite_codes = TrainingInstitution::select('invite_code')->get();

        foreach ($org_invite_codes as $value) {
            $codes[] = $value->invite_code;
        }
        foreach ($teach_invite_codes as $value) {
            $codes[] = $value->invite_code;
        }

        while (in_array($invite_code, $codes)) {
            $invite_code = self::generateInviteCode();
        }

        $data = ['invite_code' => $invite_code];
        return $data;
    }

    /**
     * 生成邀请码字符串
     * @method generateInviteCode
     * @return [type]             [description]
     */
    private static function generateInviteCode() {
        // 生成邀请码
        $rand_str = '1234567890abcdefghijklmnopqrstuvwxyz';
        $invite_code = '';
        for ($i=0; $i < 4; $i++) {
            $invite_code .= $rand_str{mt_rand(0, 35)};
        }
        return $invite_code;
    }


    /**
     * 添加机构
     * @method postInstitution
     * @param  Request         $request [description]
     * @return [type]                   [description]
     */
    public function postInstitution(Request $request)
    {
        $institution_name = $request->get('institution_name', '');
        $cell_phone       = $request->get('cell_phone', '');
        $address          = $request->get('address', '');
        $email            = $request->get('email', '');
        $invite_code      = $request->get('invite_code', '');
        $bank_name        = $request->get('bank_name', '');
        $payment_account  = $request->get('payment_account', '');

        $institution                  = new TrainingInstitution();
        $institution->name            = $institution_name;
        $institution->cell_phone      = $cell_phone;
        $institution->address         = $address;
        $institution->email           = $email;
        $institution->invite_code     = $invite_code;
        $institution->bank_name       = $bank_name;
        $institution->payment_account = $payment_account;
        if ($institution->save()) {
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
            $ins = TrainingInstitution::find($id);
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
     * @param  TrainingInstitution       $id [description]
     * @return [type]                        [description]
     */
    public function updateOneInviteCodeStatus(TrainingInstitution $id)
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
     * @param  TrainingInstitution $id [description]
     * @return [type]                  [description]
     */
    public function getInsInfo(TrainingInstitution $id)
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
     * @param  TrainingInstitution $id [description]
     * @return [type]                  [description]
     */
    public function updateInsInfo(TrainingInstitution $id, Request $request)
    {
        $id->name       = $request->institution_name;
        $id->cell_phone = $request->cell_phone;
        $id->address    = $request->address;
        $id->email      = $request->email;
        $id->save();
        return redirect($_SERVER['HTTP_REFERER']);
    }
}
