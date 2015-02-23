<?php
# Database Configuration
define( 'DB_NAME', 'visualcut_test' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY', 'Azj)W+CEe|%bFrM-)|mUM+?v5QMyeUdMa T+N<N4`+|G _5*e%VQdsPxT)wwx-lK');
define('SECURE_AUTH_KEY', '$Ktz_I9%],2*rI{=GwMO|TV=J%&xJmShL;M~*YY84p#w.))$,ktXWu~h[FZkELlN');
define('LOGGED_IN_KEY', 'br*}]I*cWd^~(|G):=jPK?C`_t-J^XGu6E^$|=[Fd2e%3(2j/AL7$}_`4T7tq5.}');
define('NONCE_KEY', 'lF>4ou$|ePI@2Rvlf4na,f~qFC1IePur `#l-=EJufO|R3?4Ok=wV,Lv6[Tf{!5&');
define('AUTH_SALT',        'Zf>w^:n+L1H>Lr.CF+:_LLn;5^!ng }cN=35LKzp V]KL{MzQ(WQ~5c%u3.3-jz(');
define('SECURE_AUTH_SALT', 'i}[K8F+P28`/Sj>5J2<YFTV<b@Les{>c0;}8K2YGc*nh[Fj@9i-4B+ELvbG@j+v/');
define('LOGGED_IN_SALT',   '$wX)v[7D6{[V#{!2PQf%E`;~k7Cn!3w<Crun=xjjIfnoJlr:;)i|!fJ.my+-1|mt');
define('NONCE_SALT',       'tg|A(%D{lC>9ZM?jScE4iC#%,{J1dC?R)fTAJY>o*a`g@/,M,YO4_1kSdGnF:h7:');


# Localized Language Stuff

define( 'WP_CACHE', false );

define( 'PWP_NAME', 'visualcut' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '14fad06be9fb9de0168254eda0a79ed166bf8b25' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '2988' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'visualcut.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-2988', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );

define( 'WP_AUTO_UPDATE_CORE', false );

$wpe_special_ips=array ( 0 => '173.255.209.9', );

$wpe_netdna_domains_secure=array ( );

define( 'WPE_CACHE_TYPE', 'generational' );

define( 'WPE_LBMASTER_IP', '173.255.209.9' );

define( 'WP_SITEURL', 'http://visualcut.staging.wpengine.com' );

define( 'WP_HOME', 'http://visualcut.staging.wpengine.com' );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
