<?php

namespace App\Console\Commands\temp;

use Illuminate\Console\Command;


use App\Helpers\MasterHelper;
use App\Helpers\RandomNameGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class User extends Command
{

    protected $objectCount = 0;
    protected $arrayName = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'temp user insert';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->start();

        echo PHP_EOL;
    }

    public function start()
    {
        $__count = 100;

        $r = new RandomNameGenerator(resource_path().'/works/random_name_file');
        $this->arrayName = $r->generateNames($__count+100);


        $x = 1;

        $bar = $this->output->createProgressBar($__count);
        $bar->start();
        do {
            $this->makeUserData($x);

            $x++;
            $bar->advance();
        } while ($x <= $__count);

        $bar->finish();
    }



    public function makeUserData(int $userCount)
    {

        $uuid = MasterHelper::GenerateUUID();

        $makeName = function() {
            $inArray = array("김", "이", "박", "최", "정", "강", "조", "윤", "장", "임", "한", "오", "서", "신", "권", "황", "안", "송", "류", "전", "홍", "고", "문", "양", "손", "배", "조", "백", "허", "유", "남", "심", "노", "정", "하", "곽", "성", "차", "주","우", "구", "신", "임", "나", "전", "민", "유", "진", "지", "엄", "채", "원", "천", "방", "공", "강", "현", "함", "변", "염", "양","변", "여", "추", "노", "도", "소", "신", "석", "선", "설", "마", "길", "주", "연", "방", "위", "표", "명", "기", "반", "왕", "금","옥", "육", "인", "맹", "제", "모", "장", "남", "탁", "국", "여", "진", "어", "은", "편", "구", "용");

            $outArray = array_rand($inArray, 2);
            $firstName = $inArray[$outArray[0]];

            $inArray2 = array("가", "강", "건", "경", "고", "관", "광", "구", "규", "근", "기", "길", "나", "남", "노", "누", "다","단", "달", "담", "대", "덕", "도", "동", "두", "라", "래", "로", "루", "리", "마", "만", "명", "무", "문", "미", "민", "바", "박", "백", "범", "별", "병", "보", "빛", "사", "산", "상", "새", "서", "석", "선", "설", "섭", "성", "세", "소", "솔", "수", "숙", "순", "숭", "슬", "승", "시", "신", "아", "안", "애", "엄", "여", "연", "영", "예", "오", "옥", "완", "요", "용", "우", "원", "월", "위","유", "윤", "율", "으", "은", "의", "이", "익", "인", "일", "잎", "자", "잔", "장", "재", "전", "정", "제", "조", "종", "주", "준", "중", "지", "진", "찬", "창", "채", "천", "철", "초", "춘", "충", "치", "탐", "태", "택", "판", "하", "한", "해", "혁", "현", "형","혜", "호", "홍", "화", "환", "회", "효", "훈", "휘", "희", "운", "모", "배", "부", "림", "봉", "혼", "황", "량", "린", "을", "비","솜", "공", "면", "탁", "온", "디", "항", "후", "려", "균", "묵", "송", "욱", "휴", "언", "령", "섬", "들", "견", "추", "걸", "삼","열", "웅", "분", "변", "양", "출", "타", "흥", "겸", "곤", "번", "식", "란", "더", "손", "술", "훔", "반", "빈", "실", "직", "흠","흔", "악", "람", "뜸", "권", "복", "심", "헌", "엽", "학", "개", "롱", "평", "늘", "늬", "랑", "얀", "향", "울", "련");
            $outArray2 = array_rand($inArray2, 2);

            $lastName = $inArray2[$outArray2[0]].$inArray2[$outArray2[1]];

            return $firstName.$lastName;
        };

        $user_name = $this->arrayName[$userCount];
        $user_email = 'temp'.$userCount.'@gmail.com';

        $userMaster = [
            'user_uuid' => $uuid,
            'user_type' => 'A02001',
            'user_state' => 'A10010',
            'user_level' => 'A20000',
            'user_name' => preg_replace("/[^a-z0-9]/i", "", strtolower($user_name)),
            'email' => $user_email,
            'password' => bcrypt('1212'),
            'profile_image' => 1,
            'profile_active' => 'Y',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('tbl_users_master')->insert($userMaster);

        $emailAuth = [
            'user_uuid' => $uuid,
            'auth_code' => Str::random(80),
            'verified_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('tbl_email_auth_master')->insert($emailAuth);

        $user_name = $makeName();
        $profileMaster = [
            'user_uuid' => $uuid,
            'name' => $user_name,
            'web_site' => 'http://www.justgram.pe.kr',
            'bio' => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,\n\n
            하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.\n\n
            예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,\n\n
            밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.',\n\n",
            'phone_number' => encrypt('01094285703'),
            'gender' => 'A21010',
        ];
        DB::table('tbl_users_profile_master')->insert($profileMaster);
    }
}
