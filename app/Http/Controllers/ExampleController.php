<?php namespace App\Http\Controllers;


class ExampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('example');
    }

    public function index()
    {
        return "NoFilter";
    }
}