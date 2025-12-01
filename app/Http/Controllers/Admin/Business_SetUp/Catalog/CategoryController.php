<?php

namespace App\Http\Controllers\Admin\Business_SetUp\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::orderBy('name')
            ->get(['id','slug','name']);

        return response()->json(['categories' => $cats]);
    }
}
