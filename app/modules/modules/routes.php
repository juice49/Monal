<?php

Route::any('/admin/modules', array('as' => 'admin.modules', 'uses' => 'ModulesController@modules'));