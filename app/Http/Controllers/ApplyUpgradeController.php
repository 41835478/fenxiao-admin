<?php

namespace App\Http\Controllers;

use App\Services\ApplyUpgradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApplyUpgradeController extends Controller
{
    /**
     * 显示管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request){
        return view("admin.apply_upgrade.apply_upgrade_list");
    }

    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request){
        $data = (new ApplyUpgradeService())->getList($request);
        return Response::json($data);
    }

    /**
     * 申请详情
     * @param Request $request
     * @return mixed
     */
    public function detail(Request $request){
        $data = (new ApplyUpgradeService())->detail($request->post('id'));
        return $this->ajaxSuccess($data);
    }

    /**
     * 同意申请
     * @param Request $request
     * @return static
     */
    public function confirm(Request $request){
        try{
            if(!(new ApplyUpgradeService())->confirm($request->post('id'))){
                return $this->ajaxError("操作失败, 请重试");
            }
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }

        return $this->ajaxSuccess();
    }

    /**
     * 拒绝申请
     * @param Request $request
     * @return static
     */
    public function refuse(Request $request){
        if(!(new ApplyUpgradeService())->refuse($request->post('id'))){
            return $this->ajaxError("操作失败, 请重试");
        }

        return $this->ajaxSuccess();
    }

}
