<?php
class RoleTable extends Seeder{
	public function run(){
		Role::insert(['role' => 'super admin']);
		Role::insert(['role' => 'admin']);
		Role::insert(['role' => 'agent']);
		Role::insert(['role' => 'biz']);
		Role::insert(['role' => 'user']);
	}
}
?>