<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'name'     => 'Administrator',
			'username' => 'admin',
			'email'    => 'admin@keywordplanner.com',
			'password' => Hash::make('insyde'),
		));

		User::create(array(
			'name'     => 'Indra Firmansyah',
			'username' => 'indransyah',
			'email'    => 'indransyah@gmail.com',
			'password' => Hash::make('insyde'),
		));
	}

}
