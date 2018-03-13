<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 03/02/2018
 * Time: 10:02
 */

use Respect\Validation\validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
		'db' => [
			'driver' => 'mysql',
			'host' => '45.76.103.123',
			'database' => 'slimcms',
			'username' => 'slimcms',
			'password' => 'slimcms',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => '',
		],
	],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
	return $capsule;
};

$container['auth'] = function ($c) {
	return new \App\Auth\Auth;
};

$container['flash'] = function ($c) {
	return new \Slim\Flash\Messages;
};

$container['view'] = function ($c) {
	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
		'cache' => false,
	]);

	$basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
	$view->addExtension(new \Slim\Views\TwigExtension(
		$c['router'],
		$basePath
	));

	$view->getEnvironment()->addGlobal('auth', [
		'check' => $c->auth->check(),
		'user' => $c->auth->user(),
	]);

	$view->getEnvironment()->addGlobal('flash', $c->flash);

	return $view;
};

$container['validator'] = function ($c) {
	return new \App\Validation\Validator();
};

$container['HomeController'] = function ($c) {
	return new \App\Controllers\HomeController($c);
};

$container['AuthController'] = function ($c) {
	return new \App\Controllers\Auth\AuthController($c);
};

$container['PasswordController'] = function ($c) {
	return new \App\Controllers\Auth\PasswordController($c);
};

$container['csrf'] = function ($c) {
	return new \Slim\Csrf\Guard;
};

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

$app->add(new \App\Middleware\OldInputMiddleware($container));

$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
