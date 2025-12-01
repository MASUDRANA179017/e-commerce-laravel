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

        .small-muted {
            color: #6b7280;
            font-size: .86rem
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            border-radius: 999px;
            font-size: .75rem;
            padding: .2rem .55rem;
            border: 1px solid #e0e2e7;
            background: #f8f9fa
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
            gap: 10px;
            align-items: center
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
            cursor: grab;
            user-select: none
        }

        .scroll-col {
            max-height: calc(100dvh - var(--vh-offset));
            overflow: auto
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

        .drop-zone.drag-over {
            background: rgba(var(--primary), .05);
            border-color: rgba(var(--primary), .3)
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

        .chart-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            margin-bottom: 1rem;
            overflow: hidden
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
            color: #374151;
            position: relative;
            padding-right: 28px;
        }

        .table thead th .col-title {
            cursor: pointer;
        }

        .table thead th .col-del {
            position: absolute;
            top: 50%;
            right: 4px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #dc3545;
            opacity: 0.6;
        }

        .table thead th .col-del:hover {
            opacity: 1;
        }

        .table td input {
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 4px 8px;
            width: 100%;
        }

        .img-wrap {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .img-thumb {
            width: 64px;
            height: 64px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            object-fit: cover;
            background: #fff
        }

        .d-none {
            display: none !important
        }

        .form-help {
            font-size: .8rem;
            color: #6c757d;
        }

        .modal-section-title {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: .5rem;
            font-size: 1rem;
        }

        #scLivePreview {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: .5rem;
        }
        /* put this in size-chart-css partial */
#scMeasurementsTable thead th { position: relative; padding-right: 28px; }
#scMeasurementsTable thead th .col-del {
  position: absolute; top: 50%; right: 4px; transform: translateY(-50%);
  cursor: pointer; color: #dc3545; opacity: .7;
}
#scMeasurementsTable thead th .col-del:hover { opacity: 1; }

    </style>