 <style>
        :root {
            --primary: 15, 98, 106;
            --radius: .6rem;
            --line: #e5e7eb;
            --muted: #6b7280
        }

        body {
            background: #f5f7fb
        }

        .qb-wizard-nav {
            display: flex;
            gap: .6rem;
            overflow: auto;
            padding: .6rem;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            background: #f8f9fa;
            margin-bottom: 1rem
        }

        .qb-wizard-tab {
            display: flex;
            gap: .6rem;
            align-items: center;
            padding: .55rem .85rem;
            border: 1px solid #e6e3ef;
            border-radius: .6rem;
            background: #fff;
            cursor: pointer;
            white-space: nowrap;
            transition: .2s
        }

        .qb-wizard-tab:hover {
            box-shadow: 0 1px 6px rgba(0, 0, 0, .08);
            transform: translateY(-1px)
        }

        .qb-wizard-tab.is-active {
            border-color: rgba(var(--primary), .7);
            box-shadow: 0 0 0 .15rem rgba(var(--primary), .1);
            background: rgba(var(--primary), .05)
        }

        .qb-wizard-tab-icon {
            font-size: 1.2rem;
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: .5rem;
            background: rgba(var(--primary), .12);
            color: rgba(var(--primary), 1)
        }

        .qb-wizard-tab.is-active .qb-wizard-tab-icon {
            background: rgba(var(--primary), 1);
            color: #fff
        }

        .panel {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius)
        }

        .panel-header {
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--line)
        }

        .panel-title {
            margin: 0;
            font-weight: 600
        }

        .panel-body {
            padding: 1rem
        }

        .small-muted {
            color: var(--muted);
            font-size: .875rem
        }

        .req {
            color: #ef4444
        }

        .btn-primary {
            background: rgba(var(--primary), 1);
            border: none
        }

        .table th,
        .table td {
            vertical-align: middle
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: .85rem;
            margin: 2px
        }

        .chip input[type=checkbox] {
            margin: 0
        }

        .thumb {
            width: 70px;
            height: 70px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            object-fit: cover
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 10px
        }

        .g-item {
            border: 1px dashed #e5e7eb;
            border-radius: 10px;
            padding: 8px;
            text-align: center;
            background: #fff
        }

        .g-item img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eef1f5
        }

        .g-item .form-check {
            margin-top: 6px
        }

        .drop {
            border: 2px dashed #dbe3ea;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            background: #fbfdff
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f4f8ff;
            border: 1px solid #d8e6ff;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: .8rem
        }

        .kbd {
            font-family: ui-monospace, Menlo, Monaco, Consolas, "Courier New", monospace;
            font-size: .8rem;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 2px 6px
        }

        .hidden {
            display: none !important
        }

        .tab-pane {
            display: none
        }

        .tab-pane.active {
            display: block
        }

        .vimg-col,
        .vimg-cell {
            min-width: 200px
        }

        .cat-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 4px 10px;
            margin: 2px
        }

        .cat-chip .badge {
            background: #eef2ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe
        }

        .btn-icon {
            padding: .25rem .45rem
        }
    </style>