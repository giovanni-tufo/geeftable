<?php

error_reporting(0);

define('SERVER_DB', 'server');
define('NAME_DB', 'db_name');
define('USER_DB', 'db_user');
define('PASS_DB', 'db_pass');

define('S3_URL', 'url_to_amazon_s3');
define('S3_BUCKET', 'bucket_name');
define('BASE_SITE', 'base_site');
if (!class_exists('S3')) {
    require_once 'S3.php';
}
if (!class_exists('SimpleImage')) {
    require_once 'SimpleImage.php';
}
if (!class_exists('Akismet')) {
    require_once 'Akismet.class.php';
}

if (!defined('awsAccessKey')) {
    define('awsAccessKey', 'your_awsAccessKey');
}
if (!defined('awsSecretKey')) {
    define('awsSecretKey', 'your_awsSecretKey');
}
if (!defined('AkismetAPIKey')) {
    define('AkismetAPIKey', 'your_AkismetAPIKey');
}

// Check for CURL
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
    exit("\nERROR: CURL extension not loaded\n\n");
}

// Pointless without your keys!
if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this') {
    exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n".
    "define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");
}
