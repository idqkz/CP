<?php
class DATABASE_CONFIG {

	public $denwer = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'cake_control_project',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public $dev_yy = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'cake_control_project',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public $live = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'personag_cp',
		'password' => '(@tmtrEF3%I)',
		'database' => 'personag_cp',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public function __construct() {
		if (strpos(env('HTTP_HOST'), 'dev.idq.kz') !== false) {
			// use site_one database config
			$this->default = $this->dev_yy;
		} elseif (strpos(env('HTTP_HOST'), 'cake.cp.com') !== false) {
			// use denwer database config
			$this->default = $this->denwer;
		} else {
			// use site_two database config
			$this->default = $this->live;
		}
	}
}
