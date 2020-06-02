<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
        	['id'=>1, 'name'=>'admin', 'type'=>'admin', 'mobile'=>'980000000', 'email'=>'admin@admin.com', 'password'=>'$2y$10$RitKwoFPovwXT9.uLiXnUOM1a66fGL0.P4S.KxQRanpAweiRC0RUO', 'image'=>'', 'status'=>1
        	],

        		['id'=>2, 'name'=>'john', 'type'=>'subadmin', 'mobile'=>'980000000', 'email'=>'john@admin.com', 'password'=>'$2y$10$RitKwoFPovwXT9.uLiXnUOM1a66fGL0.P4S.KxQRanpAweiRC0RUO', 'image'=>'', 'status'=>1
        	],

        	['id'=>3, 'name'=>'steve', 'type'=>'superadmin', 'mobile'=>'980000000', 'email'=>'hdfghd@admin.com', 'password'=>'$2y$10$RitKwoFPovwXT9.uLiXnUOM1a66fGL0.P4S.KxQRanpAweiRC0RUO', 'image'=>'', 'status'=>1
        	],
        	
        	['id'=>4, 'name'=>'milan', 'type'=>'superadmin', 'mobile'=>'980000000', 'email'=>'milan@admin.com', 'password'=>'$2y$10$RitKwoFPovwXT9.uLiXnUOM1a66fGL0.P4S.KxQRanpAweiRC0RUO', 'image'=>'', 'status'=>1
        	],
        ];
    
    DB::table('admins')->insert($adminRecords);
/*		foreach ($adminRecords as $key => $record) {
			\App\Admin::create($record);
		}*/
    }
}
