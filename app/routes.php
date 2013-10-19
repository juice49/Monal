<?php

Route::any('/login', array('as' => 'admin.login', 'uses' => 'AdminController@login'));
Route::any('/admin', array('as' => 'admin', 'uses' => 'AdminController@dashboard'))->where('module',  '[-A-Za-z0-9_-]+');
Route::post('/ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));