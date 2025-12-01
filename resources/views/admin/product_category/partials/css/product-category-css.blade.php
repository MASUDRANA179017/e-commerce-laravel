    <style>
    .tree-item {
        margin: 3px 0;
        padding: 5px 10px;
        border: 1px solid #eee;
        border-radius: 5px;
        background: #f9f9f9;
    }
    .tree-children {
        margin-left: 20px;
        border-left: 1px dashed #ccc;
        padding-left: 10px;
    }
    .tree-actions button {
        margin-left: 5px;
    }
</style>

    
    
    <style>
        :root {
            --line: #e5e7eb;
            --rad: .65rem
        }

        body {
            background: #f9fafb
        }

        .card-round {
            border-radius: var(--rad);
            border: 1px solid var(--line)
        }

        .toolbar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: .85rem
        }

        .category-list .tree {
            list-style: none;
            margin: 0;
            padding-left: 0
        }

        .category-list .tree ul {
            list-style: none;
            margin: 8px 0 0 28px;
            padding-left: 16px;
            border-left: 1px dashed #e5e7eb
        }

        .category-item {
            background: linear-gradient(180deg, #fff, #fafafa);
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 12px;
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .02)
        }

        .category-item:hover {
            background: #f7f9ff;
            border-color: #e2e8f0
        }

        .cat-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0
        }

        .cat-title {
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 520px
        }

        .cat-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap
        }

        .badge-soft {
            background: #eef2ff;
            color: #3b82f6;
            border: 1px solid #dbeafe
        }

        .badge-order {
            background: #f8fafc;
            border: 1px solid #e2e8f0
        }

        .badge-pill-click {
            cursor: pointer;
            user-select: none
        }

        .badge-products {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #d1fae5
        }

        .badge-orders {
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #ffedd5
        }

        .badge-variants {
            background: #eef2ff;
            color: #1e40af;
            border: 1px solid #dbeafe
        }

        .node-toggle {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            background: #fff;
            cursor: pointer
        }

        .collapsed>ul {
            display: none
        }

        .thumb {
            width: 28px;
            height: 28px;
            object-fit: cover;
            border: 1px solid #e9ecef;
            border-radius: 6px
        }

        .sticky-tools {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 10px 0 0;
            z-index: 5
        }

        .search-empty {
            padding: 18px;
            text-align: center;
            color: #6b7280
        }

        .btn-xxs {
            padding: .2rem .45rem;
            font-size: .8rem
        }

        .list-unstyled {
            list-style: none;
            margin: 0;
            padding: 0
        }

        .v-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 2px 8px;
            margin: 2px 4px 0 0;
            font-size: .8rem;
            background: #fff
        }
    </style>
