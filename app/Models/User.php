<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 03/02/2018
 * Time: 14:48
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
	protected $table = 'users';

	protected $fillable = [
		'name',
		'email',
		'password',
	];

	public function setPassword($password) {
		$this->update([
			'password' => password_hash($password, PASSWORD_DEFAULT),
		]);
	}

}