    <style>
        :root {
            --qbit-primary: 15, 98, 106;
            --qbit-secondary: 98, 98, 98;
            --qbit-success: 10, 185, 100;
            --qbit-danger: 225, 78, 90;
            --qbit-info: 65, 150, 250;
            --qbit-warning: 249, 193, 35;
            --qbit-dark: 73, 80, 87;
            --qbit-white: 255, 255, 255;
            --qbit-base-purple: 74, 42, 133;
            --qbit-base-blue: 19, 184, 237;
            --qbit-base-light-orange: 249, 174, 47;
            --qbit-base-dark-orange: 235, 92, 46;
        }

        /* --- Base Button Class --- */
        .qbit-btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            border: 1px solid transparent;
            border-radius: 5px;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .btn-sm {
            padding: 5px 15px;
            font-size: 11px;
            line-height: 10px;
        }

        /* --- Button Color Styles --- */
        .qbit-btn-light-primary {
            background-color: rgba(var(--qbit-primary), 0.1);
            color: rgba(var(--qbit-primary), 0.8);
        }

        .qbit-btn-light-primary:hover {
            background-color: rgba(var(--qbit-primary), 0.3);
            border-color: rgba(var(--qbit-primary), 0.2);
            color: rgba(var(--qbit-primary), 1);
        }

        .qbit-btn-light-secondary {
            background-color: rgba(var(--qbit-secondary), 0.1);
            color: rgba(var(--qbit-secondary), 0.8);
        }

        .qbit-btn-light-secondary:hover {
            background-color: rgba(var(--qbit-secondary), 0.3);
            border-color: rgba(var(--qbit-secondary), 0.2);
            color: rgba(var(--qbit-secondary), 1);
        }

        .qbit-btn-light-success {
            background-color: rgba(var(--qbit-success), 0.1);
            color: rgba(var(--qbit-success), 0.8);
        }

        .qbit-btn-light-success:hover {
            background-color: rgba(var(--qbit-success), 0.3);
            border-color: rgba(var(--qbit-success), 0.2);
            color: rgba(var(--qbit-success), 1);
        }

        .qbit-btn-light-danger {
            background-color: rgba(var(--qbit-danger), 0.1);
            color: rgba(var(--qbit-danger), 0.8);
        }

        .qbit-btn-light-danger:hover {
            background-color: rgba(var(--qbit-danger), 0.3);
            border-color: rgba(var(--qbit-danger), 0.2);
            color: rgba(var(--qbit-danger), 1);
        }

        /* --- Card Styles --- */
        .card {
            border: 0 !important;
            border-radius: 10px !important;
            margin-bottom: 20px !important;
            box-shadow: 0 4px 20px 1px #0000000f, 0 1px 4px #00000014 !important;
        }

        .card:hover {
            box-shadow: 0px 0px 4px 2px rgba(0, 0, 0, .1) !important;
        }

        [class*="card-light-"] {
            display: flex;
            flex-direction: column;
            height: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            background-color: rgb(var(--qbit-white));
        }

        [class*="card-light-"] .card-header {
            padding: 10px 15px;
        }

        [class*="card-light-"] .card-body {
            padding: 15px;
            flex-grow: 1;
        }

        .card-light-purple .card-header {
            background-color: rgba(var(--qbit-base-purple), 0.05);
            border-left: 4px solid rgb(var(--qbit-base-purple));
        }

        .card-light-purple .card-header h5 {
            color: rgb(var(--qbit-base-purple));
        }

        .card-light-danger .card-header {
            background-color: rgba(var(--qbit-danger), 0.05);
            border-left: 4px solid rgb(var(--qbit-danger));
        }

        .card-light-danger .card-header h5 {
            color: rgb(var(--qbit-danger));
        }

        .card-light-info .card-header {
            background-color: rgba(var(--qbit-info), 0.05);
            border-left: 4px solid rgb(var(--qbit-info));
        }

        .card-light-info .card-header h5 {
            color: rgb(var(--qbit-info));
        }

        .card-light-success .card-header {
            background-color: rgba(var(--qbit-success), 0.05);
            border-left: 4px solid rgb(var(--qbit-success));
        }

        .card-light-success .card-header h5 {
            color: rgb(var(--qbit-success));
        }

        .card-light-warning .card-header {
            background-color: rgba(var(--qbit-warning), 0.05);
            border-left: 4px solid rgb(var(--qbit-warning));
        }

        .card-light-warning .card-header h5 {
            color: rgb(var(--qbit-warning));
        }

        .custom-card {
            background-color: rgb(var(--qbit-white));
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .custom-card__body {
            padding: 1.25rem;
            padding-top: 1rem;
        }

        /* --- Card Title --- */
        .qb-card-title-sm {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 18px !important;
            font-weight: 500 !important;
            line-height: 22px !important;
            color: rgb(var(--qbit-base-purple)) !important;
        }

        .qb-card-title-xs {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            line-height: 22px !important;
            color: rgb(var(--qbit-base-purple)) !important;
        }

        /* --- Horizontal Tabs --- */
        .qb-wizard-nav {
            display: flex;
            gap: 10px;
            padding: 7px;
            border-radius: 0.5rem;
            background-color: rgba(var(--qbit-base-purple), 0.05);
            border: 1px solid rgba(var(--qbit-base-purple), 0.25);
        }

        .qb-wizard-tab {
            display: flex;
            align-items: center;
            width: 25%;
            /* Adjusted from 20% to 25% for 4 tabs */
            padding: 7px;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: 1px solid transparent;
        }

        .qb-wizard-tab:hover {
            background-color: rgba(var(--qbit-base-purple), 0.1);
        }

        .qb-wizard-tab-icon {
            height: 40px;
            width: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 25px;
            border-radius: 5px;
            margin-right: 10px;
            background-color: rgba(var(--qbit-secondary), 0.1);
            color: rgb(var(--qbit-base-purple));
            transition: all 0.3s ease;
        }

        .qb-wizard-tab h6 {
            margin-bottom: 0;
            font-weight: 600;
            color: #495057;
            transition: color 0.3s ease;
        }

        .qb-wizard-tab span {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .qb-wizard-tab.is-active {
            background-color: rgba(var(--qbit-white), 1);
            border-color: rgba(var(--qbit-primary), 0.2);
        }

        .qb-wizard-tab.is-active .qb-wizard-tab-icon {
            background-color: rgb(var(--qbit-primary));
            color: rgb(var(--qbit-white));
        }

        .qb-wizard-tab.is-active h6 {
            color: rgb(var(--qbit-primary));
        }

        .qb-wizard-pane {
            display: none;
            padding: 0;
            min-height: 200px;
            margin-top: 20px;
        }

        .qb-wizard-pane.is-active {
            display: block;
        }

        /* --- Text & Link Utilities --- */
        .link-sm {
            font-size: 12.5px !important;
            font-weight: 400 !important;
            color: #640D5F !important;
            line-height: 15px !important;
            margin: 0 !important;
            transition: all 0.2s ease-in-out !important;
        }

        .link-sm:hover {
            color: #000 !important;
        }

        .qb-text-light {
            color: #6c757d;
            /* A generic light text color */
        }

        .qb-text-danger {
            color: rgb(var(--qbit-danger)) !important;
        }

        .qb-text-success {
            color: rgb(var(--qbit-success)) !important;
        }

        .qb-text-info {
            color: rgb(var(--qbit-info)) !important;
        }

        .qb-text-primary {
            color: rgb(var(--qbit-primary)) !important;
        }
    </style>