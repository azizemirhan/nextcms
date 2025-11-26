# NextCMS - Quick Start Guide

## 🎯 Proje Hedefi

Elementor seviyesinde profesyonel bir **Page Builder CMS** oluşturmak.

## 📋 Ana Dökümanlar

1. **ELEMENTOR_FEATURE_ROADMAP.md** - Tam feature listesi ve 13 fazlık implementation planı

## 🚀 Hemen Başlamak İçin

### Option 1: MVP (Minimum Viable Product) - 10 Hafta
**Phase 1-5'i tamamlayın:**
- ✅ Foundation & Core Architecture (Week 1-2)
- ✅ Container System & Layout (Week 3-4)
- ✅ Typography & Colors (Week 5-6)
- ✅ Advanced Styling (Week 7-8)
- ✅ Motion Effects (Week 9-10)

**Sonuç:** Drag & drop, responsive layout, styling, animations ile çalışan bir page builder

### Option 2: Full Production - 36 Hafta
Tüm 13 phase'i sırasıyla implement edin.

**Önemli Milestone'lar:**
- Week 10: Basic editor hazır
- Week 18: Widget library + E-commerce
- Week 22: Dynamic content & Theme builder
- Week 29: Template library
- Week 36: Production ready

## 🏗️ İlk Adımlar (Phase 1 Başlangıç)

### 1. Frontend Setup (Vue 3)

```bash
cd /home/user/nextcms/page-builder

# Vue 3 dependencies
npm install vue@3 @vitejs/plugin-vue pinia vue-router@4

# Drag & Drop
npm install @shopify/draggable

# UI & Utilities
npm install @headlessui/vue @heroicons/vue

# Rich Text Editor
npm install quill

# Animation
npm install gsap

# HTTP Client (already have axios)
```

### 2. Vite Config Update

```js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/builder/main.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
```

### 3. Database Migrations

```bash
php artisan make:migration update_pages_table_for_builder
php artisan make:migration create_templates_table
php artisan make:migration create_revisions_table
php artisan make:migration create_global_settings_table
```

### 4. Frontend Klasör Yapısı

```
/resources/js/builder/
├── main.js                 # Vue app entry
├── App.vue                 # Root component
├── components/
│   ├── Editor/
│   │   ├── Canvas.vue
│   │   ├── LeftPanel.vue
│   │   ├── RightPanel.vue
│   │   └── TopBar.vue
│   └── Widgets/
│       ├── Heading.vue
│       ├── Text.vue
│       └── Button.vue
├── stores/
│   ├── pageStore.js
│   └── uiStore.js
└── utils/
    ├── api.js
    └── dragDrop.js
```

### 5. API Routes

```php
// routes/api.php
Route::prefix('builder')->group(function () {
    Route::get('/pages/{id}', [PageBuilderController::class, 'show']);
    Route::put('/pages/{id}', [PageBuilderController::class, 'update']);
    Route::post('/pages', [PageBuilderController::class, 'store']);

    Route::get('/templates', [TemplateController::class, 'index']);
    Route::post('/templates', [TemplateController::class, 'store']);

    Route::get('/global-settings', [GlobalSettingsController::class, 'index']);
    Route::put('/global-settings', [GlobalSettingsController::class, 'update']);
});
```

## 📊 Priority Features (İlk Implement Edilmesi Gerekenler)

### 🔴 Critical (Week 1-10)
1. ✅ Drag & Drop System
2. ✅ Container (Flexbox/Grid)
3. ✅ Basic Widgets (heading, text, button, image, video)
4. ✅ Styling System (typography, colors, backgrounds)
5. ✅ Responsive Mode
6. ✅ Save/Load Pages

### 🟠 High (Week 11-22)
7. ⏳ Advanced Widgets (Form, Posts, Gallery, Carousel)
8. ⏳ Animations & Motion Effects
9. ⏳ Dynamic Tags & Theme Builder
10. ⏳ E-commerce Widgets (if needed)

### 🟡 Medium (Week 23-29)
11. ⏳ Navigator & History
12. ⏳ Popup Builder
13. ⏳ Template Library

### 🟢 Low (Week 30-36)
14. ⏳ Developer Tools (Custom CSS/JS, Role Manager)
15. ⏳ Maintenance Mode
16. ⏳ Polish & Optimization

## 🎨 Design System

### Color Palette (Global Settings)
- Primary: #667eea
- Secondary: #764ba2
- Success: #10b981
- Warning: #f59e0b
- Danger: #ef4444
- Text: #1f2937
- Text Muted: #6b7280
- Background: #ffffff
- Border: #e5e7eb

