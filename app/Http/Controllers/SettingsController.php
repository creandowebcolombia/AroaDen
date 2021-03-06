<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Auth;
use Lang;

class SettingsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->main_route = $this->config['routes']['users'];
        $this->views_folder = $this->config['routes']['settings'];
    }	

    public function index(Request $request)
    {  	 	  
        $username = Auth::user()->username;

        $this->view_data['request'] = $request;
        $this->view_data['username'] = $username;

        $this->setPageTitle(Lang::get('aroaden.settings'));

        return parent::index($request);
    }

    public function jsonSettings(Request $request)
    {         
        $data = [];
        $data['page_title'] = $request->session()->get('page_title');

        $this->echoJsonOuptut($data);
    }


}
