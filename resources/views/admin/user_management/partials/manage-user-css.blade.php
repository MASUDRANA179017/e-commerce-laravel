<style>
   /*=========================================*/
   /* Shared Base Styles for ALL Cards
   /*=========================================*/
   [class*="qb-card-light-"] {
   display: flex;
   flex-direction: column;
   height: 100%;
   border-radius: 8px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
   overflow: hidden;
   transition: all 0.3s ease;
   background-color: rgb(var(--qbit-white));
   }
   [class*="qb-card-light-"]:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
   }
   [class*="qb-card-light-"] .card-header { padding: 1rem 1.25rem; }
   [class*="qb-card-light-"] .card-body { padding: 1.25rem; flex-grow: 1; }
   /* Typography */
   [class*="qb-card-light-"] h5 { margin: 0; font-size: 1.1rem; font-weight: 600; }
   [class*="qb-card-light-"] h6 { margin: 0 0 0.5rem 0; font-size: 1rem; font-weight: 600; color: rgb(var(--text-dark)); }
   [class*="qb-card-light-"] p { margin: 0; font-size: 0.9rem; line-height: 1.6; color: rgb(var(--text-muted)); }
   /*=========================================*/
   /* Individual Card Color Styles
   /*=========================================*/
   .qb-card-light-primary .card-header { background-color: rgba(var(--qbit-primary), 0.1); border-left: 4px solid rgb(var(--qbit-primary)); }
   .qb-card-light-primary .card-header h5 { color: rgb(var(--qbit-primary)); }
   .qb-card-light-secondary .card-header { background-color: rgba(var(--qbit-secondary), 0.1); border-left: 4px solid rgb(var(--qbit-secondary)); }
   .qb-card-light-secondary .card-header h5 { color: rgb(var(--qbit-secondary)); }
   .qb-card-light-success .card-header { background-color: rgba(var(--qbit-success), 0.1); border-left: 4px solid rgb(var(--qbit-success)); }
   .qb-card-light-success .card-header h5 { color: rgb(var(--qbit-success)); }
   .qb-card-light-danger .card-header { background-color: rgba(var(--qbit-danger), 0.1); border-left: 4px solid rgb(var(--qbit-danger)); }
   .qb-card-light-danger .card-header h5 { color: rgb(var(--qbit-danger)); }
   .qb-card-light-warning .card-header { background-color: rgba(var(--qbit-warning), 0.1); border-left: 4px solid rgb(var(--qbit-warning)); }
   .qb-card-light-warning .card-header h5 { color: rgb(var(--qbit-warning)); }
   .qb-card-light-info .card-header { background-color: rgba(var(--qbit-info), 0.1); border-left: 4px solid rgb(var(--qbit-info)); }
   .qb-card-light-info .card-header h5 { color: rgb(var(--qbit-info)); }
   .qb-card-light-dark .card-header { background-color: rgba(var(--qbit-dark), 0.1); border-left: 4px solid rgb(var(--qbit-dark)); }
   .qb-card-light-dark .card-header h5 { color: rgb(var(--qbit-dark)); }
   .qb-card-light-primary2 .card-header { background-color: rgba(var(--qbit-primary2), 0.1); border-left: 4px solid rgb(var(--qbit-primary2)); }
   .qb-card-light-primary2 .card-header h5 { color: rgb(var(--qbit-primary2)); }
   .qb-card-light-secondary2 .card-header { background-color: rgba(var(--qbit-secondary2), 0.1); border-left: 4px solid rgb(var(--qbit-secondary2)); }
   .qb-card-light-secondary2 .card-header h5 { color: rgb(var(--qbit-secondary2)); }
   .qb-card-light-success2 .card-header { background-color: rgba(var(--qbit-success2), 0.1); border-left: 4px solid rgb(var(--qbit-success2)); }
   .qb-card-light-success2 .card-header h5 { color: rgb(var(--qbit-success2)); }
   .qb-card-light-danger2 .card-header { background-color: rgba(var(--qbit-danger2), 0.1); border-left: 4px solid rgb(var(--qbit-danger2)); }
   .qb-card-light-danger2 .card-header h5 { color: rgb(var(--qbit-danger2)); }
   .qb-card-light-warning2 .card-header { background-color: rgba(var(--qbit-warning2), 0.1); border-left: 4px solid rgb(var(--qbit-warning2)); }
   .qb-card-light-warning2 .card-header h5 { color: rgb(var(--qbit-warning2)); }
   .qb-card-light-info2 .card-header { background-color: rgba(var(--qbit-info2), 0.1); border-left: 4px solid rgb(var(--qbit-info2)); }
   .qb-card-light-info2 .card-header h5 { color: rgb(var(--qbit-info2)); }
   .qb-card-light-dark2 .card-header { background-color: rgba(var(--qbit-dark2), 0.1); border-left: 4px solid rgb(var(--qbit-dark2)); }
   .qb-card-light-dark2 .card-header h5 { color: rgb(var(--qbit-dark2)); }
   .qb-card-light-purple .card-header { background-color: rgba(var(--qbit-base-purple), 0.1); border-left: 4px solid rgb(var(--qbit-base-purple)); }
   .qb-card-light-purple .card-header h5 { color: rgb(var(--qbit-base-purple)); }
   .qb-card-light-blue .card-header { background-color: rgba(var(--qbit-base-blue), 0.1); border-left: 4px solid rgb(var(--qbit-base-blue)); }
   .qb-card-light-blue .card-header h5 { color: rgb(var(--qbit-base-blue)); }
   .qb-card-light-light-orange .card-header { background-color: rgba(var(--qbit-base-light-orange), 0.1); border-left: 4px solid rgb(var(--qbit-base-light-orange)); }
   .qb-card-light-light-orange .card-header h5 { color: rgb(var(--qbit-base-light-orange)); }
   .qb-card-light-dark-orange .card-header { background-color: rgba(var(--qbit-base-dark-orange), 0.1); border-left: 4px solid rgb(var(--qbit-base-dark-orange)); }
   .qb-card-light-dark-orange .card-header h5 { color: rgb(var(--qbit-base-dark-orange)); }
   .form-check {
   display: flex!important;
   min-height: 1.5rem;
   padding-left: 1.5em;
   margin-bottom: .125rem;
   align-items: center!important;
   }
