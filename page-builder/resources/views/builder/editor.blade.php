@extends('layouts.builder')

@section('title', $page->title . ' - Düzenle')

@section('content')
<!-- Header -->
<header class="builder-header d-flex align-items-center justify-content-between px-3">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('builder.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <input type="text" id="page-title" value="{{ $page->title }}" 
               class="form-control form-control-sm border-0 bg-transparent fw-semibold fs-5" 
               style="width: 250px;">
    </div>
    
    <!-- Viewport Switcher -->
    <div class="d-flex align-items-center gap-2">
        <div class="btn-group" role="group">
            <button type="button" class="viewport-btn active" data-viewport="desktop" title="Desktop">
                <i class="bi bi-display"></i>
            </button>
            <button type="button" class="viewport-btn" data-viewport="tablet" title="Tablet">
                <i class="bi bi-tablet"></i>
            </button>
            <button type="button" class="viewport-btn" data-viewport="mobile" title="Mobile">
                <i class="bi bi-phone"></i>
            </button>
        </div>
    </div>
    
    <div class="d-flex align-items-center gap-2">
        <!-- Template Dropdown -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-file-earmark-code me-1"></i>Template
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('builder.export', $page) }}">
                        <i class="bi bi-download me-2"></i>Export JSON
                    </a>
                </li>
                <li>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="bi bi-upload me-2"></i>Import JSON
                    </button>
                </li>
            </ul>
        </div>
        
        <a href="{{ route('builder.preview', $page) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-eye me-1"></i>Önizle
        </a>
        
        <button id="save-btn" class="btn btn-primary btn-sm">
            <i class="bi bi-check-lg me-1"></i>Kaydet
        </button>
    </div>
</header>

<!-- Left Sidebar - Widgets -->
<aside class="builder-sidebar">
    <div class="p-3">
        <!-- Widget List -->
        <div class="mb-4">
            <h6 class="text-muted text-uppercase small fw-semibold mb-3">
                <i class="bi bi-puzzle me-2"></i>Widget'lar
            </h6>
            <div id="widget-list" class="d-grid gap-2">
                <div class="widget-item" data-type="heading">
                    <i class="bi bi-type-h1 text-primary"></i>
                    <span>Başlık</span>
                </div>
                <div class="widget-item" data-type="text">
                    <i class="bi bi-text-paragraph text-success"></i>
                    <span>Metin</span>
                </div>
                <div class="widget-item" data-type="image">
                    <i class="bi bi-image text-purple" style="color: #6f42c1;"></i>
                    <span>Görsel</span>
                </div>
                <div class="widget-item" data-type="button">
                    <i class="bi bi-hand-index text-warning"></i>
                    <span>Buton</span>
                </div>
                <div class="widget-item" data-type="video">
                    <i class="bi bi-play-btn text-danger"></i>
                    <span>Video</span>
                </div>
                <div class="widget-item" data-type="divider">
                    <i class="bi bi-hr text-secondary"></i>
                    <span>Ayırıcı</span>
                </div>
                <div class="widget-item" data-type="spacer">
                    <i class="bi bi-arrows-expand text-secondary"></i>
                    <span>Boşluk</span>
                </div>
                <div class="widget-item" data-type="html">
                    <i class="bi bi-code-slash text-info"></i>
                    <span>HTML Kodu</span>
                </div>
            </div>
        </div>
        
        <hr>
        
        <!-- Structure -->
        <div class="mb-4">
            <h6 class="text-muted text-uppercase small fw-semibold mb-3">
                <i class="bi bi-layers me-2"></i>Yapı Elemanları
            </h6>
            <div class="d-grid gap-2">
                <button id="add-section-btn" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-2"></i>Yeni Section
                </button>
            </div>
        </div>
        
        <hr>
        
        <!-- Column Layouts -->
        <div>
            <h6 class="text-muted text-uppercase small fw-semibold mb-3">
                <i class="bi bi-layout-three-columns me-2"></i>Sütun Düzenleri
            </h6>
            <div class="column-layout-selector">
                <div class="column-layout-option" data-layout="12">
                    <div class="column-layout-preview">
                        <span style="flex: 1;"></span>
                    </div>
                    <small>1</small>
                </div>
                <div class="column-layout-option" data-layout="6-6">
                    <div class="column-layout-preview">
                        <span style="flex: 1;"></span>
                        <span style="flex: 1;"></span>
                    </div>
                    <small>1/2</small>
                </div>
                <div class="column-layout-option" data-layout="4-4-4">
                    <div class="column-layout-preview">
                        <span style="flex: 1;"></span>
                        <span style="flex: 1;"></span>
                        <span style="flex: 1;"></span>
                    </div>
                    <small>1/3</small>
                </div>
                <div class="column-layout-option" data-layout="3-3-3-3">
                    <div class="column-layout-preview">
                        <span style="flex: 1;"></span>
                        <span style="flex: 1;"></span>
                        <span style="flex: 1;"></span>
                        <span style="flex: 1;"></span>
                    </div>
                    <small>1/4</small>
                </div>
                <div class="column-layout-option" data-layout="4-8">
                    <div class="column-layout-preview">
                        <span style="flex: 1;"></span>
                        <span style="flex: 2;"></span>
                    </div>
                    <small>1/3 + 2/3</small>
                </div>
                <div class="column-layout-option" data-layout="8-4">
                    <div class="column-layout-preview">
                        <span style="flex: 2;"></span>
                        <span style="flex: 1;"></span>
                    </div>
                    <small>2/3 + 1/3</small>
                </div>
            </div>
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle me-1"></i>Bir section seçip düzen uygulayın
            </small>
        </div>
    </div>
