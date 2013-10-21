<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'AJAXController' => $baseDir . '/app/controllers/AJAX.php',
    'AdminController' => $baseDir . '/app/controllers/AdminController.php',
    'App\\Core\\Contracts\\ServiceProviderInterface' => $baseDir . '/app/core/contracts/ServiceProviderInterface.php',
    'App\\Core\\Modules\\ModuleServiceProvider' => $baseDir . '/app/core/ModuleServiceProvider.php',
    'App\\Modules\\Messages\\Contracts\\MessagesInterface' => $baseDir . '/app/modules/messages/contracts/MessagesInterface.php',
    'App\\Modules\\Messages\\Messages' => $baseDir . '/app/modules/messages/libraries/Messages.php',
    'App\\Modules\\Messages\\MessagesServiceProvider' => $baseDir . '/app/modules/messages/MessagesServiceProvider.php',
    'App\\Modules\\Module\\Contracts\\ModuleManagerInterface' => $baseDir . '/app/modules/module/contracts/ModuleManagerInterface.php',
    'App\\Modules\\Module\\ModuleManager' => $baseDir . '/app/modules/module/libraries/ModuleManager.php',
    'App\\Modules\\Module\\ModuleManagerServiceProvider' => $baseDir . '/app/modules/module/ModuleManagerServiceProvider.php',
    'App\\Modules\\Users\\Contracts\\UserAuthInterface' => $baseDir . '/app/modules/users/contracts/UserAuthInterface.php',
    'App\\Modules\\Users\\Contracts\\UserInterface' => $baseDir . '/app/modules/users/contracts/UserInterface.php',
    'App\\Modules\\Users\\Contracts\\UsersManagerInterface' => $baseDir . '/app/modules/users/contracts/UsersManagerInterface.php',
    'App\\Modules\\Users\\User' => $baseDir . '/app/modules/users/libraries/User.php',
    'App\\Modules\\Users\\UserAuth' => $baseDir . '/app/modules/users/libraries/UserAuth.php',
    'App\\Modules\\Users\\UsersManager' => $baseDir . '/app/modules/users/libraries/UsersManager.php',
    'App\\Modules\\Users\\UsersServiceProvider' => $baseDir . '/app/modules/users/UsersServiceProvider.php',
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'Module' => $baseDir . '/app/core/Module.php',
    'ModuleInterface' => $baseDir . '/app/core/contracts/ModuleInterface.php',
    'Module_Messages' => $baseDir . '/app/modules/messages/details.php',
    'Module_Module' => $baseDir . '/app/modules/module/details.php',
    'Module_Users' => $baseDir . '/app/modules/users/details.php',
    'Modules_m' => $baseDir . '/app/modules/module/models/Module_m.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',
    'UserGroupPrivileges_m' => $baseDir . '/app/modules/users/models/UserGroupPrivileges_m.php',
    'UserGroups_m' => $baseDir . '/app/modules/users/models/UserGroups_m.php',
    'UsersAJAX' => $baseDir . '/app/modules/users/libraries/AJAX.php',
    'UsersController' => $baseDir . '/app/modules/users/controllers/Users.php',
    'Users_m' => $baseDir . '/app/modules/users/models/Users_m.php',
);
