
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

try {
    echo "Starting query test...\n";
    $query = DB::table('products')
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->leftJoin('product_category_map as pcm', function ($join) {
            $join->on('products.id', '=', 'pcm.product_id')
                ->where('pcm.is_primary', true);
        })
        ->leftJoin('product_categories as pc', 'pcm.category_id', '=', 'pc.id')
        ->whereNull('products.deleted_at')
        ->select(
            'products.id',
            'products.title',
            'products.sku',
            'brands.name as brand_name',
            'pc.name as category_name',
            'products.status',
            'products.created_at'
        )
        ->orderBy('products.created_at', 'desc');

    echo "Query built. Count: " . $query->count() . "\n";
    
    // Test retrieving data directly first
    $results = $query->limit(5)->get();
    echo "First 5 rows: " . $results->toJson() . "\n";

    // Test DataTables logic
    // We mock the request parameters that DataTables sends
    request()->merge([
        'draw' => 1,
        'start' => 0,
        'length' => 10,
        'search' => ['value' => '', 'regex' => false],
        'order' => [['column' => 0, 'dir' => 'desc']],
        'columns' => [
            ['data' => 'id', 'name' => 'products.id', 'searchable' => true, 'orderable' => true, 'search' => ['value' => '', 'regex' => false]]
        ]
    ]);

    echo "Testing DataTables generation...\n";
    $dt = DataTables::of($query)->make(true);
    echo "DataTables response content: \n";
    // echo $dt->getContent(); // This returns the JSON string
    
    // Decode to verify structure
    $json = json_decode($dt->getContent(), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "Valid JSON generated.\n";
        echo "Records Total: " . ($json['recordsTotal'] ?? 'N/A') . "\n";
        echo "Data count: " . count($json['data'] ?? []) . "\n";
    } else {
        echo "Invalid JSON: " . json_last_error_msg() . "\n";
    }

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
