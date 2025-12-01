<?php

namespace App\Http\Controllers;
use App\Models\Catalog\Category;
use App\Models\SizeChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SizeChartController extends Controller
{



  public function index()
  {
    return view('admin.business_settings.size_chart');
  }

  public function data()
  {
    $charts = SizeChart::query()
      ->orderByDesc('id')
      ->get()
      ->map(function ($c) {
        return [
          'id' => $c->id,
          'name' => $c->name,
          'unit' => $c->unit,
          'category_slug' => $c->category_slug,
          'columns' => $c->columns ?? [],
          'rows' => $c->rows ?? [],
          'notes' => $c->notes,
          'image' => $c->image_path ? Storage::url($c->image_path) : null,
        ];
      });

    return response()->json(['charts' => $charts]);
  }
  public function store(Request $r)
  {
    $v = $r->validate([
      'name' => 'required|string|max:255',
      'unit' => 'nullable|string|max:16',
      'category_slug' => 'nullable|string',
      'columns' => 'required|array|min:1',
      'rows' => 'required|array',
      'notes' => 'nullable|string',
      'image_base64' => 'nullable|string', // data URL
    ]);

    $catId = null;
    if (!empty($v['category_slug'])) {
      $catId = optional(Category::firstWhere('slug', $v['category_slug']))->id;
    }

    $path = null;
    if (!empty($v['image_base64']) && str_starts_with($v['image_base64'], 'data:')) {
      [$meta, $data] = explode(',', $v['image_base64'], 2);
      $ext = str_contains($meta, 'image/png') ? 'png' : (str_contains($meta, 'image/webp') ? 'webp' : 'jpg');
      $bin = base64_decode($data);
      $path = 'size-charts/' . uniqid('sc_') . '.' . $ext;
      Storage::disk('public')->put($path, $bin);
    }

    $chart = SizeChart::create([
      'category_id' => $catId,
      'name' => $v['name'],
      'unit' => $v['unit'] ?? null,
      'columns' => $v['columns'],
      'rows' => $v['rows'],
      'notes' => $v['notes'] ?? null,
      'image_path' => $path,
      'created_by' => optional(auth()->user())->id,
    ]);

    return response()->json([
      'id' => $chart->id,
      'name' => $chart->name,
      'unit' => $chart->unit,
      'columns' => $chart->columns,
      'rows' => $chart->rows,
      'notes' => $chart->notes,
      'image' => $chart->image_path ? asset('storage/' . $chart->image_path) : null,
    ]);
  }




public function destroy(SizeChart $chart)
{
  if ($chart->image_path && Storage::disk('public')->exists($chart->image_path)) {
    Storage::disk('public')->delete($chart->image_path);
  }
  $chart->delete();
  return response()->noContent(); // 204
}

public function destroyImage(SizeChart $chart)
{
  if ($chart->image_path && Storage::disk('public')->exists($chart->image_path)) {
    Storage::disk('public')->delete($chart->image_path);
  }
  $chart->image_path = null;
  $chart->save();

  return response()->json([
    'id' => $chart->id,
    'image' => null,
  ]);
}

// optional: allow update to clear image via flag
public function update(Request $r, SizeChart $chart)
{
  $v = $r->validate([
    'name' => 'required|string|max:255',
    'unit' => 'nullable|string|max:16',
    'category_slug' => 'nullable|string',
    'columns' => 'required|array|min:1',
    'rows' => 'required|array',
    'notes' => 'nullable|string',
    'image_base64' => 'nullable|string',
    'remove_image' => 'sometimes|boolean',
  ]);

  if (!empty($v['category_slug'])) {
    $cat = Category::firstWhere('slug', $v['category_slug']);
    $chart->category_id = optional($cat)->id;
  }

  if (!empty($v['remove_image'])) {
    if ($chart->image_path && Storage::disk('public')->exists($chart->image_path)) {
      Storage::disk('public')->delete($chart->image_path);
    }
    $chart->image_path = null;
  }

  if (!empty($v['image_base64']) && str_starts_with($v['image_base64'], 'data:')) {
    [$meta, $data] = explode(',', $v['image_base64'], 2);
    $ext = str_contains($meta, 'image/png') ? 'png' : (str_contains($meta, 'image/webp') ? 'webp' : 'jpg');
    $bin = base64_decode($data);
    $path = 'size-charts/' . uniqid('sc_') . '.' . $ext;
    Storage::disk('public')->put($path, $bin);
    if ($chart->image_path && Storage::disk('public')->exists($chart->image_path)) {
      Storage::disk('public')->delete($chart->image_path);
    }
    $chart->image_path = $path;
  }

  $chart->fill([
    'name' => $v['name'],
    'unit' => $v['unit'] ?? null,
    'columns' => $v['columns'],
    'rows' => $v['rows'],
    'notes' => $v['notes'] ?? null,
  ])->save();

  return response()->json([
    'id' => $chart->id,
    'name' => $chart->name,
    'unit' => $chart->unit,
    'columns' => $chart->columns,
    'rows' => $chart->rows,
    'notes' => $chart->notes,
    'image' => $chart->image_path ? asset('storage/'.$chart->image_path) : null,
  ]);
}



}

