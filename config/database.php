<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
    /*
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'u739483627_doar2',
    */
	'hostname' => 'localhost',
	'username' => 'u344891621_titobeca',
	'password' => 'RebecA1980',
	'database' => 'u344891621_doar_beta',
    
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
