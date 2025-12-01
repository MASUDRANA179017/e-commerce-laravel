<style>
    :root {
        --primary: 15, 98, 106;
        --radius: .6rem;
        --line: #e5e7eb;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, .05);
        --vh-offset: 190px;
    }

    body {
        background: #f9fafb
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
        font-size: 1.05rem;
        font-weight: 600;
        margin: 0
    }

    .panel-body {
        padding: 1rem
    }

    .btn-primary {
        background: rgba(var(--primary), 1);
        border: none;
        color: #fff;
        border-radius: .5rem;
        padding: .45rem .75rem
    }

    .btn-icon {
        background: #fff;
        border: 1px solid #e6e3ef;
        border-radius: .5rem;
        width: 32px;
        height: 32px;
        display: inline-grid;
        place-items: center;
        color: #4b5563
    }

    .source-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 14px;
        background: #fff;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-sm)
    }

    .attr-head {
        display: flex;
        justify-content: space-between;
        gap: 10px
    }

    .chips {
        padding-top: .6rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px
    }

    .chip {
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #d1d5db;
        border-radius: 999px;
        background: #fff;
        padding: 6px 12px;
        font-size: .82rem;
        cursor: grab
    }

    .brand-logo {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        object-fit: cover
    }

    .drop-wrap {
        border: 1px dashed #e5e7eb;
        border-radius: var(--radius);
        padding: 10px;
        background: #fff;
        margin-bottom: 12px
    }

    .drop-zone {
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        border: 2px dashed var(--line);
        border-radius: var(--radius);
        background: #fdfdff
    }

    .placeholder {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #9ca3af;
        flex-wrap: wrap;
        padding: 10px
    }

    .placeholder .ph-icon {
        font-size: 2rem;
        opacity: .9
    }

    .table {
        width: 100%;
        border-collapse: collapse
    }

    .table th,
    .table td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #f2f3f5;
        vertical-align: middle
    }

    .table thead th {
        background: #fbfbfd;
        font-weight: 600;
        color: #374151
    }

    .scroll-col {
        max-height: calc(100dvh - var(--vh-offset));
        overflow: auto
    }

    .kbd {
        font-family: ui-monospace, Menlo, Monaco, "Courier New", monospace;
        font-size: .82rem;
        color: #b4235d
    }
</style>