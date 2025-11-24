<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Page Builder')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <style>
        :root {
            --sidebar-width: 280px;
            --settings-width: 320px;
            --header-height: 56px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
        
        /* Header */
        .builder-header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        /* Sidebar */
        .builder-sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            background: #fff;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            z-index: 100;
        }
        
        /* Settings Panel */
        .builder-settings {
            width: var(--settings-width);
            position: fixed;
            top: var(--header-height);
            right: 0;
            bottom: 0;
            background: #fff;
            border-left: 1px solid #dee2e6;
            overflow-y: auto;
            z-index: 100;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .builder-settings.active {
            transform: translateX(0);
        }
        
        /* Canvas */
        .builder-canvas {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 30px;
            min-height: calc(100vh - var(--header-height));
            transition: margin-right 0.3s ease;
        }
        
        .builder-canvas.settings-open {
            margin-right: var(--settings-width);
        }
        
        /* Canvas Inner - Web Page Preview */
        .canvas-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 40px rgba(0,0,0,0.1);
            min-height: 800px;
            position: relative;
        }
        
        /* Viewport Buttons */
        .viewport-btn {
            width: 36px;
            height: 36px;
            border: 1px solid #dee2e6;
            background: #fff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .viewport-btn:hover, .viewport-btn.active {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }
        
        /* Canvas Viewport Sizes */
        .canvas-wrapper.viewport-desktop {
            max-width: 1200px;
        }
        
        .canvas-wrapper.viewport-tablet {
            max-width: 768px;
        }
        
        .canvas-wrapper.viewport-mobile {
            max-width: 375px;
        }
        
        /* Widget Items in Sidebar */
        .widget-item {
            padding: 12px 16px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            cursor: grab;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .widget-item:hover {
            background: #e7f1ff;
            border-color: #0d6efd;
        }
        
        .widget-item:active {
            cursor: grabbing;
        }
        
        .widget-item i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        /* Section Styles */
        .builder-section {
            position: relative;
            border: 2px dashed transparent;
            transition: all 0.2s;
            min-height: 100px;
        }
        
        .builder-section:hover {
            border-color: #0d6efd;
        }
        
        .builder-section.selected {
            border-color: #0d6efd;
            background: rgba(13, 110, 253, 0.02);
        }
        
        /* Section Controls */
        .section-controls {
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%) translateY(-100%);
            display: none;
            gap: 4px;
            background: #0d6efd;
            padding: 4px 8px;
            border-radius: 6px 6px 0 0;
        }
        
        .builder-section:hover .section-controls {
            display: flex;
        }
        
        .section-controls .btn {
            padding: 4px 8px;
            font-size: 12px;
        }
        
        /* Column Styles */
        .builder-column {
            min-height: 80px;
            border: 2px dashed #dee2e6;
            border-radius: 4px;
            padding: 10px;
            transition: all 0.2s;
        }
        
        .builder-column:hover {
            border-color: #6c757d;
        }
        
        .builder-column.drag-over {
            background: #e7f1ff;
            border-color: #0d6efd;
        }
        
        /* Widget Styles */
        .builder-widget {
            position: relative;
            border: 2px solid transparent;
            border-radius: 4px;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .builder-widget:hover {
            border-color: #0d6efd;
        }
        
        .builder-widget.selected {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }
        
        /* Widget Controls */
        .widget-controls {
            position: absolute;
            top: 0;
            right: 0;
            transform: translateY(-100%);
            display: none;
            gap: 2px;
            padding: 4px;
            background: #0d6efd;
            border-radius: 4px 4px 0 0;
        }
        
        .builder-widget:hover .widget-controls,
        .builder-widget.selected .widget-controls {
            display: flex;
        }
        
        .widget-controls .btn {
            padding: 2px 6px;
            font-size: 11px;
        }
        
        /* Drag & Drop Styles */
        .sortable-ghost {
            opacity: 0.4;
            background: #e7f1ff !important;
        }
        
        .sortable-drag {
            background: white !important;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .widget-placeholder {
            border: 2px dashed #adb5bd;
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #6c757d;
            border-radius: 4px;
        }
        
        /* Settings Panel Styles */
        .settings-section {
            border-bottom: 1px solid #e9ecef;
            padding: 16px;
        }
        
        .settings-section:last-child {
            border-bottom: none;
        }
        
        .settings-section-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 12px;
        }
        
        /* Form Controls in Settings */
        .settings-row {
            margin-bottom: 12px;
        }
        
        .settings-row:last-child {
            margin-bottom: 0;
        }
        
        .settings-label {
            font-size: 13px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 4px;
        }
        
        /* Spacing Controls */
        .spacing-control {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            text-align: center;
        }
        
        .spacing-control input {
            width: 100%;
            text-align: center;
            padding: 4px;
            font-size: 12px;
        }
        
        .spacing-visual {
            display: grid;
            grid-template-areas: 
                ". top ."
                "left center right"
                ". bottom .";
            grid-template-columns: 1fr 2fr 1fr;
            grid-template-rows: auto 1fr auto;
            gap: 4px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .spacing-visual input {
            width: 100%;
            text-align: center;
            padding: 4px;
            font-size: 11px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .spacing-visual .spacing-top { grid-area: top; }
        .spacing-visual .spacing-right { grid-area: right; }
        .spacing-visual .spacing-bottom { grid-area: bottom; }
        .spacing-visual .spacing-left { grid-area: left; }
        .spacing-visual .spacing-center { 
            grid-area: center; 
            background: #dee2e6;
            border-radius: 4px;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #6c757d;
        }
        
        /* Color Picker */
        .color-picker-wrapper {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .color-picker-wrapper input[type="color"] {
            width: 40px;
            height: 32px;
            padding: 2px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .color-picker-wrapper input[type="text"] {
            flex: 1;
        }
        
        /* Add Section Button */
        .add-section-area {
            padding: 20px;
            text-align: center;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            margin: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .add-section-area:hover {
            border-color: #0d6efd;
            background: #f8f9fa;
        }
        
        /* Column Width Selector */
        .column-layout-selector {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .column-layout-option {
            flex: 1;
            min-width: 60px;
            padding: 8px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }
        
        .column-layout-option:hover {
            border-color: #0d6efd;
        }
        
        .column-layout-option.selected {
            border-color: #0d6efd;
            background: #e7f1ff;
        }
        
        .column-layout-preview {
            display: flex;
            gap: 2px;
            height: 20px;
            margin-bottom: 4px;
        }
        
        .column-layout-preview span {
            background: #0d6efd;
            border-radius: 2px;
            opacity: 0.5;
        }
        
        .column-layout-option:hover .column-layout-preview span,
        .column-layout-option.selected .column-layout-preview span {
            opacity: 1;
        }
        
        /* Empty Column State */
        .empty-column-message {
            color: #adb5bd;
            font-size: 13px;
            text-align: center;
            padding: 20px;
        }
        
        /* Scrollbar Styling */
        .builder-sidebar::-webkit-scrollbar,
        .builder-settings::-webkit-scrollbar {
            width: 6px;
        }
        
        .builder-sidebar::-webkit-scrollbar-track,
        .builder-settings::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .builder-sidebar::-webkit-scrollbar-thumb,
        .builder-settings::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .builder-sidebar::-webkit-scrollbar-thumb:hover,
        .builder-settings::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
