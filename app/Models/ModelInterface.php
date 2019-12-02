<?php


namespace App\Models;


interface ModelInterface
{
	public static function start();
	public static function returnOneDataControl($params);
	public static function returnDatasControl($params);
}