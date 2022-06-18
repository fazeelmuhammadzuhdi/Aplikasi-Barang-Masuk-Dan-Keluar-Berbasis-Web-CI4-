<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{

	protected $table                = 'users1910021';
	protected $primaryKey           = 'userid1910021';
	protected $allowedFields        = [
		'userid1910021', 'usernama1910021', 'userpassword1910021', 'userlevelid1910021'
	];
}