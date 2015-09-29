<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function getIndex()
    {
        return app()->welcome();
    }

    public function getFast()
    {
        return 'Faster';
    }

    public function getFastId($id)
    {
        return 'Faster with id:' . $id;
    }
}
