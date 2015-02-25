<?php
class UsersTableSeeder extends Seeder{
	public function run(){
		$users  = [ 
			[
				'username'  => 'super_admin',
				'email'     => 'super_admin@grabone.de',
				'password'  => Hash::make('super_admin_password'), 
				'role_id'   => 1,
				'promocode' => Str::random(10),
			],
			[
				'username'  => 'thanchet',
				'email'     => 'pvh8692@gmail.com',
				'password'  => Hash::make('thanchet'), 
				'role_id'   => 1,
				'promocode' => Str::random(10),
			],
			[
				'username'  => 'admin',
				'email'     => 'admin@grabone.de',
				'password'  => Hash::make('admin_password'),
				'role_id'   => 2,
				'promocode' => Str::random(10),
			],
			[
				'username'  => 'agent',
				'email'     => 'agent@grabone.de',
				'password'  => Hash::make('agent_password'),
				'role_id'   => 3,
				'promocode' => Str::random(10),
			],
			[
				'username'  => 'biz',
				'email'     => 'biz@grabone.de',
				'password'  => Hash::make('biz_password'),
				'role_id'   => 4,
				'promocode' => Str::random(10),
			],
			[
				'username'  => 'user',
				'email'     => 'user@grabone.de',
				'password'  => Hash::make('user_password'),
				'role_id'   => 5,
				'promocode' => Str::random(10),
			]
		];
		foreach($users as $user){
			User::insert($user);
		}
	}
}
?>