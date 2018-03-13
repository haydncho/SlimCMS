<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 03/02/2018
 * Time: 11:43
 */

namespace App\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller {
	public function index($request, $response) {
		$this->flash->addMessage('info', 'Test flash message');

		return $this->view->render($response, 'home.twig');
	}
}