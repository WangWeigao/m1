<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Version;

class ManageUpdateVersionController extends Controller
{
    /**
     * 获取APP的版本信息
     * @method getVersion
     * @return [type]     [description]
     */
    public function getVersions()
    {
        $infos = Version::all();
        return view('app_version')->with('infos', $infos);
    }

    /**
     * 获取单个平台的版本信息
     * @method getVersion
     * @param  Version    $id [description]
     * @return [type]         [description]
     */
    public function getVersion(Version $id)
    {
        return $id;
    }


    public function updateVersion(Version $id, Request $request)
    {
        $id->version      = $request->version;
        $id->url          = $request->url;
        $id->detail       = $request->detail;
        $id->force_update = $request->force_update;

        if ($id->save()) {
            $data['status'] = 0;
        } else {
            $data['status'] = 10000;
            $data['msg'] = '更新失败';
        }

        return $data;
    }
}
