<?php
//include the config file
include(FORM_DIR . "config.php");

//make sure to add the autoload!!!

//init
FModel::init();

/*---------------------------------------TESTING PURPOSES----------------------------------------*/


//ON DEVELOPMENT ONLY!! db errors
Database::display_errors();
