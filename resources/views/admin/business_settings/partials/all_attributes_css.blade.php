<style>
  :root { --primary: 15,98,106; --radius:.6rem; --line:#e5e7eb; --shadow-sm:0 1px 2px rgba(0,0,0,.05); --vh-offset:190px; }
  body{background:#f9fafb}

  /* Common */
  .panel{background:#fff;border:1px solid var(--line);border-radius:var(--radius)}
  .panel-header{padding:.75rem 1rem;border-bottom:1px solid var(--line); cursor: default;}
  .panel-title{font-size:1.05rem;font-weight:600;margin:0}
  .panel-body{padding:1rem}
  .btn-primary{background:rgba(var(--primary),1);border:none;color:#fff;border-radius:.5rem;padding:.45rem .75rem}
  .btn-icon{background:#fff;border:1px solid #e6e3ef;border-radius:.5rem;width:32px;height:32px;display:inline-grid;place-items:center;color:#4b5563}
  .small-muted{color:#6b7280;font-size:.86rem}
  .badge{display:inline-flex;align-items:center;gap:.35rem;border-radius:999px;font-size:.75rem;padding:.2rem .55rem;border:1px solid #e0e2e7;background:#f8f9fa}

  /* Left Column: Attribute Pills */
  .source-card{border:1px solid #e9ecef;border-radius:12px;padding:14px;background:#fff;margin-bottom:1rem;box-shadow:var(--shadow-sm)}
  .attr-head{display:flex;justify-content:space-between;gap:10px;align-items:center}
  .attr-name{font-weight:600}
  .initial-msg{ text-align: center; color: #6b7280; padding: 3rem 1rem; background: #f8f9fa; border-radius: var(--radius); }
  .pills-container{padding-top:.8rem;display:flex;flex-direction:column;gap:8px}
  .attr-pill{border-radius:12px;background:#f8f9fa;border:1px solid #dee2e6;padding:5px;display:flex;align-items:center;gap:6px; user-select:none;}
  .attr-pill.is-draggable{cursor:grab}
  .attr-pill.is-draggable:active{cursor:grabbing}
  .attr-pill .view-state{display:flex;align-items:center;gap:6px;width:100%;padding: 3px;}
  .attr-pill .view-state .pill-name{flex-grow:1;padding-left:8px;font-size:.9rem}
  .attr-pill .view-state .pill-icon{width:20px;height:20px;border-radius:50%;background:#e9ecef;display:inline-block;border:1px solid #dee2e6}
  .attr-pill .view-state .pill-icon.has-color{border:1px solid rgba(0,0,0,0.1)}
  .attr-pill .view-state .pill-actions{display:flex;gap:4px}
  .attr-pill .view-state .pill-actions .btn{padding:.2rem .4rem;border-radius:.4rem}
  .attr-pill .edit-state{width:100%;padding: 8px;}
  .form-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(100px, 1fr));gap:8px;align-items:end}
  .form-grid > div { min-width: 0; }
  .attr-pill .edit-state .form-control-sm{font-size:.8rem;padding:.3rem .4rem;border-radius:.4rem}
  .attr-pill .edit-state .edit-actions{display:flex;gap:4px;margin-top:8px;justify-content:flex-end}
  .attr-pill .edit-state .btn-save{background:#198754;color:#fff}
  .attr-pill .edit-state .btn-cancel{background:#6c757d;color:#fff}
  .new-attr-btn-wrap{margin-top:12px;border-top:1px solid #f1f3f5;padding-top:12px}

  /* Right Side: Global Drop Zone */
  .drop-wrap{border:1px dashed #e5e7eb;border-radius:var(--radius);padding:10px;background:#fff;margin-bottom:12px}
  .drop-zone{min-height:100px;display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;border:2px dashed var(--line);border-radius:var(--radius);background:#fdfdff}
  .drop-zone.drag-over{background:rgba(var(--primary),.05);border-color:rgba(var(--primary),.3)}
  .placeholder{display:flex;align-items:center;gap:14px;color:#9ca3af;flex-wrap:wrap;padding:10px;text-align:left}
  .placeholder .ph-icon{font-size:2rem;opacity:.9}
  .placeholder .ph-text{display:flex;flex-direction:column;gap:4px}
  .placeholder .ph-text .title{font-weight:600;color:#6b7280}
  .placeholder .ph-text ul{margin:0 0 0 1rem;padding:0;color:#8a94a6;font-size:.9rem}

  /* Right Side: Set Card */
  .set-card{border:1px solid #e9ecef;border-radius:12px;background:#fff;margin-bottom:1rem;overflow:hidden}
  .set-card .panel-header { cursor: grab; }
  .set-title h5{margin:0}
  .set-title input{max-width:260px}
  .set-dz{border:2px dashed var(--line);border-radius:var(--radius);padding:10px 12px;margin:10px;display:flex;align-items:center;gap:8px;color:#9ca3af;background:#fdfdff; justify-content: center;}
  .set-dz.drag-over{background:rgba(var(--primary),.05);border-color:rgba(var(--primary),.3)}
  .set-dz i{font-size:1.2rem}
  
  .table th,.table td{ vertical-align: middle; padding: 10px 12px; font-size:.9rem;}
  .table thead th { font-size:.8rem; text-transform: uppercase; }
  .table .attr-type-badge{font-size: 0.7rem; padding: 0.15rem 0.4rem; border-radius: 4px; color: #fff; }
  .table .swatch-icon{ width:18px; height:18px; border-radius: 50%; display: inline-block; border: 1px solid #ccc; margin-right: 5px; vertical-align: middle;}
  .drag-handle{cursor:grab}

  /* Sortable JS helpers */
  .sortable-ghost{ background: rgba(var(--primary), .1) !important; border: 1px dashed rgba(var(--primary), .5) !important; }
  .sortable-ghost td { color: transparent; }
  .sortable-ghost td::before { content: "Drop here"; color: rgba(var(--primary), 1); font-weight: bold; }
  
  /* Scrollable columns & other styles */
  .scroll-col{max-height:calc(100dvh - var(--vh-offset));overflow:auto;padding-right:.3rem}
  .scroll-col::-webkit-scrollbar{width:10px;height:10px}
  .scroll-col::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:999px;border:3px solid #fff}
</style>