<?php
/**
 * Wordpress MVC Theme addon
 * 
 * @author Tom Reeve <thomas.reeve@richardsonsgroup.net>
 * @copyright (c) 2020 Richardsons Leisure Ltd.
*/
require_once __DIR__ . '/../vendor/autoload.php';
use WPMVC\Core\Bootstrap;

//Load in the model user wants to use.
function load_models($model){
    Bootstrap::loadModels($model);
}

//Load in the emails user wants to use.
function load_emails($emails){
    Bootstrap::loadEmails($emails);
}