<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 03/02/2018
 * Time: 19:19
 */

namespace App\Middleware;


class Middleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}