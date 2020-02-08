<?php
namespace App\Http\Controllers\Api\JustGram\v1;

use App\Http\Controllers\Api\JustGram\v1\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Repositories\Api\v1\SystemRepository;

class SystemController extends BaseController
{
    protected $system;

    public function __construct(SystemRepository $system)
    {
        $this->system = $system;
    }

    /**
     * 서버 체크.
     */
    public function server(Request $request)
    {
        return $this->defaultSuccessResponse([]);
    }

    /**
     * 공지 사항.
     */
    public function notice(Request $request)
    {
        $notice = "공지 사항이 존재 하지 않습니다.";

        return $this->defaultErrorResponse([
            'message' => $notice
        ]);
    }

    /**
     * 기본적인 싸이트 정보.
     */
    public function sitedata(Request $request)
    {
        $getCodeList = $this->system->getSiteBasicData();

        return $this->defaultSuccessResponse([
            'data' => $getCodeList
        ]);
    }
}
