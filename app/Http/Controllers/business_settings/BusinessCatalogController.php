<?php

namespace App\Http\Controllers\business_settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessCatalogController extends Controller
{
    //

    public function index(){
        return view('admin.business_settings.multi_business_catalog');
    }

    public function business_setup_index(){
        return view('admin.business_settings.business_setup');
    }




    public function all_attributes_index(){
        return view('admin.business_settings.all_attributes');
    }
}
