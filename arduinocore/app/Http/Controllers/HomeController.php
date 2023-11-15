<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MenuService;
use App\Traits\ProfileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    use ProfileTrait;

    public function index()
    {
        return view('home');
    }

    public function getData()
    {
        return $this->getMenu();
    }

}
