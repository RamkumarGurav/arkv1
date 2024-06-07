<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/


require_once APPPATH."config/database.php";

$hook['pre_system'] = array(
    'class'    => 'Router_Hook',
    'function' => 'get_routes',
    'filename' => 'Router_Hook.php',
    'filepath' => 'hooks',
    'params'   => array(
        $db['default']['hostname'],
        $db['default']['username'],
        $db['default']['password'],
        $db['default']['database'],
        $db['default']['dbprefix'],
        )
    );