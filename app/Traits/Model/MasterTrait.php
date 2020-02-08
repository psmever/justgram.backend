<?php
namespace App\Traits\Model;

use App\Traits\Model\BaseModelTrait as BaseModelTrait;
use Illuminate\Support\Facades\DB;

trait MasterTrait
{
    // 모띸 공통 Trait
	use BaseModelTrait {
		BaseModelTrait::controlOneDataResult as controlOneDataResult;
	}

	public function __construct()
	{
		DB::enableQueryLog();
	}

	public function __destruct()
	{
    }

    /**
     * ?? ???? ??? ?? ???? ??.
     *
     * @return array
     */
    public function getCodesList() : array
    {
        $codeList = array();

        $result = \App\Models\JustGram\CodesMaster::where('active', 'Y')->get();

        if($result->isNotEmpty())
        {
            $codes = $result->toArray();
            foreach ($codes as $key => $element):
                $group_id = isset($element['group_id']) && $element['group_id'] ? trim($element['group_id']) : NULL;
                $code_id = isset($element['code_id']) && $element['code_id'] ? trim($element['code_id']) : NULL;
                $group_name = isset($element['group_name']) && $element['group_name'] ? trim($element['group_name']) : NULL;
                $code_name = isset($element['code_name']) && $element['code_name'] ? trim($element['code_name']) : NULL;

                $codeList[] = [
                    'group_id' => $group_id,
                    'code_id' => $code_id,
                    'group_name' => $group_name,
                    'code_name' => $code_name,
                ];
            endforeach;

            return [
				'state' => true,
				'data' => $codeList
			];
        }
        else
        {
            return [
                'state' => false
            ];
        }
    }
}
