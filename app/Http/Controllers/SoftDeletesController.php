<?php

namespace App\Http\Controllers;

use App\Traits\SoftDeletesTrait;

abstract class SoftDeletesController extends Controller
{
    use SoftDeletesTrait;

    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
