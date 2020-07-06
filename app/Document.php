<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $casts = [
		'id' => 'string',
		'payload' => 'object'
	];
	public $incrementing = false;
}
