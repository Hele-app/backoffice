<?php

namespace App\Http\Controllers;

use App\Http\HeleApiWrapper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected $hele = null;

    public function __construct()
    {
        $this->hele = new HeleApiWrapper();
    }
}
