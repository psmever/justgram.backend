<?php

use Illuminate\Database\Seeder;

class TblCodesMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $this->init();
    }


    /**
     * init();
     */
    public function init()
    {
        $arrayGroupCodesList = $this->initGroupCodesList();
	    $arrayCodesList = $this->initCodesList();

	    foreach ($arrayGroupCodesList as $element) :
		    $group_id = trim($element['group_id']);
		    $group_name = trim($element['group_name']);


		    DB::table('tbl_codes_master')->insert([
			    'group_id' => $group_id,
			    'group_name' => $group_name,
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ]);

		    foreach($arrayCodesList[$group_id] as $element_code):

		        $code_id = trim($element_code['code_id']);
		        $code_name = trim($element_code['code_name']);

		        $endCodeid = $group_id.$code_id;

			    DB::table('tbl_codes_master')->insert([
				    'group_id' => $group_id,
				    'group_name' => $group_name,
				    'code_id' => $endCodeid,
				    'code_name' => $code_name,
				    'created_at' => \Carbon\Carbon::now(),
				    'updated_at' => \Carbon\Carbon::now(),
			    ]);

			endforeach;


		endforeach;

    }


	/**
	 * 그룹 코드 리스트
	 * @return array
	 */
	public function initGroupCodesList()
    {
	    return [
		    [ 'group_id' => 'A01', 'group_name' => '클라이언트 타입' ],
		    [ 'group_id' => 'A02', 'group_name' => '사용자 타입(가입)' ],
		    [ 'group_id' => 'A10', 'group_name' => '사용자 상태' ],
		    [ 'group_id' => 'A20', 'group_name' => '사용자 레벨' ],
	    ];

    }


	/**
	 * 코드 리스트
	 * @return array
	 */
	public function initCodesList()
	{
		return [
			'A01' =>
				[
					[ 'code_id' => '001', 'code_name' => 'Web' ],
					[ 'code_id' => '002', 'code_name' => 'iOS' ],
					[ 'code_id' => '003', 'code_name' => 'Android' ],
				],
			'A02' =>
				[
					[ 'code_id' => '001', 'code_name' => 'Web' ],
					[ 'code_id' => '002', 'code_name' => 'iOS' ],
					[ 'code_id' => '003', 'code_name' => 'Android' ],
				],
			'A10' =>
				[
					[ 'code_id' => '000', 'code_name' => '가입대기' ],
					[ 'code_id' => '010', 'code_name' => '이메일 인증 완료(정상)' ],
				],
			'A20' =>
				[
					[ 'code_id' => '000', 'code_name' => '일반 사용자' ],
					[ 'code_id' => '900', 'code_name' => '일반 관리자' ],
					[ 'code_id' => '999', 'code_name' => '최고 관리자' ],
				],
		];

	}
}
