<?php

Route::any('install/step1', array('as' => 'installation.database', 'uses' => 'InstallationController@database'));
Route::any('install/step2', array('as' => 'installation.user', 'uses' => 'InstallationController@user'));
Route::any('install/step3', array('as' => 'installation.remove', 'uses' => 'InstallationController@remove'));