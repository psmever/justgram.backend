<?php

use Illuminate\Database\Seeder;

use App\Helpers\MasterHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TblUsersMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->adminUser();
        $this->normalUser();
    }

    public function adminUser()
    {
        $uuid = MasterHelper::GenerateUUID();

        $userMaster = [
            'user_uuid' => $uuid,
            'user_type' => 'A02001',
            'user_state' => 'A10010',
            'user_level' => 'A20999',
            'user_name' => 'admin',
            'email' => 'admin@justgram.pe.or',
            'password' => bcrypt('1212'),
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

        $profileMaster = [
            'user_uuid' => $uuid,
            'name' => 'Site Administrator',
            'web_site' => 'http://www.justgram.pe.kr',
            'bio' => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,\n\n
            하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.\n\n
            예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,\n\n
            밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.',\n\n",
            'phone_number' => encrypt('01094285703'),
            'gender' => 'A21000',
        ];
        DB::table('tbl_users_profile_master')->insert($profileMaster);
    }

    public function normalUser()
    {
        $uuid = MasterHelper::GenerateUUID();

        $userMaster = [
            'user_uuid' => $uuid,
            'user_type' => 'A02001',
            'user_state' => 'A10010',
            'user_level' => 'A20000',
            'user_name' => 'psmever',
            'email' => 'psmever@gmail.com',
            'password' => bcrypt('1212'),
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

        $profileMaster = [
            'user_uuid' => $uuid,
            'name' => 'Park SungMin',
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
