@extends('layouts.master')
@section('title','Dashboard')
@section('content')

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
  :root{
    --line:#e5e7eb; --muted:#6b7280; --radius:14px;
    --primary: 21, 94, 117;
  }
  body{background:#f5f7fb}
  .small-muted{font-size:.85rem;color:var(--muted)}
  .page-title{font-weight:700}
  .badge-soft{background:#eef2ff;color:#1e40af;border:1px solid #dbeafe}
  .card{border:1px solid var(--line);border-radius:var(--radius);background:#fff}
  .card-h{padding:.8rem 1rem;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center}
  .card-b{padding:1rem}
  .subgrid{display:grid;gap:10px;grid-template-columns:repeat(2,minmax(0,1fr))}
  @media(max-width:768px){.subgrid{grid-template-columns:1fr}}
  .chip{border:1px solid #e5e7eb;border-radius:999px;padding:4px 10px;background:#fff;display:inline-flex;align-items:center;gap:6px;margin:2px}
  .sw{width:12px;height:12px;border-radius:50%;border:1px solid #e5e7eb}
  .btn-ghost{background:#fff;border:1px dashed #e5e7eb}
  .grid{display:grid;gap:14px}
  .grid-3{grid-template-columns:1.2fr 1fr 1.2fr}
  @media(max-width:1200px){.grid-3{grid-template-columns:1fr}}
  .hstack{display:flex;gap:8px;flex-wrap:wrap}
  .add-ico{border:1px solid #dbeafe;background:#eef2ff;color:#1e40af;border-radius:8px;padding:.25rem .45rem;line-height:1}
  .add-ico:hover{background:#e0e7ff}
  .btn-outline{border:1px solid var(--line);background:#fff}

  /* qb-wizard-nav */
  .qb-wizard-nav{display:flex;gap:.6rem;overflow:auto;padding:.6rem;border:1px solid var(--line);border-radius:12px;background:#f8fafc}
  .qb-wizard-tab{display:flex;gap:.6rem;align-items:center;padding:.5rem .8rem;border:1px solid #e6e3ef;border-radius:.6rem;background:#fff;cursor:pointer;white-space:nowrap;transition:.15s}
  .qb-wizard-tab:hover{box-shadow:0 1px 6px rgba(0,0,0,.08);transform:translateY(-1px)}
  .qb-wizard-tab.is-active{border-color:rgba(var(--primary),.7);box-shadow:0 0 0 .15rem rgba(var(--primary),.1);background:rgba(var(--primary),.03)}
  .qb-wizard-tab-icon{font-size:1rem;width:30px;height:30px;display:grid;place-items:center;border-radius:.5rem;background:rgba(var(--primary),.12);color:rgba(var(--primary),1)}
  .qb-wizard-tab.is-active .qb-wizard-tab-icon{background:rgba(var(--primary),1);color:#fff}

  /* product cards (e-commerce style) */
  .pgrid{display:grid;gap:12px;grid-template-columns:repeat(2,minmax(0,1fr))}
  @media(max-width:576px){.pgrid{grid-template-columns:1fr}}
  .pcard{border:1px solid var(--line);border-radius:14px;overflow:hidden;background:#fff;position:relative}
  .pcard img{width:100%;height:160px;object-fit:cover}
  .pcard .pbody{padding:.7rem .8rem}
  .pcard .title{font-weight:600}
  .pcard .price{font-weight:700}
  .pcard .badge{position:absolute;top:10px;left:10px;background:#111827;color:#fff;border-radius:999px;padding:3px 8px;font-size:.75rem}
  .rating{font-size:.9rem;color:#f59e0b}
  .actbar{display:flex;gap:6px}
  .mini-btn{border:1px solid var(--line);background:#fff;border-radius:8px;padding:.25rem .45rem}

  /* sticky header */
  .topbar{position:sticky;top:0;z-index:6;background:var(--bs-body-bg);padding:12px 0 10px}
</style>

<div class="topbar">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h3 class="page-title mb-0"><i class="bx bx-category-alt me-2"></i>Multi-Business Master Catalog</h3>
    <div class="hstack">
      <button id="btnExport" class="select-btn-info"><i class="bx bx-download me-1"></i>Export</button>
      <label class="select-btn-info mb-0"><i class="bx bx-upload me-1"></i>Import<input id="imp" type="file" accept="application/json" class="d-none"></label>
      <button id="btnClear" class="select-btn-white"><i class="bx bx-trash me-1"></i>Clear Local</button>
    </div>
  </div>
  <div class="qb-wizard-nav" id="bizTabs"><!-- JS --></div>
</div>

<!-- ============ 3-column content ============ -->
<div class="grid grid-3" id="columns">
  <!-- Column 1 -->
  <div>
    <div class="card mb-3">
      <div class="card-h">
        <div><i class="bx bx-slider-alt me-1"></i><b>Attributes & Variant</b></div>
        <div class="small-muted">সব গ্রুপে ডানে ➕ দিয়ে নতুন আইটেম যোগ করুন</div>
      </div>
      <div class="card-b">
        <div id="attrVariantWrap" class="subgrid"><!-- sub-cards --></div>
      </div>
    </div>

    <div class="card">
      <div class="card-h">
        <div><i class="bx bx-image-alt me-1"></i><b>Media & Variant Rules</b></div>
        <button class="add-ico" data-add="rule"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="rulesWrap"><!-- JS --></div>
    </div>
  </div>

  <!-- Column 2 -->
  <div>
    <div class="card">
      <div class="card-h">
        <div><i class="bx bx-collection me-1"></i><b>Attribute Sets</b> <span class="badge-soft ms-2" id="attrSetCount">0</span></div>
        <button class="add-ico" data-add="attrset"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="attrSetsWrap"><!-- JS --></div>
    </div>

    <div class="card mt-3">
      <div class="card-h">
        <div><i class="bx bx-intersect me-1"></i><b>Variant Set</b> <span class="badge-soft ms-2" id="varSetCount">0</span></div>
        <button class="add-ico" data-add="variantset"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="variantSetsWrap"><!-- JS --></div>
    </div>

    <div class="card mt-3">
      <div class="card-h">
        <div><i class="bx bx-sitemap me-1"></i><b>Category (3-layer)</b></div>
        <button class="add-ico" data-add="category"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="catWrap"><!-- JS tree --></div>
    </div>

    <div class="card mt-3">
      <div class="card-h">
        <div><i class="bx bx-grid-alt me-1"></i><b>Collections</b></div>
        <button class="add-ico" data-add="collection"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="colWrap" class="hstack"><!-- JS --></div>
    </div>

    <div class="card mt-3">
      <div class="card-h">
        <div><i class="bx bx-filter-alt me-1"></i><b>Filters / Facets</b></div>
        <button class="add-ico" data-add="filter"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="filterWrap" class="hstack"><!-- JS --></div>
    </div>
  </div>

  <!-- Column 3 -->
  <div>
    <div class="card">
      <div class="card-h">
        <div><i class="bx bx-table me-1"></i><b>Size Charts</b></div>
        <button class="add-ico" data-add="sizechart"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b" id="sizeWrap"><!-- JS tables --></div>
    </div>

    <div class="card mt-3">
      <div class="card-h">
        <div><i class="bx bx-shopping-bag me-1"></i><b>Sample Products</b></div>
        <button class="add-ico" data-add="product"><i class="bx bx-plus"></i></button>
      </div>
      <div class="card-b">
        <div id="prodWrap" class="pgrid"><!-- JS products --></div>
      </div>
    </div>
  </div>
</div>

<!-- =================== Add Modal (generic) =================== -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-plus-circle me-2"></i><span id="amTitle">Add</span></h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="amBody"><!-- JS form --></div>
      <div class="modal-footer">
        <button class="create-btn-white" data-bs-dismiss="modal">Close</button>
        <button id="amSave" class="create-btn-base">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header"><i class="bx bx-check-shield me-2"></i><strong class="me-auto">Catalog</strong><small>now</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast"></button></div>
    <div class="toast-body" id="toastMsg">Saved</div>
  </div>
</div>


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
  const $=s=>document.querySelector(s), $$=s=>Array.from(document.querySelectorAll(s));
  const toast=new bootstrap.Toast('#liveToast'); const say=m=>{ $('#toastMsg').textContent=m; toast.show(); };
  const showModal=(id)=> new bootstrap.Modal(document.getElementById(id)).show();

  /* ======================== Data (12 businesses) ======================== */
  // প্রতিটা ব্লুপ্রিন্টে: groups (cards for col-1), rules, attrSets (3),
  // variantSets (3), categories (3-layer), collections, filters, sizeCharts, products
  const BASE = {
    // common helpers
    units:['cm','mm','inch','kg','g','lb'],
    brands:['No brand'],
    rules:[
      'Max 8 images (<=2MB each)',
      'Variant-wise images supported',
      'Primary image: front/hero',
      'Alt text required'
    ],
    sizeCharts:[],
    products:[]
  };

  const BLUEPRINTS = {
    clothing: {
      icon:'bx-t-shirt', name:'Clothing',
      groups:{
        colors:{type:'swatch', title:'Colors', items:[
          ['Red','#ef4444'],['Blue','#3b82f6'],['Black','#111827'],['White','#ffffff'],['Green','#10b981']
        ]},
        sizes:{type:'text', title:'Sizes', items:['XS','S','M','L','XL']},
        material:{type:'text', title:'Material', items:['Cotton','Polyester','Denim']},
        fit:{type:'text', title:'Fit', items:['Regular','Slim','Oversized']},
        sleeve:{type:'text', title:'Sleeve', items:['Short','Long','Sleeveless']},
        pattern:{type:'text', title:'Pattern', items:['Solid','Striped','Checked']},
        units:{type:'text', title:'Units', items:[...BASE.units]},
        brands:{type:'text', title:'Brands', items:['Nike','Adidas','H&M','Uniqlo']}
      },
      rules:[...BASE.rules, 'Video (mp4) allowed', 'PDP size chart visible'],
      attrSets:[
        {name:'T-Shirt Basic', attrs:['colors','sizes','material','fit','sleeve','pattern']},
        {name:'Hoodie', attrs:['colors','sizes','material','fit','sleeve']},
        {name:'Denim', attrs:['sizes','fit','material','pattern']}
      ],
      variantSets:[
        {name:'Color × Size', axes:['colors','sizes']},
        {name:'Color × Size × Sleeve', axes:['colors','sizes','sleeve']},
        {name:'Size × Pattern', axes:['sizes','pattern']}
      ],
      categories:[
        ['Clothing','Men','Tops'],
        ['Clothing','Women','Dresses'],
        ['Clothing','Kids','Tops']
      ],
      collections:['Essentials','Summer 24','New Arrivals','Clearance','Best Sellers'],
      filters:['Size','Color','Material','Fit','Sleeve','Pattern','Price','Brand','Availability'],
      sizeCharts:[
        {name:'T-Shirt (Men)', cols:['Size','Chest','Length','Shoulder','Sleeve'], rows:[
          ['XS',46,66,41,19],['S',48,70,43,20],['M',51,72,45,21],['L',54,74,47,22],['XL',57,76,49,23]
        ], unit:'cm', note:'Flat; ±1cm'},
        {name:'Denim (Inch)', cols:['Waist','Hip','Inseam'], rows:[
          ['28',36,30],['30',38,31],['32',40,32],['34',42,32],['36',44,33]
        ], unit:'inch'}
      ],
      products:[
        {name:'Classic Tee', price:14.99, img:'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?q=80&w=800', rating:4.6, variants:20, badge:'Hot'},
        {name:'Oversized Hoodie', price:39, img:'https://images.unsplash.com/photo-1516478177764-9fe5bd7e9717?q=80&w=800', rating:4.8, variants:12, badge:'New'},
        {name:'Slim Fit Denim', price:49, img:'https://images.unsplash.com/photo-1516826957135-700dedea698c?q=80&w=800', rating:4.4, variants:8},
        {name:'Cotton Polo', price:24, img:'https://images.unsplash.com/photo-1520975922171-9c0cac2ab6c4?q=80&w=800', rating:4.5, variants:10}
      ]
    },

    phone:{
      icon:'bx-mobile', name:'Phone',
      groups:{
        colors:{type:'swatch', title:'Colors', items:[['Black','#111827'],['Silver','#cbd5e1'],['Blue','#2563eb']]},
        storage:{type:'text', title:'Storage', items:['64GB','128GB','256GB']},
        ram:{type:'text', title:'RAM', items:['4GB','8GB','12GB']},
        units:{type:'text', title:'Units', items:['g','kg','mm','cm']},
        brands:{type:'text', title:'Brands', items:['Apple','Samsung','Xiaomi','OnePlus']}
      },
      rules:[...BASE.rules,'Per-unit IMEI/Serial capture','Warranty card scan'],
      attrSets:[
        {name:'Phone Matrix', attrs:['colors','storage','ram']},
        {name:'Color + Storage', attrs:['colors','storage']},
        {name:'Storage + RAM', attrs:['storage','ram']}
      ],
      variantSets:[
        {name:'Color × Storage × RAM', axes:['colors','storage','ram']},
        {name:'Color × Storage', axes:['colors','storage']},
        {name:'Storage × RAM', axes:['storage','ram']}
      ],
      categories:[['Electronics','Phones','Android'],['Electronics','Phones','iOS'],['Electronics','Accessories','Cables']],
      collections:['5G Phones','Budget under $300','Flagship','Best Cameras'],
      filters:['Brand','Color','Storage','RAM','Price','Warranty','Availability'],
      sizeCharts:[],
      products:[
        {name:'XPhone 13', price:699, img:'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800', rating:4.7, variants:9, badge:'Best'},
        {name:'Droid Max 9', price:499, img:'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?q=80&w=800', rating:4.5, variants:6},
        {name:'Pearl Mini', price:299, img:'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?q=80&w=800', rating:4.2, variants:3}
      ]
    },

    laptop:{
      icon:'bx-laptop', name:'Laptop',
      groups:{
        cpu:{type:'text', title:'CPU', items:['i5','i7','Ryzen 5','Ryzen 7']},
        ram:{type:'text', title:'RAM', items:['8GB','16GB','32GB']},
        storage:{type:'text', title:'Storage', items:['256GB SSD','512GB SSD','1TB SSD']},
        colors:{type:'swatch', title:'Colors', items:[['Silver','#cbd5e1'],['Space Gray','#6b7280']]},
        brands:{type:'text', title:'Brands', items:['Dell','HP','Lenovo','Apple']},
        units:{type:'text', title:'Units', items:['kg','g','cm','mm','inch']}
      },
      rules:[...BASE.rules,'OS License key field','Serial required'],
      attrSets:[
        {name:'Laptop Config', attrs:['cpu','ram','storage','colors']},
        {name:'Creator Setup', attrs:['cpu','ram','storage']},
        {name:'Business', attrs:['cpu','ram']}
      ],
      variantSets:[
        {name:'CPU × RAM × Storage × Color', axes:['cpu','ram','storage','colors']},
        {name:'RAM × Storage', axes:['ram','storage']},
        {name:'CPU × RAM', axes:['cpu','ram']}
      ],
      categories:[['Electronics','Laptops','Windows'],['Electronics','Laptops','Mac'],['Electronics','Accessories','Dock']],
      collections:['Ultrabook','Gaming','Under $1000','Creator'],
      filters:['Brand','CPU','RAM','Storage','GPU','Screen Size','Price'],
      sizeCharts:[],
      products:[
        {name:'UltraBook 14', price:999, img:'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=800', rating:4.6, variants:12},
        {name:'GamePro 15', price:1499, img:'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=800', rating:4.4, variants:8}
      ]
    },

    electronic:{
      icon:'bx-chip', name:'Electronic Item',
      groups:{
        colors:{type:'swatch', title:'Colors', items:[['Black','#111827'],['White','#ffffff']]},
        warranty:{type:'text', title:'Warranty', items:['6m','12m','24m']},
        units:{type:'text', title:'Units', items:['kg','g','cm','mm']},
        brands:{type:'text', title:'Brands', items:['Sony','Anker','TP-Link','JBL']}
      },
      rules:[...BASE.rules,'Compliance doc upload','RMA diagnostics'],
      attrSets:[
        {name:'Electronics Default', attrs:['colors','warranty']},
        {name:'Audio Basic', attrs:['colors']},
        {name:'Wearable', attrs:['colors','warranty']}
      ],
      variantSets:[
        {name:'Color × Warranty', axes:['colors','warranty']},
        {name:'Color only', axes:['colors']},
        {name:'Warranty only', axes:['warranty']}
      ],
      categories:[['Electronics','Audio','Speakers'],['Electronics','Smart Home','Plugs'],['Electronics','Wearables','Band']],
      collections:['Top Rated','Smart Home','Accessories'],
      filters:['Brand','Color','Warranty','Price','Availability'],
      sizeCharts:[],
      products:[
        {name:'Smart Speaker', price:79, img:'https://images.unsplash.com/photo-1518449954273-86b525c52a9f?q=80&w=800', rating:4.3, variants:2}
      ]
    },

    organic:{
      icon:'bx-leaf', name:'Organic Food',
      groups:{
        weight:{type:'text', title:'Pack Weight', items:['250g','500g','1kg']},
        origin:{type:'text', title:'Origin', items:['Local','Imported']},
        cert:{type:'text', title:'Certification', items:['USDA','EU Organic','BD Organic']},
        brands:{type:'text', title:'Brands', items:['Local Farm','Green Valley']},
        units:{type:'text', title:'Units', items:['g','kg','ml','L']}
      },
      rules:[...BASE.rules,'FEFO picking','Batch/Lot & Expiry'],
      attrSets:[
        {name:'Pack Options', attrs:['weight','origin','cert']},
        {name:'Weight + Origin', attrs:['weight','origin']},
        {name:'Certification', attrs:['cert']}
      ],
      variantSets:[
        {name:'Weight × Origin × Cert', axes:['weight','origin','cert']},
        {name:'Weight × Origin', axes:['weight','origin']},
        {name:'Weight only', axes:['weight']}
      ],
      categories:[['Grocery','Organic','Staples'],['Grocery','Fresh','Vegetables'],['Grocery','Oils','Cold Pressed']],
      collections:['Best Sellers','Gluten Free','Keto Friendly'],
      filters:['Weight','Origin','Certification','Price','Diet','Availability'],
      sizeCharts:[],
      products:[
        {name:'Organic Brown Rice', price:6.5, img:'https://images.unsplash.com/photo-1466637574441-749b8f19452f?q=80&w=800', rating:4.5, variants:3}
      ]
    },

    eyewear:{
      icon:'bx-glasses', name:'Eyewear',
      groups:{
        frame:{type:'swatch', title:'Frame Color', items:[['Black','#111827'],['Tortoise','#7c3e1d'],['Clear','#f1f5f9']]},
        lens:{type:'text', title:'Lens Type', items:['Plano','Prescription','Blue Light']},
        size:{type:'text', title:'Size', items:['Small','Medium','Large']},
        brands:{type:'text', title:'Brands', items:['RayOne','Optix','Sunway']},
        units:{type:'text', title:'Units', items:['mm','cm']}
      },
      rules:[...BASE.rules,'Prescription fields (PD/SPH/CYL/AXIS)','Lens job-card'],
      attrSets:[
        {name:'Glasses Config', attrs:['frame','lens','size']},
        {name:'Sunglass', attrs:['frame','size']},
        {name:'Blue-Light', attrs:['frame','lens']}
      ],
      variantSets:[
        {name:'Frame × Lens × Size', axes:['frame','lens','size']},
        {name:'Frame × Size', axes:['frame','size']},
        {name:'Lens × Size', axes:['lens','size']}
      ],
      categories:[['Eyewear','Optical','Men'],['Eyewear','Sunglasses','Women'],['Eyewear','Kids','Optical']],
      collections:['Optical','Sunglasses','Premium'],
      filters:['Frame Color','Lens Type','Size','Price','Brand'],
      sizeCharts:[
        {name:'Frame Size Guide (mm)', cols:['Size','A (Lens W)','B (Lens H)','Bridge','Temple'], rows:[
          ['Small',48,40,18,135],['Medium',50,42,19,140],['Large',52,44,20,145]
        ], unit:'mm'}
      ],
      products:[
        {name:'Aero Round', price:59, img:'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=800', rating:4.3, variants:9}
      ]
    },

    cosmetic:{
      icon:'bx-bowl-hot', name:'Cosmetic',
      groups:{
        shade:{type:'swatch', title:'Shade', items:[['Ivory','#f3e5d8'],['Beige','#e8c8a8'],['Honey','#d7a86e'],['Mocha','#7b4a3a']]},
        finish:{type:'text', title:'Finish', items:['Matte','Dewy','Satin']},
        volume:{type:'text', title:'Volume', items:['15ml','30ml','50ml']},
        brands:{type:'text', title:'Brands', items:['GlowCo','PureSkin']},
        units:{type:'text', title:'Units', items:['ml','g']}
      },
      rules:[...BASE.rules,'PAO/Expiry','INCI ingredients'],
      attrSets:[
        {name:'Shade Matrix', attrs:['shade','finish','volume']},
        {name:'Shade + Finish', attrs:['shade','finish']},
        {name:'Volume Only', attrs:['volume']}
      ],
      variantSets:[
        {name:'Shade × Finish × Volume', axes:['shade','finish','volume']},
        {name:'Shade × Finish', axes:['shade','finish']},
        {name:'Shade × Volume', axes:['shade','volume']}
      ],
      categories:[['Beauty','Face','Foundation'],['Beauty','Lips','Lipstick'],['Beauty','Face','Primer']],
      collections:['Vegan & CF','New Shades','Under $20'],
      filters:['Shade','Finish','Coverage','Volume','Price','Brand'],
      sizeCharts:[],
      products:[
        {name:'Silk Foundation', price:18, img:'https://images.unsplash.com/photo-1512207853169-5bf3f0c20374?q=80&w=800', rating:4.6, variants:24}
      ]
    },

    gadget:{
      icon:'bx-joystick', name:'Gadget',
      groups:{
        colors:{type:'swatch', title:'Colors', items:[['Black','#111827'],['Red','#ef4444']]},
        edition:{type:'text', title:'Edition', items:['Standard','Pro','Limited']},
        brands:{type:'text', title:'Brands', items:['Gizmo','Techly']},
        units:{type:'text', title:'Units', items:['g','kg','mm','cm']}
      },
      rules:[...BASE.rules,'Simple warranty','Bundle builder ready'],
      attrSets:[
        {name:'Gadget Options', attrs:['colors','edition']},
        {name:'Color Only', attrs:['colors']},
        {name:'Edition Only', attrs:['edition']}
      ],
      variantSets:[
        {name:'Color × Edition', axes:['colors','edition']},
        {name:'Color only', axes:['colors']},
        {name:'Edition only', axes:['edition']}
      ],
      categories:[['Gadget','Desk','Hubs'],['Gadget','Outdoors','Drone'],['Gadget','Tags','Smart']],
      collections:['Cool Tech','Desk Setup','Travel'],
      filters:['Color','Edition','Price','Brand','Availability'],
      sizeCharts:[],
      products:[
        {name:'Desk Hub Pro', price:39, img:'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?q=80&w=800', rating:4.4, variants:3}
      ]
    },

    gift:{
      icon:'bx-gift', name:'Gift Item',
      groups:{
        wrap:{type:'text', title:'Gift Wrap', items:['Classic','Festive','Minimal']},
        brands:{type:'text', title:'Brands', items:['Giftify','WishBox']},
        units:{type:'text', title:'Units', items:['cm','inch']}
      },
      rules:[...BASE.rules,'Gift message on packing slip','No-price invoice'],
      attrSets:[
        {name:'Gift Options', attrs:['wrap']},
        {name:'Wrap + Brand', attrs:['wrap','brands']},
        {name:'Wrap Only', attrs:['wrap']}
      ],
      variantSets:[
        {name:'Wrap', axes:['wrap']},
        {name:'Wrap × Brand', axes:['wrap','brands']},
        {name:'Wrap (Alt)', axes:['wrap']}
      ],
      categories:[['Gifts','Occasion','Birthday'],['Gifts','Recipient','For Her'],['Gifts','Corporate','Bulk']],
      collections:['For Her','For Him','Corporate'],
      filters:['Occasion','Recipient','Wrap','Price','Availability'],
      sizeCharts:[],
      products:[
        {name:'Scented Candle Set', price:25, img:'https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=800', rating:4.7, variants:3}
      ]
    },

    sports:{
      icon:'bx-football', name:'Sports Item',
      groups:{
        colors:{type:'swatch', title:'Colors', items:[['Black','#111827'],['White','#ffffff'],['Blue','#2563eb'],['Red','#ef4444']]},
        sizes:{type:'text', title:'Sizes', items:['S','M','L','XL']},
        material:{type:'text', title:'Material', items:['Polyester','Nylon','Cotton']},
        brands:{type:'text', title:'Brands', items:['SportX','Athletica']},
        units:{type:'text', title:'Units', items:['cm','inch','g','kg']}
      },
      rules:[...BASE.rules,'Durability test note','Warranty (6m)'],
      attrSets:[
        {name:'Jersey', attrs:['colors','sizes','material']},
        {name:'Ball', attrs:['sizes','colors']},
        {name:'Accessories', attrs:['colors']}
      ],
      variantSets:[
        {name:'Color × Size', axes:['colors','sizes']},
        {name:'Size only', axes:['sizes']},
        {name:'Color only', axes:['colors']}
      ],
      categories:[['Sports','Football','Jersey'],['Sports','Cricket','Bat'],['Sports','Fitness','Accessories']],
      collections:['Team Jerseys','Training','New In'],
      filters:['Size','Color','Material','Price','Brand'],
      sizeCharts:[
        {name:'Jersey Size', cols:['Size','Chest','Length'], rows:[['S',92,68],['M',98,71],['L',104,74],['XL',110,77]], unit:'cm'}
      ],
      products:[
        {name:'Pro Jersey', price:29, img:'https://images.unsplash.com/photo-1547343929-9c4b5431a83d?q=80&w=800', rating:4.5, variants:8}
      ]
    },

    adventure:{
      icon:'bx-compass', name:'Adventure Gear',
      groups:{
        colors:{type:'swatch', title:'Colors', items:[['Olive','#6b8e23'],['Black','#111827'],['Orange','#f97316']]},
        size:{type:'text', title:'Size', items:['S','M','L']},
        material:{type:'text', title:'Material', items:['Ripstop','Nylon','Gore-Tex']},
        brands:{type:'text', title:'Brands', items:['TrailPro','Alpine']},
        units:{type:'text', title:'Units', items:['cm','inch','g','kg']}
      },
      rules:[...BASE.rules,'IP rating capture','Load capacity field'],
      attrSets:[
        {name:'Backpack', attrs:['colors','size','material']},
        {name:'Jacket', attrs:['colors','size','material']},
        {name:'Tent', attrs:['colors','material']}
      ],
      variantSets:[
        {name:'Color × Size', axes:['colors','size']},
        {name:'Color only', axes:['colors']},
        {name:'Size only', axes:['size']}
      ],
      categories:[['Adventure','Camping','Tent'],['Adventure','Hiking','Backpack'],['Adventure','Apparel','Jacket']],
      collections:['Trekking','Camp Essentials','All Weather'],
      filters:['Color','Size','Material','Price','Brand'],
      sizeCharts:[
        {name:'Jacket Size', cols:['Size','Chest','Sleeve'], rows:[['S',92,60],['M',98,62],['L',104,64]], unit:'cm'}
      ],
      products:[
        {name:'Trail Jacket', price:89, img:'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?q=80&w=800', rating:4.6, variants:6}
      ]
    },

    animal:{
      icon:'bx-bone', name:'Animal Food & Accessories',
      groups:{
        flavor:{type:'text', title:'Flavor', items:['Chicken','Beef','Fish','Veg']},
        weight:{type:'text', title:'Pack Weight', items:['1kg','2kg','5kg']},
        type:{type:'text', title:'Type', items:['Dry','Wet','Treats','Accessory']},
        brands:{type:'text', title:'Brands', items:['PetCare','PawPrime']},
        units:{type:'text', title:'Units', items:['g','kg','L']}
      },
      rules:[...BASE.rules,'Batch & Expiry','Allergen note'],
      attrSets:[
        {name:'Food', attrs:['flavor','weight']},
        {name:'Treats', attrs:['flavor']},
        {name:'Accessories', attrs:['type','brands']}
      ],
      variantSets:[
        {name:'Flavor × Weight', axes:['flavor','weight']},
        {name:'Flavor only', axes:['flavor']},
        {name:'Weight only', axes:['weight']}
      ],
      categories:[['Pet','Dog','Food'],['Pet','Cat','Accessories'],['Pet','Bird','Treats']],
      collections:['Puppy','Adult','Sensitive'],
      filters:['Flavor','Weight','Type','Price','Brand'],
      sizeCharts:[],
      products:[
        {name:'Premium Dog Food 2kg', price:14, img:'https://images.unsplash.com/photo-1596495578065-6e0763fa1178?q=80&w=800', rating:4.4, variants:3}
      ]
    }
  };

  /* ======================== State & Storage ======================== */
  const LS_KEY='master_catalog_v1';
  let state = { biz:'clothing' };
  // load persisted changes
  const persisted = localStorage.getItem(LS_KEY);
  if(persisted){
    try{
      const saved = JSON.parse(persisted);
      Object.keys(BLUEPRINTS).forEach(k=>{
        if(saved[k]) BLUEPRINTS[k] = saved[k];
      });
      if(saved.__biz) state.biz=saved.__biz;
    }catch(e){}
  }
  function persist(){
    const obj = {...BLUEPRINTS, __biz:state.biz};
    localStorage.setItem(LS_KEY, JSON.stringify(obj));
  }

  /* ======================== Rendering ======================== */
  function renderTabs(){
    const wrap = $('#bizTabs'); wrap.innerHTML='';
    Object.entries(BLUEPRINTS).forEach(([key,conf])=>{
      const el=document.createElement('div');
      el.className='qb-wizard-tab'+(key===state.biz?' is-active':'');
      el.dataset.key=key;
      el.innerHTML=`<div class="qb-wizard-tab-icon"><i class="bx ${conf.icon}"></i></div><div><h6 class="mb-0">${conf.name}</h6><span class="small-muted">configure</span></div>`;
      el.onclick=()=>{ state.biz=key; persist(); renderAll(); };
      wrap.appendChild(el);
    });
  }

  // Col-1: Attributes & Variant (subcards)
  function renderAttrVariant(){
    const conf=BLUEPRINTS[state.biz]; const wrap=$('#attrVariantWrap'); wrap.innerHTML='';
    Object.entries(conf.groups).forEach(([gkey,grp])=>{
      const card=document.createElement('div'); card.className='card';
      const addBtn=`<button class="add-ico" data-add="group" data-gkey="${gkey}"><i class="bx bx-plus"></i></button>`;
      card.innerHTML=`
        <div class="card-h">
          <div><b>${grp.title}</b> <span class="badge-soft ms-1">${grp.items.length}</span></div>${addBtn}
        </div>
        <div class="card-b">
          <div class="hstack">
            ${grp.items.map(it=>{
              if(grp.type==='swatch'){ const [name,color]=it; return `<span class="chip"><span class="sw" style="background:${color}"></span>${name}</span>`; }
              return `<span class="chip">${it}</span>`;
            }).join('')}
          </div>
        </div>`;
      wrap.appendChild(card);
    });
  }

  function renderRules(){
    const conf=BLUEPRINTS[state.biz]; $('#rulesWrap').innerHTML = `
      <ul class="mb-0">${conf.rules.map(r=>`<li>${r}</li>`).join('')}</ul>`;
  }

  // Col-2
  function renderAttrSets(){
    const conf=BLUEPRINTS[state.biz];
    $('#attrSetCount').textContent = conf.attrSets.length;
    $('#attrSetsWrap').innerHTML = conf.attrSets.map(s=>`
      <div class="card mb-2">
        <div class="card-b">
          <div class="fw-semibold">${s.name}</div>
          <div class="hstack mt-1">${s.attrs.map(a=>`<span class="chip"><i class="bx bx-purchase-tag-alt"></i>${conf.groups[a]?.title || a}</span>`).join('')}</div>
        </div>
      </div>`).join('');
  }

  function renderVariantSets(){
    const conf=BLUEPRINTS[state.biz];
    $('#varSetCount').textContent = conf.variantSets.length;
    $('#variantSetsWrap').innerHTML = conf.variantSets.map(s=>`
      <div class="card mb-2">
        <div class="card-b">
          <div class="fw-semibold">${s.name}</div>
          <div class="hstack mt-1">${s.axes.map(a=>`<span class="chip"><i class="bx bx-dialpad"></i>${conf.groups[a]?.title || a}</span>`).join('')}</div>
        </div>
      </div>`).join('');
  }

  function renderCategories(){
    const conf=BLUEPRINTS[state.biz];
    const byRoot = {};
    conf.categories.forEach(([l1,l2,l3])=>{
      byRoot[l1] = byRoot[l1] || {};
      byRoot[l1][l2] = byRoot[l1][l2] || [];
      if(!byRoot[l1][l2].includes(l3)) byRoot[l1][l2].push(l3);
    });
    const html = Object.entries(byRoot).map(([l1,level2])=>{
      const l2html = Object.entries(level2).map(([l2,arr])=>`
        <li><b>${l2}</b><ul>${arr.map(l3=>`<li>${l3}</li>`).join('')}</ul></li>`).join('');
      return `<div class="card mb-2"><div class="card-b"><div class="fw-semibold">${l1}</div><ul class="mb-0 mt-1">${l2html}</ul></div></div>`;
    }).join('');
    $('#catWrap').innerHTML = html || '<div class="small-muted">No categories</div>';
  }

  function renderCollections(){ const conf=BLUEPRINTS[state.biz]; $('#colWrap').innerHTML = conf.collections.map(c=>`<span class="chip"><i class="bx bx-grid-alt"></i>${c}</span>`).join(''); }
  function renderFilters(){ const conf=BLUEPRINTS[state.biz]; $('#filterWrap').innerHTML = conf.filters.map(f=>`<span class="chip"><i class="bx bx-filter-alt"></i>${f}</span>`).join(''); }

  // Col-3
  function renderSizeCharts(){
    const conf=BLUEPRINTS[state.biz];
    const wrap=$('#sizeWrap'); wrap.innerHTML='';
    if(!conf.sizeCharts.length){ wrap.innerHTML='<div class="small-muted">No size charts for this business.</div>'; return; }
    conf.sizeCharts.forEach(sc=>{
      const tbl=document.createElement('div'); tbl.className='card mb-2';
      tbl.innerHTML = `<div class="card-h"><div><b>${sc.name}</b> ${sc.unit?`<span class="badge-soft ms-1">${sc.unit}</span>`:''}</div></div>
        <div class="card-b">
          <div class="table-responsive"><table class="table table-sm align-middle">
            <thead class="table-light"><tr>${sc.cols.map(c=>`<th>${c}</th>`).join('')}</tr></thead>
            <tbody>${sc.rows.map(r=>`<tr>${r.map(v=>`<td>${v}</td>`).join('')}</tr>`).join('')}</tbody>
          </table></div>
          ${sc.note?`<div class="small-muted">${sc.note}</div>`:''}
        </div>`;
      wrap.appendChild(tbl);
    });
  }

  function productCard(p){
    return `<div class="pcard">
      ${p.badge?`<span class="badge">${p.badge}</span>`:''}
      <img src="${p.img}" alt="">
      <div class="pbody">
        <div class="title">${p.name}</div>
        <div class="d-flex justify-content-between align-items-center mt-1">
          <span class="price">$${p.price}</span>
          <span class="small-muted"><i class="bx bxs-star rating"></i> ${p.rating||'4.5'}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <span class="badge-soft">${p.variants||1} variants</span>
          <div class="actbar">
            <button class="mini-btn"><i class="bx bx-show"></i></button>
            <button class="mini-btn"><i class="bx bx-heart"></i></button>
          </div>
        </div>
      </div>
    </div>`;
  }
  function renderProducts(){
    const conf=BLUEPRINTS[state.biz];
    const wrap=$('#prodWrap'); wrap.innerHTML = conf.products.map(productCard).join('') || '<div class="small-muted">No products</div>';
  }

  function renderAll(){
    renderTabs();
    renderAttrVariant();
    renderRules();
    renderAttrSets();
    renderVariantSets();
    renderCategories();
    renderCollections();
    renderFilters();
    renderSizeCharts();
    renderProducts();
    // bind add buttons (generic)
    $$('.add-ico').forEach(b=> b.onclick = onAddClick);
  }

  /* ======================== Add Modal (generic) ======================== */
  let addCtx = null;
  function onAddClick(e){
    const type = e.currentTarget.dataset.add;
    const conf=BLUEPRINTS[state.biz];
    addCtx = {type, biz:state.biz};
    let title='Add';
    let body='';
    if(type==='group'){
      const gkey = e.currentTarget.dataset.gkey; addCtx.gkey=gkey;
      const grp = conf.groups[gkey];
      title = `Add to ${grp.title}`;
      if(grp.type==='swatch'){
        body = `
          <div class="mb-2"><label class="form-label">Name</label><input id="fName" class="form-control" placeholder="e.g., Navy"></div>
          <div class="mb-2"><label class="form-label">Color</label><input id="fColor" type="color" class="form-control form-control-color" value="#3b82f6"></div>`;
      }else{
        body = `<div class="mb-2"><label class="form-label">Item</label><input id="fName" class="form-control" placeholder="Enter value"></div>`;
      }
    }
    else if(type==='rule'){
      title='Add Rule';
      body=`<div class="mb-2"><label class="form-label">Rule</label><input id="fRule" class="form-control" placeholder="Write rule text"></div>`;
    }
    else if(type==='attrset'){
      title='New Attribute Set';
      const list = Object.entries(conf.groups).map(([k,v])=>`<label class="chip"><input type="checkbox" class="form-check-input me-1" value="${k}"> ${v.title}</label>`).join('');
      body=`<div class="mb-2"><label class="form-label">Set Name</label><input id="fName" class="form-control" placeholder="e.g., Jacket Set"></div>
            <div><label class="form-label">Include attributes</label><div class="hstack">${list}</div></div>`;
    }
    else if(type==='variantset'){
      title='New Variant Set';
      const list = Object.entries(conf.groups).map(([k,v])=>`<label class="chip"><input type="checkbox" class="form-check-input me-1" value="${k}"> ${v.title}</label>`).join('');
      body=`<div class="mb-2"><label class="form-label">Variant Set Name</label><input id="fName" class="form-control" placeholder="e.g., Color × Size × Sleeve"></div>
            <div><label class="form-label">Axes</label><div class="hstack">${list}</div></div>`;
    }
    else if(type==='category'){
      title='Add 3-layer Category';
      body=`<div class="row g-2">
        <div class="col-md-4"><label class="form-label">Layer 1</label><input id="fL1" class="form-control" placeholder="e.g., Clothing"></div>
        <div class="col-md-4"><label class="form-label">Layer 2</label><input id="fL2" class="form-control" placeholder="e.g., Men"></div>
        <div class="col-md-4"><label class="form-label">Layer 3</label><input id="fL3" class="form-control" placeholder="e.g., Tops"></div>
      </div>`;
    }
    else if(type==='collection'){
      title='Add Collection';
      body=`<div class="mb-2"><label class="form-label">Collection Name</label><input id="fName" class="form-control" placeholder="e.g., Summer Drops"></div>`;
    }
    else if(type==='filter'){
      title='Add Filter/Facet';
      body=`<div class="mb-2"><label class="form-label">Facet Name</label><input id="fName" class="form-control" placeholder="e.g., Sleeve"></div>`;
    }
    else if(type==='sizechart'){
      title='Add Size Chart';
      body=`<div class="mb-2"><label class="form-label">Chart Name</label><input id="fName" class="form-control" placeholder="e.g., Hoodie (Men)"></div>
            <div class="mb-2"><label class="form-label">Unit</label><input id="fUnit" class="form-control" placeholder="cm / inch"></div>
            <div class="mb-2"><label class="form-label">Columns (comma)</label><input id="fCols" class="form-control" placeholder="Size,Chest,Length,Sleeve"></div>
            <div class="mb-2"><label class="form-label">Rows (CSV lines)</label>
              <textarea id="fRows" class="form-control" rows="4" placeholder="S,48,70,20&#10;M,51,72,21"></textarea></div>
            <div class="small-muted">কমা দিয়ে কলাম, প্রতিটি লাইনে একেকটা রো দিন।</div>`;
    }
    else if(type==='product'){
      title='Add Product';
      body=`<div class="row g-2">
        <div class="col-md-7"><label class="form-label">Title</label><input id="fTitle" class="form-control" placeholder="Product name"></div>
        <div class="col-md-5"><label class="form-label">Price</label><input id="fPrice" type="number" step="0.01" class="form-control" placeholder="0.00"></div>
        <div class="col-12"><label class="form-label">Image URL</label><input id="fImg" class="form-control" placeholder="https://..."></div>
        <div class="col-md-6"><label class="form-label">Badge (optional)</label><input id="fBadge" class="form-control" placeholder="New / Hot"></div>
        <div class="col-md-6"><label class="form-label">Variants</label><input id="fVar" type="number" class="form-control" value="1"></div>
      </div>`;
    }
    $('#amTitle').textContent = title;
    $('#amBody').innerHTML = body;
    $('#amSave').onclick = onSaveAdd;
    showModal('addModal');
  }

  function onSaveAdd(){
    const conf=BLUEPRINTS[state.biz];
    if(addCtx.type==='group'){
      const grp = conf.groups[addCtx.gkey];
      if(grp.type==='swatch'){
        const name=$('#fName').value.trim(); const color=$('#fColor').value;
        if(!name) return;
        grp.items.push([name,color]);
      }else{
        const name=$('#fName').value.trim(); if(!name) return;
        grp.items.push(name);
      }
      persist(); renderAttrVariant(); say('Added to '+grp.title);
    }
    else if(addCtx.type==='rule'){
      const val=$('#fRule').value.trim(); if(!val) return; conf.rules.push(val); persist(); renderRules(); say('Rule added');
    }
    else if(addCtx.type==='attrset'){
      const name=$('#fName').value.trim(); if(!name) return;
      const axes=[...$('#amBody').querySelectorAll('input[type=checkbox]:checked')].map(x=>x.value);
      conf.attrSets.push({name, attrs:axes}); persist(); renderAttrSets(); say('Attribute set added');
    }
    else if(addCtx.type==='variantset'){
      const name=$('#fName').value.trim(); if(!name) return;
      const axes=[...$('#amBody').querySelectorAll('input[type=checkbox]:checked')].map(x=>x.value);
      conf.variantSets.push({name, axes}); persist(); renderVariantSets(); say('Variant set added');
    }
    else if(addCtx.type==='category'){
      const l1=$('#fL1').value.trim(), l2=$('#fL2').value.trim(), l3=$('#fL3').value.trim();
      if(!l1||!l2||!l3) return;
      conf.categories.push([l1,l2,l3]); persist(); renderCategories(); say('Category added');
    }
    else if(addCtx.type==='collection'){
      const name=$('#fName').value.trim(); if(!name) return; conf.collections.push(name); persist(); renderCollections(); say('Collection added');
    }
    else if(addCtx.type==='filter'){
      const name=$('#fName').value.trim(); if(!name) return; conf.filters.push(name); persist(); renderFilters(); say('Filter added');
    }
    else if(addCtx.type==='sizechart'){
      const name=$('#fName').value.trim(); const unit=$('#fUnit').value.trim();
      const cols=$('#fCols').value.split(',').map(s=>s.trim()).filter(Boolean);
      const rows=$('#fRows').value.split('\n').map(line=>line.split(',').map(s=>s.trim())).filter(r=>r.length);
      if(!name||!cols.length||!rows.length) return;
      conf.sizeCharts.push({name, unit, cols, rows}); persist(); renderSizeCharts(); say('Size chart added');
    }
    else if(addCtx.type==='product'){
      const title=$('#fTitle').value.trim(); const price=parseFloat($('#fPrice').value||'0'); const img=$('#fImg').value.trim();
      const badge=$('#fBadge').value.trim(); const variants=parseInt($('#fVar').value||'1',10);
      if(!title||!img) return;
      conf.products.push({name:title, price, img, badge, variants, rating:4.5});
      persist(); renderProducts(); say('Product added');
    }
    bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
  }

  /* ======================== Export/Import/Clear ======================== */
  $('#btnExport').onclick=()=>{
    const blob=new Blob([JSON.stringify(BLUEPRINTS,null,2)],{type:'application/json'});
    const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download='master-catalog.json'; a.click(); URL.revokeObjectURL(a.href);
    say('Exported JSON');
  };
  $('#imp').addEventListener('change', (e)=>{
    const f=e.target.files?.[0]; if(!f) return;
    const r=new FileReader(); r.onload=ev=>{
      try{
        const obj=JSON.parse(ev.target.result);
        Object.keys(BLUEPRINTS).forEach(k=>{ if(obj[k]) BLUEPRINTS[k]=obj[k]; });
        persist(); renderAll(); say('Imported');
      }catch(err){ alert('Invalid JSON'); }
    }; r.readAsText(f);
  });
  $('#btnClear').onclick=()=>{ localStorage.removeItem(LS_KEY); say('Local storage cleared'); };

  /* ======================== Init ======================== */
  renderAll();
})();
</script>

@endpush
@endsection
