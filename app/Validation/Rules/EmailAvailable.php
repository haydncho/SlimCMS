<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule {
	public function validate($input) {
		// var_dump(User::where('email', $input)->count() === 0);
		// die();
		return User::where('email', $input)->count() === 0;
	}
}