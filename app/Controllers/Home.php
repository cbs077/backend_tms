<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        log_message('info', 'Some variable did not contain a value.');
        log_message('error','ok'); 
        #return view('welcome_message');
        return view('frontend/index.html');
    }
}
