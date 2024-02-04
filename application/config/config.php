<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$config['base_url'] = 'https://antoniusamp.ddns.net/';
//$config['base_url'] = '';
$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$config['index_page'] = '';

$config['uri_protocol']	= 'REQUEST_URI';

$config['url_suffix'] = '';

$config['language']	= 'indonesian';

$config['charset'] = 'UTF-8';

$config['enable_hooks'] = FALSE;

$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = FALSE;

$config['permitted_uri_chars'] = 'a-z 0-9~%.,:_\-=';

$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 0;

$config['log_path'] = '';

$config['log_file_extension'] = '';

$config['log_file_permissions'] = 0644;

$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';

$config['cache_path'] = '';

$config['cache_query_string'] = FALSE;

$config['encryption_key'] = 'histalumir$$65216';

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'mrsp_sess';
$config['sess_expiration'] = 0;
$config['sess_save_path'] = sys_get_temp_dir();
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

/*
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'ci_sessions';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';//its your table name name
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;

$config['sess_driver'] = 'redis';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'tcp://localhost:6379';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = TRUE;
/*
$config['sess_driver'] = 'redis';
$config['sess_cookie_name'] = 'vcass_';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'tcp://127.0.0.1:6379';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
*/
/*
$config['redis_default']['host'] = 'localhost';		// IP address or host
$config['redis_default']['port'] = '6379';			// Default Redis port is 6379
$config['redis_default']['password'] = '';			// Can be left empty when the server does not require AUTH

$config['redis_slave']['host'] = 'localhost';
$config['redis_slave']['port'] = '6379';
$config['redis_slave']['password'] = '';
*/

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = TRUE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';
