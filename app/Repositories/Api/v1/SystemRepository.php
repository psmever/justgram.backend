<?php
namespace App\Repositories\Api\v1;

use App\Traits\Model\MasterTrait;
use Illuminate\Support\Facades\App;

class SystemRepository implements SystemRepositoryInterface
{
    public function start()
    {

    }

    /**
     * 공통 코드 조합.
     *
     * @return array
     */
    private function getCombinCodesList() : array
    {
        $returnData = array();

        $codes = MasterTrait::getCodesList();

        if($codes['state'])
        {
            foreach ($codes['data'] as $element)
            {
                $group_id = $element['group_id'];
                $code_id = $element['code_id'];
                $group_name = $element['group_name'];
                $code_name = $element['code_name'];

                if($code_id)
                {
                    $returnData[$group_id][] = [
                        'code_id' => $code_id,
                        'code_name' => $code_name,
                    ];
                }
            }
        }

        return $returnData;
    }

    /**
     * 싸이트 기본 데이터 조합해서 전달.
     *
     * @return array
     */
    public function getSiteBasicData() : array
    {
        $codelists = $this->getCombinCodesList();

        return [
            // 'code_list' => json_encode($codelists)
            'system_environment' => App::environment(),
            'code_list' => $codelists
        ];
    }
}
