<?php

namespace App\Traits\Model;

trait BaseModelTrait
{

	public static function modelTraitTest()
	{
		echo __FUNCTION__;
	}

	/**
	 * mysql ?? ?? ??.
	 * @param $params
	 * @return array
	 */
	public static function controlOneDataResult($params) : array
	{

		if($params->isNotEmpty())
		{
			return [
				'state' => true,
//				'data' => $params->first()->attributesToArray() // ??????
				'data' => $params->toArray()
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