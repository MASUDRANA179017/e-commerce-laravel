<?php

// app/Http/Controllers/SizeChartTemplateController.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SizeChartTemplate;

class SizeChartTemplateController extends Controller {
  public function index(Request $r) {
    $q = SizeChartTemplate::query()->with('category:id,slug,name')->where('is_active',true);
    if ($slug = $r->query('category')) {
      $q->whereHas('category', fn($qq)=>$qq->where('slug',$slug));
    }
    $rows = $q->orderBy('name')->get();

    // Group by category slug to mirror your CAT_TEMPLATES
    $grouped = [];
    foreach ($rows as $tpl) {
      $key = $tpl->category?->slug ?? 'general';
      $grouped[$key][] = [
        'id'      => $tpl->id,
        'code'    => $tpl->code,
        'name'    => $tpl->name,
        'unit'    => $tpl->unit,
        'columns' => $tpl->columns,
        'rows'    => $tpl->rows,
      ];
    }
    return response()->json(['templates_by_category' => $grouped]);
  }
}