### Typography Presets
- **H1**: 48px, Bold (700), 1.2 line-height
- **H2**: 40px, Bold (700), 1.3 line-height
- **H3**: 32px, SemiBold (600), 1.3 line-height
- **H4**: 24px, SemiBold (600), 1.4 line-height
- **H5**: 20px, Medium (500), 1.5 line-height
- **H6**: 16px, Medium (500), 1.5 line-height
- **Body**: 16px, Regular (400), 1.6 line-height

### Spacing Scale (Tailwind CSS)
- 0: 0px
- 1: 4px
- 2: 8px
- 3: 12px
- 4: 16px
- 5: 20px
- 6: 24px
- 8: 32px
- 10: 40px
- 12: 48px
- 16: 64px
- 20: 80px

## 🧪 Test Strategy

### Phase 1-5 Testing
- [ ] Drag widget from left panel to canvas ✅
- [ ] Drop widget inside container ✅
- [ ] Reorder widgets ✅
- [ ] Delete widget ✅
- [ ] Select widget and edit settings ✅
- [ ] Change container flexbox properties ✅
- [ ] Responsive mode switch (desktop/tablet/mobile) ✅
- [ ] Save page ✅
- [ ] Load page ✅
- [ ] Preview page ✅

### Phase 6+ Testing
- [ ] All widgets render correctly
- [ ] Forms submit successfully
- [ ] E-commerce add to cart works
- [ ] Dynamic tags resolve correctly
- [ ] Animations trigger on scroll
- [ ] Popups trigger correctly
- [ ] Templates import/export

## 📈 Success Metrics

### Technical Metrics
- **Page Load Time**: < 3 seconds
- **Editor Load Time**: < 2 seconds
- **Save Time**: < 1 second
- **Lighthouse Score**: 90+
- **Mobile Responsive**: 100% widgets work on mobile

### User Metrics
- **Time to Create Page**: < 10 minutes (for basic page)
- **Learning Curve**: User can create page without tutorial in < 30 minutes
- **Widget Library**: 50+ widgets
- **Template Library**: 100+ templates/blocks

## 🐛 Known Challenges & Solutions

### Challenge 1: Drag & Drop Performance
**Problem**: Lag when dragging many widgets
**Solution**: Virtual scrolling, throttle/debounce events, use requestAnimationFrame

### Challenge 2: Responsive Design Complexity
**Problem**: Managing 3 device sizes with different values
**Solution**: Store responsive values in object: `{ desktop: '48px', tablet: '36px', mobile: '24px' }`

### Challenge 3: Dynamic Tag Resolution
**Problem**: Tags inside loops (e.g., {{post.title}} in Posts widget)
**Solution**: Separate render context per loop item, pass variables down

### Challenge 4: Undo/Redo with Deep State
**Problem**: Cloning entire page state is expensive
**Solution**: Use Immer.js for structural sharing, only store diffs

### Challenge 5: Real-time Preview Performance
**Problem**: Re-rendering entire canvas on every change
**Solution**: React/Vue's virtual DOM handles this, but also use `key` prop for stable IDs

## 🔗 Useful Resources

- **Vue 3 Docs**: https://vuejs.org/
- **Pinia (State Management)**: https://pinia.vuejs.org/
- **Tailwind CSS**: https://tailwindcss.com/
- **GSAP (Animation)**: https://greensock.com/gsap/
- **Quill (Rich Text)**: https://quilljs.com/
- **Laravel 12 Docs**: https://laravel.com/docs/12.x
- **GrapesJS (Inspiration)**: https://grapesjs.com/
- **Craft.js (React Builder)**: https://craft.js.org/

## ✅ Definition of Done (Per Phase)

### Phase 1 Done:
- [x] Drag widget from panel to canvas works
- [x] Drop zone highlights during drag
- [x] Widget settings panel opens on click
- [x] Can save page to database
- [x] Can load page from database
- [x] Basic undo/redo works

### Phase 2 Done:
- [ ] Flexbox container with all properties (direction, justify, align, gap, wrap)
- [ ] Responsive values per device
- [ ] Width, height, padding, margin controls with units (px, %, em, rem, vw, vh)
- [ ] Position controls (relative, absolute, fixed, sticky)
- [ ] Z-index control

### Phase 3 Done:
- [ ] Google Fonts integration (can select from 800+ fonts)
- [ ] Global color palette (8-10 colors)
- [ ] Typography controls (size, weight, style, transform, line-height, letter-spacing)
- [ ] Color picker with opacity
- [ ] Background: solid, image, gradient

---

## 🚦 Current Status

✅ **Project Initialized**: Laravel 12 + Tailwind CSS v4
✅ **Basic Structure**: Section > Column > Widget
✅ **Basic Widgets**: heading, text, button, image, video, divider, spacer, html
✅ **Roadmap Created**: 13-phase implementation plan

**Next Step**: Frontend setup (Vue 3 + Pinia) ve Phase 1 başlangıç

---

Hazır olduğunuzda "Phase 1'i başlat" diyebilirsiniz! 🚀