</style>
<style>
   :root{
   --primary: 15,98,106; --secondary: 98,98,98; --success:10,185,100; --danger:225,78,90; --warning:249,193,35; --info:65,150,250;
   --light:246,247,250; --dark:40,35,45; --white:255,255,255; --radius:.6rem; --shadow:0 0.1rem 0.5rem rgba(var(--dark),.1);
   }
   .qb-wizard-nav{display:flex;gap:.6rem;overflow-x:auto;padding:.6rem;border:1px solid #eee;border-radius:var(--radius);background:rgba(15,98,106,.05)}
   .qb-wizard-tab{display:flex;flex:1;gap:.75rem;align-items:center;padding:.6rem .9rem;border:1px solid #e6e3ef;border-radius:.6rem;background:#fff;cursor:pointer;white-space:nowrap;transition:.2s}
   .qb-wizard-tab:hover{box-shadow:var(--shadow)}
   .qb-wizard-tab.is-active{border-color:rgba(var(--primary),.7);box-shadow:0 0 0 .15rem rgba(var(--primary),.08)}
   .qb-wizard-tab-icon{font-size:1.5rem;width:40px;height:40px;display:grid;place-items:center;border-radius:.5rem;background:rgba(var(--primary),.12);color:rgba(var(--primary),1)}
   .qb-wizard-tab.is-active .qb-wizard-tab-icon{background:rgba(var(--primary),1);color:#fff}
   .qb-wizard-pane{display:none;padding-top:1.5rem}
   .qb-wizard-pane.is-active{display:block;animation:fadeIn 0.5s}
   @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
   .card-form input[readonly], .card-form textarea[readonly], .card-form select:disabled {background:#f8f9fa;cursor:not-allowed}
   .search-filter-container { background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
   .module-card { border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px; }
   .module-card .card-header { background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 15px 20px; }
   .module-card .card-header h3 { font-size: 1.1rem; margin: 0; display: flex; align-items: center; }
   .module-card .card-header h3 i { margin-right: 10px; }
   .permission-group { padding: 15px 20px; }
   .permission-item { display: flex; align-items: center; margin-bottom: 8px; }
   .permission-item .form-check-label { display: flex; justify-content: space-between; align-items: center; width: 100%;}
   .select-all-container { background-color: #e7f3ff; padding: 10px 20px; border-bottom: 1px solid #e0e0e0; }
   /* ---------- Permission module cards ---------- */
   .module-card{border:1px solid var(--border);border-radius:.8rem;overflow:hidden;background:#fff;box-shadow:var(--shadow)}
   .module-card .card-header{
   background:#fafbff;border-bottom:1px solid var(--border);padding:.75rem 1rem;
   display:flex;align-items:center;justify-content:space-between
   }
   .module-card .card-header h3{margin:0;font-size:1rem;font-weight:700;color:#2c2f4a;display:flex;align-items:center;gap:.5rem}
   .module-card .card-header .form-check{margin:0}
   .permission-group{padding:.75rem 1rem;display:grid;grid-template-columns:1fr;gap:.55rem}
   .permission-item{display:flex;align-items:center;justify-content:space-between;border:1px dashed #eef0f5;border-radius:.6rem;padding:.55rem .7rem;background:#fcfdff}
   .permission-item .form-check{display:flex;align-items:center;gap:.5rem;margin:0}
   .permission-description{font-size:.78rem;color:#768}
   /* table tweaks */
   .table thead th{white-space:nowrap}
   .form-check-input{
   margin-top: 0!important;
   }
</style>