<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
/*define('URL', 'http://localhost/diary/');
define('LIBS', 'libs/');

define('DB_TYPE', 'pgsql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mamoni');
define('DB_USER', 'postgres');
define('DB_PASS', 'taw1994');
define('FORM_DIR','../form/');*/

define('URL', 'http://kolorob.net/mamoni/');
define('LIBS', 'libs/');

define('DB_TYPE', 'pgsql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mamoni');
define('DB_USER', 'postgres');
define('DB_PASS', 'kolorob@SCIBD@2015-06');
define('FORM_DIR','../form/');



// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'MixitUp200');

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');