</aside>

<!-- Canvas Area -->
<main class="builder-canvas" id="canvas-area">
    <div class="canvas-wrapper viewport-desktop" id="canvas">
        <!-- Sections will be rendered here -->
    </div>
</main>

<!-- Right Sidebar - Settings -->
<aside class="builder-settings" id="settings-panel">
    <div class="settings-header d-flex align-items-center justify-content-between p-3 border-bottom">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-gear me-2"></i>
            <span id="settings-title">Ayarlar</span>
        </h6>
        <button type="button" class="btn-close" id="close-settings"></button>
    </div>
    <div id="settings-content">
        <!-- Dynamic settings form -->
    </div>
</aside>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Template Import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('builder.import', $page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">JSON Dosyası Seçin</label>
                        <input type="file" name="template_file" accept=".json" class="form-control" required>
                    </div>
                    <div class="alert alert-warning small">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Mevcut içerik import edilen template ile değiştirilecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Import Et</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ============================================
    // GLOBAL STATE
    // ============================================
    let layoutData = {!! $layoutJson !!};
    let selectedElement = null;
    let selectedType = null; // 'section', 'column', 'widget'
    
    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    
    function generateId(prefix) {
        return prefix + '_' + Math.random().toString(36).substr(2, 9);
    }
    
    function buildStyleString(settings) {
        if (!settings) return '';
        
        const styleMap = {
            'backgroundColor': 'background-color',
            'background': 'background-color',
            'color': 'color',
            'fontSize': 'font-size',
            'fontWeight': 'font-weight',
            'textAlign': 'text-align',
            'lineHeight': 'line-height',
            'letterSpacing': 'letter-spacing',
            'paddingTop': 'padding-top',
            'paddingRight': 'padding-right',
            'paddingBottom': 'padding-bottom',
            'paddingLeft': 'padding-left',
            'marginTop': 'margin-top',
            'marginRight': 'margin-right',
            'marginBottom': 'margin-bottom',
            'marginLeft': 'margin-left',
            'borderRadius': 'border-radius',
            'borderWidth': 'border-width',
            'borderColor': 'border-color',
            'borderStyle': 'border-style',
            'width': 'width',
            'maxWidth': 'max-width',
            'minHeight': 'min-height',
            'height': 'height'
        };
        
        let styles = [];
        for (let key in styleMap) {
            if (settings[key] !== undefined && settings[key] !== '') {
                styles.push(`${styleMap[key]}: ${settings[key]}`);
            }
        }
        
        return styles.join('; ');
    }
    
    // ============================================
    // RENDER ENGINE
    // ============================================
    
    function renderCanvas() {
        let html = '';
        
        if (layoutData.length === 0) {
            html = `
                <div class="add-section-area" id="empty-canvas-add">
                    <i class="bi bi-plus-circle fs-1 text-muted mb-2 d-block"></i>
                    <p class="mb-0 text-muted">Başlamak için section ekleyin</p>
                </div>
            `;
        } else {
            layoutData.forEach((section, sIndex) => {
                html += renderSection(section, sIndex);
            });
            
            // Add section button at bottom
            html += `
                <div class="add-section-area mt-3" id="bottom-add-section">
                    <i class="bi bi-plus-lg me-2"></i>Section Ekle
                </div>
            `;
        }
        
        $('#canvas').html(html);
        initSortables();
    }
    
    function renderSection(section, sIndex) {
        const settings = section.settings || {};
        const style = buildStyleString(settings);
        const containerClass = settings.fullWidth ? 'container-fluid' : 'container';
        
        let columnsHtml = '';
        (section.columns || []).forEach((column, cIndex) => {
            columnsHtml += renderColumn(column, sIndex, cIndex);
        });
        
        return `
            <div class="builder-section" 
                 data-section-index="${sIndex}" 
                 data-id="${section.id}"
                 style="${style}">
                <div class="section-controls">
                    <button class="btn btn-light btn-sm section-move-up" title="Yukarı Taşı">
                        <i class="bi bi-chevron-up"></i>
                    </button>
                    <button class="btn btn-light btn-sm section-move-down" title="Aşağı Taşı">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <button class="btn btn-light btn-sm section-settings-btn" title="Ayarlar">
                        <i class="bi bi-gear"></i>
                    </button>
                    <button class="btn btn-light btn-sm section-duplicate" title="Kopyala">
                        <i class="bi bi-copy"></i>
                    </button>
                    <button class="btn btn-danger btn-sm section-delete" title="Sil">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="${containerClass}">
                    <div class="row g-3">
                        ${columnsHtml}
                    </div>
                </div>
            </div>
        `;
    }
    
    function renderColumn(column, sIndex, cIndex) {
        const colClass = column.class || 'col-12';
        
        let widgetsHtml = '';
        (column.widgets || []).forEach((widget, wIndex) => {
            widgetsHtml += renderWidget(widget, sIndex, cIndex, wIndex);
        });
        
        if (!widgetsHtml) {
            widgetsHtml = '<div class="empty-column-message"><i class="bi bi-plus-circle"></i><br>Widget bırakın</div>';
        }
        
        return `
            <div class="${colClass}">
                <div class="builder-column widgets-container"
                     data-section-index="${sIndex}"
                     data-col-index="${cIndex}"
                     data-id="${column.id}">
                    ${widgetsHtml}
                </div>
            </div>
        `;
    }
    
    function renderWidget(widget, sIndex, cIndex, wIndex) {
        const content = getWidgetPreview(widget);
        const settings = widget.settings || {};
        const style = buildStyleString(settings);
        
        return `
            <div class="builder-widget"
                 data-section-index="${sIndex}"
                 data-col-index="${cIndex}"
                 data-widget-index="${wIndex}"
                 data-type="${widget.type}"
                 data-id="${widget.id}"
                 style="${style}">
                <div class="widget-controls">
                    <button class="btn btn-light btn-sm widget-move-up" title="Yukarı">
                        <i class="bi bi-chevron-up"></i>
                    </button>
                    <button class="btn btn-light btn-sm widget-move-down" title="Aşağı">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <button class="btn btn-light btn-sm widget-settings-btn" title="Ayarlar">
                        <i class="bi bi-gear"></i>
                    </button>
                    <button class="btn btn-light btn-sm widget-duplicate" title="Kopyala">
                        <i class="bi bi-copy"></i>
                    </button>
                    <button class="btn btn-danger btn-sm widget-delete" title="Sil">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="widget-content">${content}</div>
            </div>
        `;
    }
    
    function getWidgetPreview(widget) {
        const settings = widget.settings || {};
        const content = widget.content || '';
        
        switch (widget.type) {
            case 'heading':
                const tag = settings.tag || 'h2';
                const headingStyle = buildStyleString({
                    color: settings.color,
                    fontSize: settings.fontSize,
                    textAlign: settings.textAlign,
                    fontWeight: settings.fontWeight
                });
                return `<${tag} style="${headingStyle}">${content || 'Başlık Metni'}</${tag}>`;
            
            case 'text':
                const textStyle = buildStyleString({
                    color: settings.color,
                    fontSize: settings.fontSize,
                    textAlign: settings.textAlign,
                    lineHeight: settings.lineHeight
                });
                return `<div style="${textStyle}">${content || '<p>Metin içeriğinizi buraya yazın...</p>'}</div>`;
            
            case 'image':
                const imgSrc = content || 'https://via.placeholder.com/800x400?text=Görsel+Seçin';
                const imgStyle = buildStyleString({
                    width: settings.width || '100%',
                    maxWidth: settings.maxWidth,
                    borderRadius: settings.borderRadius
                });
                return `<img src="${imgSrc}" alt="${settings.alt || 'Görsel'}" class="img-fluid" style="${imgStyle}">`;
            
            case 'button':
                const btnClass = settings.btnClass || 'btn-primary';
                const btnSize = settings.btnSize || '';
                const btnStyle = buildStyleString({
                    backgroundColor: settings.backgroundColor,
                    color: settings.color,
                    borderRadius: settings.borderRadius
                });
                const btnAlign = settings.textAlign ? `text-${settings.textAlign}` : '';
                return `<div class="${btnAlign}">
                    <a href="${settings.link || '#'}" class="btn ${btnClass} ${btnSize}" style="${btnStyle}">
                        ${content || 'Buton Metni'}
                    </a>
                </div>`;
            
            case 'video':
                if (content) {
                    // YouTube embed
                    const videoId = extractYouTubeId(content);
                    if (videoId) {
                        return `<div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/${videoId}" allowfullscreen></iframe>
                        </div>`;
                    }
                }
                return `<div class="ratio ratio-16x9 bg-dark d-flex align-items-center justify-content-center">
                    <div class="text-white text-center">
                        <i class="bi bi-play-circle fs-1"></i>
                        <p class="mb-0 mt-2">Video URL ekleyin</p>
                    </div>
                </div>`;
            
            case 'divider':
                const dividerStyle = buildStyleString({
                    borderColor: settings.color || '#dee2e6',
                    borderWidth: settings.thickness || '1px',
                    marginTop: settings.marginTop || '20px',
                    marginBottom: settings.marginBottom || '20px'
                });
                return `<hr style="${dividerStyle}; border-style: ${settings.style || 'solid'}">`;
            
            case 'spacer':
                const height = settings.height || '50px';
                return `<div style="height: ${height}; background: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(0,0,0,0.03) 5px, rgba(0,0,0,0.03) 10px);"></div>`;
            
            case 'html':
                return content || '<div class="text-muted text-center p-3"><i class="bi bi-code-slash"></i> HTML Kodu</div>';
            
            default:
                return `<div class="text-muted">[${widget.type}]</div>`;
        }
    }
    
    function extractYouTubeId(url) {
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const match = url.match(regex);
        return match ? match[1] : null;
    }
    
    // ============================================
    // SORTABLE INITIALIZATION
    // ============================================
    
    function initSortables() {
        // Widget list (sidebar)
        if (document.getElementById('widget-list')) {
            new Sortable(document.getElementById('widget-list'), {
                group: {
                    name: 'widgets',
                    pull: 'clone',
                    put: false
                },
                sort: false,
                animation: 150
            });
        }
        
        // Canvas columns
        document.querySelectorAll('.widgets-container').forEach(container => {
            new Sortable(container, {
                group: 'widgets',
                animation: 150,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onAdd: function(evt) {
                    const widgetType = evt.item.dataset.type;
                    if (!widgetType) return;
                    
                    const sectionIndex = parseInt(evt.to.dataset.sectionIndex);
                    const colIndex = parseInt(evt.to.dataset.colIndex);
                    
                    evt.item.remove();
                    addWidget(sectionIndex, colIndex, widgetType, evt.newIndex);
                },
                onEnd: function(evt) {
                    if (evt.from !== evt.to || evt.oldIndex !== evt.newIndex) {
                        reorderWidget(evt);
                    }
                }
            });
        });
    }
    
    // ============================================
    // DATA MANIPULATION
    // ============================================
    
    function addSection(layout = '12') {
        const columns = layout.split('-').map(size => ({
            id: generateId('col'),
            class: `col-md-${size}`,
            widgets: []
        }));
        
        const newSection = {
            id: generateId('section'),
            type: 'section',
            settings: {
                backgroundColor: '#ffffff',
                paddingTop: '60px',
                paddingBottom: '60px',
                fullWidth: false
            },
            columns: columns
        };
        
        layoutData.push(newSection);
        renderCanvas();
    }
    
    function addWidget(sectionIndex, colIndex, type, position = null) {
        const defaults = {
            heading: {
                content: 'Başlık Metni',
                settings: { tag: 'h2', color: '#212529', textAlign: 'left', fontSize: '', fontWeight: '600' }
            },
            text: {
                content: '<p>Buraya metin içeriğinizi yazın. Daha fazla bilgi ekleyebilir, formatlamalar yapabilirsiniz.</p>',
                settings: { color: '#495057', fontSize: '16px', lineHeight: '1.6', textAlign: 'left' }
            },
            image: {
                content: '',
                settings: { width: '100%', maxWidth: '', borderRadius: '0', alt: '' }
            },
            button: {
                content: 'Daha Fazla',
                settings: { link: '#', btnClass: 'btn-primary', btnSize: '', textAlign: 'left', borderRadius: '4px' }
            },
            video: {
                content: '',
                settings: {}
            },
            divider: {
                content: '',
                settings: { color: '#dee2e6', thickness: '1px', style: 'solid', marginTop: '20px', marginBottom: '20px' }
            },
            spacer: {
                content: '',
                settings: { height: '50px' }
            },
            html: {
                content: '<!-- HTML kodunuzu buraya yazın -->',
                settings: {}
            }
        };
        
        const defaultData = defaults[type] || { content: '', settings: {} };
        
        const newWidget = {
            id: generateId('widget'),
            type: type,
            content: defaultData.content,
            settings: { ...defaultData.settings }
        };
        
        const widgets = layoutData[sectionIndex].columns[colIndex].widgets;
        
        if (position !== null && position < widgets.length) {
            widgets.splice(position, 0, newWidget);
        } else {
            widgets.push(newWidget);
        }
        
        renderCanvas();
        
        // Open settings for new widget
        setTimeout(() => {
            openWidgetSettings(sectionIndex, colIndex, position !== null ? position : widgets.length - 1);
        }, 100);
    }
    
    function deleteWidget(sIndex, cIndex, wIndex) {
        layoutData[sIndex].columns[cIndex].widgets.splice(wIndex, 1);
        renderCanvas();
        closeSettings();
    }
    
    function duplicateWidget(sIndex, cIndex, wIndex) {
        const original = layoutData[sIndex].columns[cIndex].widgets[wIndex];
        const clone = JSON.parse(JSON.stringify(original));
        clone.id = generateId('widget');
        layoutData[sIndex].columns[cIndex].widgets.splice(wIndex + 1, 0, clone);
        renderCanvas();
    }
    
    function moveWidget(sIndex, cIndex, wIndex, direction) {
        const widgets = layoutData[sIndex].columns[cIndex].widgets;
        const newIndex = direction === 'up' ? wIndex - 1 : wIndex + 1;
        
        if (newIndex >= 0 && newIndex < widgets.length) {
            const temp = widgets[wIndex];
            widgets[wIndex] = widgets[newIndex];
            widgets[newIndex] = temp;
            renderCanvas();
        }
    }
    
    function deleteSection(sIndex) {
        layoutData.splice(sIndex, 1);
        renderCanvas();
        closeSettings();
    }
    
    function duplicateSection(sIndex) {
        const original = layoutData[sIndex];
        const clone = JSON.parse(JSON.stringify(original));
        clone.id = generateId('section');
        clone.columns.forEach(col => {
            col.id = generateId('col');
            col.widgets.forEach(w => w.id = generateId('widget'));
        });
        layoutData.splice(sIndex + 1, 0, clone);
        renderCanvas();
    }
    
    function moveSection(sIndex, direction) {
        const newIndex = direction === 'up' ? sIndex - 1 : sIndex + 1;
        
        if (newIndex >= 0 && newIndex < layoutData.length) {
            const temp = layoutData[sIndex];
            layoutData[sIndex] = layoutData[newIndex];
            layoutData[newIndex] = temp;
            renderCanvas();
        }
    }
    
    function applyColumnLayout(sIndex, layout) {
        const columns = layout.split('-').map(size => ({
            id: generateId('col'),
            class: `col-md-${size}`,
            widgets: []
        }));
        
        // Transfer widgets from old columns to new ones
        const oldWidgets = [];
        layoutData[sIndex].columns.forEach(col => {
            oldWidgets.push(...col.widgets);
        });
        
        // Distribute widgets to new columns
        oldWidgets.forEach((widget, i) => {
            const targetCol = i % columns.length;
            columns[targetCol].widgets.push(widget);
        });
        
        layoutData[sIndex].columns = columns;
        renderCanvas();
    }
    
    function reorderWidget(evt) {
        const fromSection = parseInt(evt.from.dataset.sectionIndex);
        const fromCol = parseInt(evt.from.dataset.colIndex);
        const toSection = parseInt(evt.to.dataset.sectionIndex);
        const toCol = parseInt(evt.to.dataset.colIndex);
        
        const widget = layoutData[fromSection].columns[fromCol].widgets.splice(evt.oldIndex, 1)[0];
        layoutData[toSection].columns[toCol].widgets.splice(evt.newIndex, 0, widget);
        
        renderCanvas();
    }
    
    // ============================================
    // SETTINGS PANEL
    // ============================================
    
    function openSettings() {
        $('#settings-panel').addClass('active');
        $('#canvas-area').addClass('settings-open');
    }
    
    function closeSettings() {
        $('#settings-panel').removeClass('active');
        $('#canvas-area').removeClass('settings-open');
        $('.builder-section, .builder-widget').removeClass('selected');
        selectedElement = null;
        selectedType = null;
    }
    
    function openWidgetSettings(sIndex, cIndex, wIndex) {
        const widget = layoutData[sIndex].columns[cIndex].widgets[wIndex];
        selectedElement = { sIndex, cIndex, wIndex };
        selectedType = 'widget';
        
        // Highlight selected
        $('.builder-widget, .builder-section').removeClass('selected');
        $(`.builder-widget[data-section-index="${sIndex}"][data-col-index="${cIndex}"][data-widget-index="${wIndex}"]`).addClass('selected');
        
        $('#settings-title').text(getWidgetTitle(widget.type));
        
        let html = `<form id="widget-settings-form">`;
        
        // Content Section
        html += `<div class="settings-section">
            <div class="settings-section-title">İçerik</div>`;
        
        switch (widget.type) {
            case 'heading':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Başlık Metni</label>
                        <input type="text" name="content" class="form-control form-control-sm" value="${escapeHtml(widget.content || '')}">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">HTML Etiketi</label>
                        <select name="settings[tag]" class="form-select form-select-sm">
                            ${['h1','h2','h3','h4','h5','h6'].map(t => 
                                `<option value="${t}" ${widget.settings?.tag === t ? 'selected' : ''}>${t.toUpperCase()}</option>`
                            ).join('')}
                        </select>
                    </div>
                `;
                break;
            
            case 'text':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Metin İçeriği</label>
                        <textarea name="content" class="form-control form-control-sm" rows="5">${widget.content || ''}</textarea>
                        <small class="text-muted">HTML kullanabilirsiniz</small>
                    </div>
                `;
                break;
            
            case 'image':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Görsel URL</label>
                        <input type="text" name="content" class="form-control form-control-sm" value="${escapeHtml(widget.content || '')}" placeholder="https://...">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Alt Metin</label>
                        <input type="text" name="settings[alt]" class="form-control form-control-sm" value="${escapeHtml(widget.settings?.alt || '')}">
                    </div>
                `;
                break;
            
            case 'button':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Buton Metni</label>
                        <input type="text" name="content" class="form-control form-control-sm" value="${escapeHtml(widget.content || '')}">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Link URL</label>
                        <input type="text" name="settings[link]" class="form-control form-control-sm" value="${escapeHtml(widget.settings?.link || '#')}">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Buton Stili</label>
                        <select name="settings[btnClass]" class="form-select form-select-sm">
                            <option value="btn-primary" ${widget.settings?.btnClass === 'btn-primary' ? 'selected' : ''}>Primary</option>
                            <option value="btn-secondary" ${widget.settings?.btnClass === 'btn-secondary' ? 'selected' : ''}>Secondary</option>
                            <option value="btn-success" ${widget.settings?.btnClass === 'btn-success' ? 'selected' : ''}>Success</option>
                            <option value="btn-danger" ${widget.settings?.btnClass === 'btn-danger' ? 'selected' : ''}>Danger</option>
                            <option value="btn-warning" ${widget.settings?.btnClass === 'btn-warning' ? 'selected' : ''}>Warning</option>
                            <option value="btn-info" ${widget.settings?.btnClass === 'btn-info' ? 'selected' : ''}>Info</option>
                            <option value="btn-light" ${widget.settings?.btnClass === 'btn-light' ? 'selected' : ''}>Light</option>
                            <option value="btn-dark" ${widget.settings?.btnClass === 'btn-dark' ? 'selected' : ''}>Dark</option>
                            <option value="btn-outline-primary" ${widget.settings?.btnClass === 'btn-outline-primary' ? 'selected' : ''}>Outline Primary</option>
                            <option value="btn-outline-secondary" ${widget.settings?.btnClass === 'btn-outline-secondary' ? 'selected' : ''}>Outline Secondary</option>
                        </select>
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Buton Boyutu</label>
                        <select name="settings[btnSize]" class="form-select form-select-sm">
                            <option value="" ${!widget.settings?.btnSize ? 'selected' : ''}>Normal</option>
                            <option value="btn-sm" ${widget.settings?.btnSize === 'btn-sm' ? 'selected' : ''}>Küçük</option>
                            <option value="btn-lg" ${widget.settings?.btnSize === 'btn-lg' ? 'selected' : ''}>Büyük</option>
                        </select>
                    </div>
                `;
                break;
            
            case 'video':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">YouTube URL</label>
                        <input type="text" name="content" class="form-control form-control-sm" value="${escapeHtml(widget.content || '')}" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                `;
                break;
            
            case 'divider':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Çizgi Stili</label>
                        <select name="settings[style]" class="form-select form-select-sm">
                            <option value="solid" ${widget.settings?.style === 'solid' ? 'selected' : ''}>Düz</option>
                            <option value="dashed" ${widget.settings?.style === 'dashed' ? 'selected' : ''}>Kesikli</option>
                            <option value="dotted" ${widget.settings?.style === 'dotted' ? 'selected' : ''}>Noktalı</option>
                        </select>
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Kalınlık</label>
                        <input type="text" name="settings[thickness]" class="form-control form-control-sm" value="${widget.settings?.thickness || '1px'}" placeholder="1px">
                    </div>
                `;
                break;
            
            case 'spacer':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Yükseklik</label>
                        <input type="text" name="settings[height]" class="form-control form-control-sm" value="${widget.settings?.height || '50px'}" placeholder="50px">
                    </div>
                `;
                break;
            
            case 'html':
                html += `
                    <div class="settings-row">
                        <label class="settings-label">HTML Kodu</label>
                        <textarea name="content" class="form-control form-control-sm font-monospace" rows="8">${escapeHtml(widget.content || '')}</textarea>
                    </div>
                `;
                break;
        }
        
        html += `</div>`;
        
        // Style Section (for applicable widgets)
        if (['heading', 'text', 'button', 'image', 'divider'].includes(widget.type)) {
            html += `<div class="settings-section">
                <div class="settings-section-title">Stil</div>`;
            
            if (['heading', 'text'].includes(widget.type)) {
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Renk</label>
                        <div class="color-picker-wrapper">
                            <input type="color" name="settings[color]" value="${widget.settings?.color || '#212529'}">
                            <input type="text" class="form-control form-control-sm color-text" value="${widget.settings?.color || '#212529'}">
                        </div>
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Font Boyutu</label>
                        <input type="text" name="settings[fontSize]" class="form-control form-control-sm" value="${widget.settings?.fontSize || ''}" placeholder="Örn: 18px, 1.5rem">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Hizalama</label>
                        <select name="settings[textAlign]" class="form-select form-select-sm">
                            <option value="left" ${widget.settings?.textAlign === 'left' ? 'selected' : ''}>Sol</option>
                            <option value="center" ${widget.settings?.textAlign === 'center' ? 'selected' : ''}>Orta</option>
                            <option value="right" ${widget.settings?.textAlign === 'right' ? 'selected' : ''}>Sağ</option>
                            <option value="justify" ${widget.settings?.textAlign === 'justify' ? 'selected' : ''}>İki Yana</option>
                        </select>
                    </div>
                `;
            }
            
            if (widget.type === 'text') {
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Satır Yüksekliği</label>
                        <input type="text" name="settings[lineHeight]" class="form-control form-control-sm" value="${widget.settings?.lineHeight || '1.6'}" placeholder="1.6">
                    </div>
                `;
            }
            
            if (widget.type === 'heading') {
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Font Kalınlığı</label>
                        <select name="settings[fontWeight]" class="form-select form-select-sm">
                            <option value="400" ${widget.settings?.fontWeight === '400' ? 'selected' : ''}>Normal</option>
                            <option value="500" ${widget.settings?.fontWeight === '500' ? 'selected' : ''}>Medium</option>
                            <option value="600" ${widget.settings?.fontWeight === '600' ? 'selected' : ''}>Semi Bold</option>
                            <option value="700" ${widget.settings?.fontWeight === '700' ? 'selected' : ''}>Bold</option>
                        </select>
                    </div>
                `;
            }
            
            if (widget.type === 'image') {
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Genişlik</label>
                        <input type="text" name="settings[width]" class="form-control form-control-sm" value="${widget.settings?.width || '100%'}" placeholder="100%, 500px">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Maksimum Genişlik</label>
                        <input type="text" name="settings[maxWidth]" class="form-control form-control-sm" value="${widget.settings?.maxWidth || ''}" placeholder="800px">
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Köşe Yuvarlaklığı</label>
                        <input type="text" name="settings[borderRadius]" class="form-control form-control-sm" value="${widget.settings?.borderRadius || '0'}" placeholder="8px">
                    </div>
                `;
            }
            
            if (widget.type === 'button') {
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Hizalama</label>
                        <select name="settings[textAlign]" class="form-select form-select-sm">
                            <option value="left" ${widget.settings?.textAlign === 'left' ? 'selected' : ''}>Sol</option>
                            <option value="center" ${widget.settings?.textAlign === 'center' ? 'selected' : ''}>Orta</option>
                            <option value="right" ${widget.settings?.textAlign === 'right' ? 'selected' : ''}>Sağ</option>
                        </select>
                    </div>
                    <div class="settings-row">
                        <label class="settings-label">Köşe Yuvarlaklığı</label>
                        <input type="text" name="settings[borderRadius]" class="form-control form-control-sm" value="${widget.settings?.borderRadius || '4px'}" placeholder="4px">
                    </div>
                `;
            }
            
            if (widget.type === 'divider') {
                html += `
                    <div class="settings-row">
                        <label class="settings-label">Renk</label>
                        <div class="color-picker-wrapper">
                            <input type="color" name="settings[color]" value="${widget.settings?.color || '#dee2e6'}">
                            <input type="text" class="form-control form-control-sm color-text" value="${widget.settings?.color || '#dee2e6'}">
                        </div>
                    </div>
                `;
            }
            
            html += `</div>`;
        }
        
        // Spacing Section
        html += `<div class="settings-section">
            <div class="settings-section-title">Boşluklar (Margin)</div>
            <div class="spacing-visual">
                <input type="text" name="settings[marginTop]" class="spacing-top" value="${widget.settings?.marginTop || '0'}" placeholder="Üst">
                <input type="text" name="settings[marginLeft]" class="spacing-left" value="${widget.settings?.marginLeft || '0'}" placeholder="Sol">
                <div class="spacing-center">Widget</div>
                <input type="text" name="settings[marginRight]" class="spacing-right" value="${widget.settings?.marginRight || '0'}" placeholder="Sağ">
                <input type="text" name="settings[marginBottom]" class="spacing-bottom" value="${widget.settings?.marginBottom || '0'}" placeholder="Alt">
            </div>
        </div>`;
        
        html += `<div class="settings-section">
            <div class="settings-section-title">İç Boşluk (Padding)</div>
            <div class="spacing-visual">
                <input type="text" name="settings[paddingTop]" class="spacing-top" value="${widget.settings?.paddingTop || '0'}" placeholder="Üst">
                <input type="text" name="settings[paddingLeft]" class="spacing-left" value="${widget.settings?.paddingLeft || '0'}" placeholder="Sol">
                <div class="spacing-center">İçerik</div>
                <input type="text" name="settings[paddingRight]" class="spacing-right" value="${widget.settings?.paddingRight || '0'}" placeholder="Sağ">
                <input type="text" name="settings[paddingBottom]" class="spacing-bottom" value="${widget.settings?.paddingBottom || '0'}" placeholder="Alt">
            </div>
        </div>`;
        
        html += `
            <div class="settings-section">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg me-1"></i>Uygula
                </button>
            </div>
        </form>`;
        
        $('#settings-content').html(html);
        openSettings();
    }
    
    function openSectionSettings(sIndex) {
        const section = layoutData[sIndex];
        selectedElement = { sIndex };
        selectedType = 'section';
        
        $('.builder-widget, .builder-section').removeClass('selected');
        $(`.builder-section[data-section-index="${sIndex}"]`).addClass('selected');
        
        $('#settings-title').text('Section Ayarları');
        
        let html = `<form id="section-settings-form">
            <div class="settings-section">
                <div class="settings-section-title">Genel</div>
                <div class="settings-row">
                    <label class="settings-label">Arka Plan Rengi</label>
                    <div class="color-picker-wrapper">
                        <input type="color" name="settings[backgroundColor]" value="${section.settings?.backgroundColor || '#ffffff'}">
                        <input type="text" class="form-control form-control-sm color-text" value="${section.settings?.backgroundColor || '#ffffff'}">
                    </div>
                </div>
                <div class="settings-row">
                    <div class="form-check">
                        <input type="checkbox" name="settings[fullWidth]" class="form-check-input" id="fullWidthCheck" ${section.settings?.fullWidth ? 'checked' : ''}>
                        <label class="form-check-label" for="fullWidthCheck">Tam Genişlik</label>
                    </div>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="settings-section-title">Dikey Boşluklar</div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="settings-label">Üst Padding</label>
                        <input type="text" name="settings[paddingTop]" class="form-control form-control-sm" value="${section.settings?.paddingTop || '60px'}" placeholder="60px">
                    </div>
                    <div class="col-6">
                        <label class="settings-label">Alt Padding</label>
                        <input type="text" name="settings[paddingBottom]" class="form-control form-control-sm" value="${section.settings?.paddingBottom || '60px'}" placeholder="60px">
                    </div>
                </div>
            </div>
            
            <div class="settings-section">
                <div class="settings-section-title">Sütun Düzeni</div>
                <div class="column-layout-selector" id="section-column-layout">
                    ${generateColumnLayoutOptions(section)}
                </div>
            </div>
            
            <div class="settings-section">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg me-1"></i>Uygula
                </button>
            </div>
        </form>`;
        
        $('#settings-content').html(html);
        openSettings();
    }
    
    function generateColumnLayoutOptions(section) {
        const currentLayout = section.columns.map(c => {
            const match = c.class.match(/col-md-(\d+)/);
            return match ? match[1] : '12';
        }).join('-');
        
        const layouts = ['12', '6-6', '4-4-4', '3-3-3-3', '4-8', '8-4', '3-6-3'];
        
        return layouts.map(layout => {
            const cols = layout.split('-');
            const preview = cols.map(c => `<span style="flex: ${c};"></span>`).join('');
            const selected = layout === currentLayout ? 'selected' : '';
            
            return `
                <div class="column-layout-option ${selected}" data-layout="${layout}">
                    <div class="column-layout-preview">${preview}</div>
                </div>
            `;
        }).join('');
    }
    
    function getWidgetTitle(type) {
        const titles = {
            heading: 'Başlık',
            text: 'Metin',
            image: 'Görsel',
            button: 'Buton',
            video: 'Video',
            divider: 'Ayırıcı',
            spacer: 'Boşluk',
            html: 'HTML Kodu'
        };
        return titles[type] || type;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // ============================================
    // EVENT HANDLERS
    // ============================================
    
    // Add Section
    $('#add-section-btn').on('click', () => addSection('12'));
    $(document).on('click', '#empty-canvas-add, #bottom-add-section', () => addSection('12'));
    
    // Column Layout Selection (sidebar)
    $('.column-layout-option').on('click', function() {
        if (selectedType === 'section' && selectedElement) {
            applyColumnLayout(selectedElement.sIndex, $(this).data('layout'));
        } else {
            // Add new section with this layout
            addSection($(this).data('layout'));
        }
    });
    
    // Section Events
    $(document).on('click', '.section-settings-btn', function(e) {
        e.stopPropagation();
        const sIndex = parseInt($(this).closest('.builder-section').data('section-index'));
        openSectionSettings(sIndex);
    });
    
    $(document).on('click', '.section-delete', function(e) {
        e.stopPropagation();
        if (confirm('Bu section\'ı silmek istediğinize emin misiniz?')) {
            const sIndex = parseInt($(this).closest('.builder-section').data('section-index'));
            deleteSection(sIndex);
        }
    });
    
    $(document).on('click', '.section-duplicate', function(e) {
        e.stopPropagation();
        const sIndex = parseInt($(this).closest('.builder-section').data('section-index'));
        duplicateSection(sIndex);
    });
    
    $(document).on('click', '.section-move-up', function(e) {
        e.stopPropagation();
        const sIndex = parseInt($(this).closest('.builder-section').data('section-index'));
        moveSection(sIndex, 'up');
    });
    
    $(document).on('click', '.section-move-down', function(e) {
        e.stopPropagation();
        const sIndex = parseInt($(this).closest('.builder-section').data('section-index'));
        moveSection(sIndex, 'down');
    });
    
    // Widget Events
    $(document).on('click', '.builder-widget', function(e) {
        e.stopPropagation();
        const $widget = $(this);
        openWidgetSettings(
            parseInt($widget.data('section-index')),
            parseInt($widget.data('col-index')),
            parseInt($widget.data('widget-index'))
        );
    });
    
    $(document).on('click', '.widget-settings-btn', function(e) {
        e.stopPropagation();
        const $widget = $(this).closest('.builder-widget');
        openWidgetSettings(
            parseInt($widget.data('section-index')),
            parseInt($widget.data('col-index')),
            parseInt($widget.data('widget-index'))
        );
    });
    
    $(document).on('click', '.widget-delete', function(e) {
        e.stopPropagation();
        if (confirm('Bu widget\'ı silmek istediğinize emin misiniz?')) {
            const $widget = $(this).closest('.builder-widget');
            deleteWidget(
                parseInt($widget.data('section-index')),
                parseInt($widget.data('col-index')),
                parseInt($widget.data('widget-index'))
            );
        }
    });
    
    $(document).on('click', '.widget-duplicate', function(e) {
        e.stopPropagation();
        const $widget = $(this).closest('.builder-widget');
        duplicateWidget(
            parseInt($widget.data('section-index')),
            parseInt($widget.data('col-index')),
            parseInt($widget.data('widget-index'))
        );
    });
    
    $(document).on('click', '.widget-move-up', function(e) {
        e.stopPropagation();
        const $widget = $(this).closest('.builder-widget');
        moveWidget(
            parseInt($widget.data('section-index')),
            parseInt($widget.data('col-index')),
            parseInt($widget.data('widget-index')),
            'up'
        );
    });
    
    $(document).on('click', '.widget-move-down', function(e) {
        e.stopPropagation();
        const $widget = $(this).closest('.builder-widget');
        moveWidget(
            parseInt($widget.data('section-index')),
            parseInt($widget.data('col-index')),
            parseInt($widget.data('widget-index')),
            'down'
        );
    });
    
    // Settings Panel
    $('#close-settings').on('click', closeSettings);
    
    // Widget Settings Form
    $(document).on('submit', '#widget-settings-form', function(e) {
        e.preventDefault();
        
        if (!selectedElement || selectedType !== 'widget') return;
        
        const { sIndex, cIndex, wIndex } = selectedElement;
        const widget = layoutData[sIndex].columns[cIndex].widgets[wIndex];
        
        // Update content
        const content = $(this).find('[name="content"]').val();
        if (content !== undefined) {
            widget.content = content;
        }
        
        // Update settings
        $(this).find('[name^="settings"]').each(function() {
            const match = this.name.match(/settings\[(\w+)\]/);
            if (match) {
                const value = this.type === 'checkbox' ? this.checked : $(this).val();
                widget.settings[match[1]] = value;
            }
        });
        
        renderCanvas();
        
        setTimeout(() => {
            openWidgetSettings(sIndex, cIndex, wIndex);
        }, 50);
    });
    
    // Section Settings Form
    $(document).on('submit', '#section-settings-form', function(e) {
        e.preventDefault();
        
        if (!selectedElement || selectedType !== 'section') return;
        
        const { sIndex } = selectedElement;
        const section = layoutData[sIndex];
        
        $(this).find('[name^="settings"]').each(function() {
            const match = this.name.match(/settings\[(\w+)\]/);
            if (match) {
                const value = this.type === 'checkbox' ? this.checked : $(this).val();
                section.settings[match[1]] = value;
            }
        });
        
        renderCanvas();
        
        setTimeout(() => {
            openSectionSettings(sIndex);
        }, 50);
    });
    
    // Column Layout in Section Settings
    $(document).on('click', '#section-column-layout .column-layout-option', function() {
        if (selectedType === 'section' && selectedElement) {
            applyColumnLayout(selectedElement.sIndex, $(this).data('layout'));
            setTimeout(() => {
                openSectionSettings(selectedElement.sIndex);
            }, 50);
        }
    });
    
    // Color Picker Sync
    $(document).on('input', 'input[type="color"]', function() {
        $(this).siblings('.color-text').val($(this).val());
    });
    
    $(document).on('input', '.color-text', function() {
        $(this).siblings('input[type="color"]').val($(this).val());
    });
    
    // Viewport Switcher
    $('.viewport-btn').on('click', function() {
        $('.viewport-btn').removeClass('active');
        $(this).addClass('active');
        
        const viewport = $(this).data('viewport');
        $('.canvas-wrapper').removeClass('viewport-desktop viewport-tablet viewport-mobile')
            .addClass('viewport-' + viewport);
    });
    
    // Save Button
    $('#save-btn').on('click', function() {
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.html('<i class="bi bi-arrow-repeat spin me-1"></i>Kaydediliyor...').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("builder.save", $page->id) }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify({
                title: $('#page-title').val(),
                layout_data: layoutData
            }),
            success: function(response) {
                $btn.html('<i class="bi bi-check-lg me-1"></i>Kaydedildi!');
                setTimeout(() => {
                    $btn.html(originalText).prop('disabled', false);
                }, 2000);
            },
            error: function(xhr) {
                alert('Kaydetme hatası: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
                $btn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Click outside to close settings
    $(document).on('click', '.builder-canvas', function(e) {
        if ($(e.target).closest('.builder-widget, .builder-section').length === 0) {
            closeSettings();
        }
    });
    
    // ============================================
    // INITIALIZATION
    // ============================================
    
    renderCanvas();
});
</script>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.spin {
    animation: spin 1s linear infinite;
}
</style>
@endpush
