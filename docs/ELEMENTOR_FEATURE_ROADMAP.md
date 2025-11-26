# NextCMS - Elementor-Like Page Builder Feature Roadmap

## 📊 Current Project Status

### Existing Features ✅
- **Backend**: Laravel 12 with BuilderService
- **Data Model**: JSON-based `layout_data` storage in Pages table
- **Structure**: Section → Column → Widget hierarchy
- **Basic Widgets**: heading, text, button, image, video, divider, spacer, html
- **Styling**: Basic inline CSS generation (padding, margin, colors, typography)
- **Layout**: Bootstrap grid system (col-12, col-md-6, etc.)

### Technology Stack
- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Blade templates, Tailwind CSS v4, Vite
- **Database**: MySQL/PostgreSQL (JSON column support)

---

## 🎯 Master Feature List (Elementor Reference)

Bu liste Elementor'un tüm özelliklerini kategorize edilmiş şekilde içerir.

### 1. Editor Arayüzü ve Kullanıcı Deneyimi (UI/UX)

#### 1.1 Core Editor Features
- [ ] **Drag & Drop System** - Canlı önizleme ile sürükle-bırak
  - Real-time preview
  - Ghost/placeholder görünümü
  - Snap-to-grid özelliği
  - Multi-element selection

- [ ] **Navigator (Layers Panel)** - Ağaç yapısı görünümü
  - Section > Container > Widget hiyerarşisi
  - Show/hide öğeler
  - Yeniden sıralama (drag & drop in tree)
  - Öğe arama
  - Genişlet/daralt düğümleri

- [ ] **Finder (Quick Search)** - Spotlight benzeri hızlı arama
  - Pages arama
  - Settings arama
  - Widgets arama
  - Keyboard shortcut (Cmd/Ctrl + E)

- [ ] **History & Revisions** - Geçmiş ve sürüm kontrolü
  - Undo/Redo (Cmd/Ctrl + Z)
  - History panel (son 50 işlem)
  - Revision snapshots (otomatik kayıt)
  - Version comparison
  - Restore to previous version

- [ ] **Responsive Mode** - Duyarlı tasarım modu
  - Desktop view (1920px+)
  - Tablet view (768px - 1024px)
  - Mobile view (< 768px)
  - Device preview switcher
  - Per-device settings (farklı stil her cihaz için)
  - Responsive visibility controls (hide on mobile, etc.)

- [ ] **Right-Click Context Menu** - Sağ tık menüsü
  - Copy (Cmd/Ctrl + C)
  - Paste (Cmd/Ctrl + V)
  - Paste Style (Shift + Cmd/Ctrl + V)
  - Duplicate (Cmd/Ctrl + D)
  - Delete (Del/Backspace)
  - Copy to other page
  - Save as template
  - Lock/unlock element

- [ ] **Copy & Paste** - Kopyala yapıştır sistemi
  - Within same page
  - Between pages
  - Cross-domain (different sites) - JSON export/import
  - Style-only paste
  - Clipboard manager

- [ ] **Inline Editing** - Doğrudan metin düzenleme
  - Click to edit text
  - Rich text formatting toolbar
  - Auto-save while typing
  - Markdown support (optional)

- [ ] **Global Settings (Site Settings)** - Site geneli ayarlar
  - Default colors palette
  - Typography presets (H1-H6, body, etc.)
  - Button styles
  - Form styles
  - Layout defaults (container width, gap, etc.)
  - Custom CSS (global)

- [ ] **Dark Mode** - Koyu tema
  - Editor UI dark mode
  - User preference toggle
  - System preference detection

#### 1.2 Advanced UI Features
- [ ] **Keyboard Shortcuts** - Klavye kısayolları
  - Save (Cmd/Ctrl + S)
  - Preview (Cmd/Ctrl + P)
  - Undo/Redo
  - Copy/Paste/Duplicate
  - Delete
  - Find (Cmd/Ctrl + F)

- [ ] **Panel Layouts** - Panel düzenleri
  - Left panel (widgets)
  - Right panel (settings)
  - Collapsible panels
  - Resizable panels
  - Full-screen mode

- [ ] **Loading States** - Yükleme durumları
  - Skeleton loaders
  - Progress indicators
  - Saving status (auto-save indicator)

- [ ] **Error Handling** - Hata yönetimi
  - Validation messages
  - Connection lost warnings
  - Recovery mode
  - Debug console

---

### 2. Layout (Yerleşim) ve Yapısal Özellikler

#### 2.1 Container System (Modern Flexbox/Grid)
- [ ] **Container Widget** - Ana layout yapı taşı
  - Flexbox mode
  - CSS Grid mode
  - Classic mode (eski Section+Column)

- [ ] **Flexbox Properties**
  - **Direction**: row, column, row-reverse, column-reverse
  - **Justify Content**: start, center, end, space-between, space-around, space-evenly
  - **Align Items**: start, center, end, stretch, baseline
  - **Align Content**: start, center, end, space-between, space-around, stretch
  - **Gap**: row-gap, column-gap (px, em, rem, %)
  - **Wrap**: nowrap, wrap, wrap-reverse

- [ ] **CSS Grid Properties**
  - **Template Columns**: repeat(auto-fit, minmax(300px, 1fr)), etc.
  - **Template Rows**: auto, fr, px, %
  - **Gap**: row-gap, column-gap
  - **Grid auto-flow**: row, column, dense
  - **Justify Items**: start, center, end, stretch
  - **Align Items**: start, center, end, stretch

- [ ] **Sizing & Spacing**
  - **Width**: px, %, vw, auto, fit-content
  - **Height**: px, %, vh, auto
  - **Min-Width / Max-Width**
  - **Min-Height / Max-Height**
  - **Boxed / Full Width** toggle
  - **Padding**: top, right, bottom, left (linked/unlinked)
  - **Margin**: top, right, bottom, left (linked/unlinked)
  - **Units**: px, %, em, rem, vw, vh, auto

- [ ] **Positioning**
  - **Position**: static, relative, absolute, fixed, sticky
  - **Z-Index**: layer stacking
  - **Top, Right, Bottom, Left** offset
  - **Overflow**: visible, hidden, scroll, auto
  - **Overflow X/Y** separate control

- [ ] **HTML Semantics**
  - **HTML Tag**: div, section, article, aside, header, footer, nav, main
  - **Custom ID & Class**
  - **Data Attributes**

#### 2.2 Legacy Layout (Backward Compatibility)
- [ ] **Section & Columns** - Eski sistem desteği
  - Section types: default, inner
  - Column count: 1-6 columns
  - Column width: %, responsive
  - Column order (mobile)
  - Nested sections (inner section)

---

### 3. Tasarım ve Stil Özellikleri (Styling)

#### 3.1 Typography
- [ ] **Font Family**
  - Google Fonts integration (800+ fonts)
  - Adobe Fonts integration
  - Custom font upload (TTF, OTF, WOFF, WOFF2)
  - System fonts
  - Font pairing suggestions

- [ ] **Text Styling**
  - **Size**: px, em, rem, vw
  - **Weight**: 100-900, normal, bold
  - **Style**: normal, italic, oblique
  - **Transform**: none, uppercase, lowercase, capitalize
  - **Decoration**: none, underline, overline, line-through
  - **Line-Height**: normal, px, em, rem, unitless
  - **Letter-Spacing**: px, em
  - **Word-Spacing**: px, em
  - **Text Shadow**: x, y, blur, color
  - **Text Stroke**: width, color (WebKit)

- [ ] **Paragraph Styling**
  - **Alignment**: left, center, right, justify
  - **Direction**: ltr, rtl
  - **Indent**: first-line indent
  - **Text Columns**: column-count, column-gap

#### 3.2 Colors & Backgrounds
- [ ] **Color System**
  - Solid colors (HEX, RGB, HSL)
  - Color picker with presets
  - Global color palette
  - Color variables/tokens
  - Opacity/alpha control

- [ ] **Background Types**
  - **Classic**: solid color or single image
  - **Gradient**: linear, radial, conic
    - Multiple color stops
    - Angle/direction control
    - Gradient presets
  - **Image**:
    - Upload or media library
    - Position (center, top, bottom, left, right, custom)
    - Attachment (scroll, fixed - parallax)
    - Repeat (no-repeat, repeat, repeat-x, repeat-y)
    - Size (auto, cover, contain, custom px/%)
  - **Video**:
    - YouTube embed
    - Vimeo embed
    - Self-hosted MP4
    - Fallback image
    - Mute/unmute control
    - Loop option
    - Mobile fallback (video off on mobile)
  - **Slideshow**:
    - Multiple images cycling
    - Transition effects (fade, slide)
    - Ken Burns effect (zoom & pan)
    - Slide duration
    - Transition speed

- [ ] **Background Overlay**
  - Second layer over background
  - Color or gradient
  - Opacity control
  - Blend mode
  - Hover effects

#### 3.3 Borders & Decorations
- [ ] **Border**
  - **Type**: none, solid, double, dotted, dashed, groove, ridge, inset, outset
  - **Width**: all sides or individual (top, right, bottom, left)
  - **Color**: solid or gradient
  - **Radius**: all corners or individual (top-left, top-right, bottom-right, bottom-left)
  - **Units**: px, %, em, rem

- [ ] **Box Shadow**
  - Outer shadow
  - Inner shadow (inset)
  - Multiple shadows
  - Horizontal offset
  - Vertical offset
  - Blur radius
  - Spread radius
  - Color with opacity
  - Shadow presets

- [ ] **Outline** (separate from border)
  - Width, style, color
  - Offset

#### 3.4 Shape Dividers
- [ ] **Shape Divider System**
  - Position: top, bottom (both)
  - Built-in shapes:
    - Waves, Waves Brush, Waves Pattern
    - Curve, Curve Asymmetric
    - Triangle, Triangle Asymmetric
    - Tilt, Tilt Opacity
    - Mountains
    - Clouds
    - Zigzag
    - Pyramids
    - Arrow, Split Arrow
    - Book
    - Drops
    - Opacity Fan, Opacity Tilt
  - Custom SVG upload
  - Height adjustment (px, %)
  - Flip horizontally/vertically
  - Color control
  - Bring to front (z-index)

#### 3.5 Advanced Effects
- [ ] **CSS Filters**
  - Blur (px)
  - Brightness (%)
  - Contrast (%)
  - Saturation (%)
  - Hue (degrees)
  - Opacity (%)
  - Grayscale (%)
  - Sepia (%)
  - Invert (%)

- [ ] **Blend Modes** (mix-blend-mode)
  - Normal
  - Multiply, Screen, Overlay
  - Darken, Lighten
  - Color-dodge, Color-burn
  - Hard-light, Soft-light
  - Difference, Exclusion
  - Hue, Saturation, Color, Luminosity

- [ ] **Mask (Clipping)**
  - Predefined shapes: circle, ellipse, triangle, hexagon, star
  - Custom SVG mask upload
  - Position & size control
  - Repeat options

- [ ] **Transform**
  - Rotate (deg)
  - Scale X/Y (%)
  - Skew X/Y (deg)
  - Translate X/Y (px, %)
  - Transform origin
  - 3D transforms (rotateX, rotateY, translateZ)
  - Perspective

---

### 4. Hareket ve Etkileşim (Motion Effects)

#### 4.1 Entrance Animations
- [ ] **Animation Library**
  - **Fade**: fadeIn, fadeInUp, fadeInDown, fadeInLeft, fadeInRight
  - **Zoom**: zoomIn, zoomInUp, zoomInDown, zoomInLeft, zoomInRight
  - **Bounce**: bounceIn, bounceInUp, bounceInDown, bounceInLeft, bounceInRight
  - **Slide**: slideInUp, slideInDown, slideInLeft, slideInRight
  - **Rotate**: rotateIn, rotateInDownLeft, rotateInDownRight, rotateInUpLeft, rotateInUpRight
  - **Flip**: flipInX, flipInY
  - **Light Speed**: lightSpeedInRight, lightSpeedInLeft
  - **Roll**: rollIn
  - **Special**: jackInTheBox, heartBeat, flash, pulse, rubberBand, shake, swing, tada, wobble, jello

- [ ] **Animation Controls**
  - Duration (ms)
  - Delay (ms)
  - Easing function (linear, ease, ease-in, ease-out, ease-in-out, custom cubic-bezier)
  - Animation repeat (once, infinite, custom count)

#### 4.2 Scroll Effects
- [ ] **Scroll-based Animations**
  - **Vertical Scroll** (Parallax)
    - Speed factor (-10 to 10)
    - Direction (up/down)
    - Viewport offset
  - **Horizontal Scroll**
    - Speed factor
    - Direction (left/right)
  - **Transparency** (Fade)
    - Fade in while scrolling
    - Start/end points (viewport %)
  - **Blur**
    - Blur amount (0-10px)
    - Start/end points
  - **Rotate**
    - Rotation degrees
    - Speed
    - Direction (clockwise/counter-clockwise)
  - **Scale**
    - Scale factor (0-2)
    - Start/end points

- [ ] **Scroll Controls**
  - Trigger offset (when animation starts)
  - Easing
  - Mobile disable option

#### 4.3 Mouse Effects
- [ ] **Mouse Interactions**
  - **Mouse Track** - Element follows mouse cursor
    - Speed factor
    - Direction (opposite, direct)
  - **3D Tilt** - Element tilts based on mouse position
    - Tilt amount
    - Tilt speed
    - Perspective
    - Glare effect
    - Reset on leave

#### 4.4 Sticky (Position Sticky)
- [ ] **Sticky Controls**
  - Sticky position: top, bottom
  - Offset (px)
  - Sticky on: desktop, tablet, mobile
  - Effects on sticky:
    - Shrink header
    - Background change
    - Blur background
    - Box shadow on sticky

#### 4.5 Hover Effects
- [ ] **Hover Animations**
  - Hover color change (background, text, border)
  - Hover shadow change
  - Hover transform (scale, rotate, translate)
  - Hover opacity
  - Hover border
  - Transition duration
  - Easing function

---

### 5. Widget Kütüphanesi

#### 5.1 Basic Widgets (Free)
- [x] **Heading** - H1-H6 başlıklar ✅ (mevcut)
- [x] **Text Editor** - Rich text (TinyMCE/Quill) ✅ (mevcut)
- [x] **Image** - Resim gösterimi ✅ (mevcut)
- [x] **Video** - YouTube/Vimeo/Self-hosted ✅ (mevcut)
- [x] **Button** - CTA butonları ✅ (mevcut)
- [x] **Divider** - Ayırıcı çizgi ✅ (mevcut)
- [x] **Spacer** - Boşluk bırakma ✅ (mevcut)
- [ ] **Google Maps** - Harita embed
- [x] **Icon** - SVG/Font icon (ihtiyaç: icon library) ⚠️
- [ ] **Icon List** - İkonlu liste
- [ ] **Icon Box** - İkon + başlık + açıklama
- [ ] **Star Rating** - Yıldız puanlama
- [ ] **Image Box** - Resim + başlık + açıklama
- [ ] **Social Icons** - Sosyal medya ikonları
- [ ] **Alert** - Uyarı mesajları
- [ ] **Progress Bar** - İlerleme çubuğu
- [ ] **Counter** - Animasyonlu sayaç
- [ ] **Tabs** - Sekmeler
- [ ] **Accordion** - Akordeon/Collapse
- [ ] **Toggle** - Açılır kapanır içerik

#### 5.2 Pro Widgets (Advanced)
- [ ] **Posts** - Blog yazıları grid/liste
  - Query builder (category, tag, author, date filters)
  - Custom post types
  - Pagination
  - Load more button
  - Masonry layout
  - Custom card design (Loop Builder)

- [ ] **Portfolio** - Portfolyo galerisi
  - Filterable categories
  - Masonry/Grid layouts
  - Lightbox
  - Hover effects

- [ ] **Gallery** - Gelişmiş resim galerisi
  - Masonry, Grid, Justified
  - Lightbox with captions
  - Custom thumbnail size
  - Link to custom URL

- [ ] **Form** - İletişim/Başvuru formları
  - Form builder (drag & drop fields)
  - Field types: text, email, tel, textarea, select, checkbox, radio, file upload, date, number
  - Validation rules
  - Success/error messages
  - Email notifications (to admin & user)
  - Webhook integration
  - Third-party integrations (Mailchimp, ConvertKit, etc.)
  - Multi-step forms
  - Conditional logic

- [ ] **Login** - Üye giriş formu
  - Username/email field
  - Password field
  - Remember me checkbox
  - Lost password link
  - Register link
  - Social login buttons
  - Redirect after login

- [ ] **Slides** - Slider/Carousel
  - Multiple slides
  - Per slide: image, heading, description, button
  - Navigation arrows
  - Pagination dots
  - Autoplay with interval
  - Transition effects
  - Vertical/horizontal orientation

- [ ] **Nav Menu** - Navigasyon menüsü
  - WordPress menu integration
  - Mega menu support
  - Mobile hamburger menu
  - Dropdown indicators
  - Custom styling per level
  - Sticky menu

- [ ] **Animated Headline** - Animasyonlu başlık
  - Rotating words/phrases
  - Effects: typing, clip, flip, swirl, blinds, wave, slide, zoom
  - Speed control
  - Infinite loop

- [ ] **Price List** - Fiyat listesi
  - Item name, description, price
  - Image per item (optional)
  - Divider style
  - Repeater control

- [ ] **Price Table** - Fiyat tablosu
  - Heading, price, duration
  - Feature list (icon + text)
  - CTA button
  - Ribbon/badge
  - Highlight featured plan
  - Tooltip for features

- [ ] **Flip Box** - Dönen kutu
  - Front & back sides
  - 3D flip effect (horizontal/vertical)
  - Hover/click trigger
  - Different content each side

- [ ] **Call to Action (CTA)** - CTA kutusu
  - Background image/color
  - Ribbon
  - Heading, description
  - Primary & secondary buttons
  - Box alignment

- [ ] **Media Carousel** - Medya slider
  - Images and/or videos
  - Lightbox support
  - Thumbnails navigation
  - Autoplay

- [ ] **Testimonial** - Müşteri yorumları
  - Reviewer name, title, company
  - Photo
  - Star rating
  - Quote text
  - Layout: card, bubble, inline

- [ ] **Testimonial Carousel** - Yorumlar slider
  - Multiple testimonials sliding
  - Navigation & pagination
  - Autoplay

- [ ] **Countdown** - Geri sayım
  - Target date & time
  - Display: days, hours, minutes, seconds
  - Actions on expire: message, hide, redirect
  - Evergreen countdown (dynamic)

- [ ] **Share Buttons** - Paylaşım butonları
  - Facebook, Twitter, LinkedIn, Pinterest, WhatsApp, Email, Print
  - Icon only / Icon + text
  - Share count (API)
  - Official buttons or custom styled

- [ ] **Blockquote** - Alıntı kutusu
  - Quote text
  - Author name & title
  - Tweet button (optional)
  - Custom styling

- [ ] **Facebook Embeds**
  - Facebook Button (Like, Share, Send)
  - Facebook Comments
  - Facebook Page embed
  - Facebook Post embed

- [ ] **Lottie** - JSON animasyon
  - Upload Lottie JSON
  - Play on: page load, scroll into view, hover, click
  - Loop, reverse, speed

- [ ] **Code Highlight** - Kod gösterimi
  - Syntax highlighting (Prism.js/Highlight.js)
  - Language selection
  - Theme selection
  - Line numbers
  - Copy to clipboard button

- [ ] **Table of Contents** - İçindekiler
  - Auto-generate from H1-H6 on page
  - Sticky sidebar option
  - Smooth scroll to section
  - Hierarchical or flat list
  - Custom markers

- [ ] **Hotspot** - Resim üzerine noktalar
  - Add multiple hotspots on image
  - Tooltip on hover/click
  - Animated pulse effect
  - Custom icon for hotspot

- [ ] **Read More / "Load More"**
  - Expandable content
  - "Read More" / "Read Less" button
  - Smooth expand animation

#### 5.3 E-Ticaret Widgets (WooCommerce/Custom)
- [ ] **Product Image** - Ürün resmi
  - Main image
  - Gallery thumbnails
  - Zoom on hover
  - Lightbox

- [ ] **Product Title** - Ürün başlığı
  - HTML tag (H1-H6)
  - Link to product

- [ ] **Product Price** - Fiyat
  - Regular price
  - Sale price
  - Currency symbol position

- [ ] **Product Rating** - Yıldız puanı
  - Stars display
  - Review count
  - Link to reviews

- [ ] **Add to Cart** - Sepete ekle
  - Quantity selector
  - Button text customize
  - Ajax add to cart
  - Success message

- [ ] **Product Meta** - Ürün meta bilgileri
  - SKU
  - Category
  - Tags
  - Custom fields

- [ ] **Product Content** - Uzun açıklama
  - Full description (WYSIWYG)

- [ ] **Product Short Description**
  - Summary text

- [ ] **Product Data Tabs** - Sekmeler
  - Description, Reviews, Additional Information tabs
  - Custom tab styling

- [ ] **Upsells** - Önerilen ürünler
  - Related products
  - Grid layout
  - Carousel option

- [ ] **Related Products**
  - Auto-fetch by category/tag
  - Grid/Carousel

- [ ] **Products Grid** - Ürün listesi
  - Query builder (category, tag, on-sale, featured filters)
  - Columns (responsive)
  - Pagination / Load More
  - Custom product card design (Loop Builder)
  - Add to cart on archive
  - Quick view

- [ ] **Product Categories** - Kategori listesi
  - Grid/list layout
  - Show count
  - Thumbnail
  - Description

- [ ] **Cart** - Sepet içeriği
  - Item list
  - Quantity update
  - Remove item
  - Totals
  - Coupon field

- [ ] **Checkout Form** - Ödeme formu
  - Billing fields
  - Shipping fields
  - Order review
  - Payment methods

- [ ] **My Account** - Kullanıcı hesabı
  - Dashboard
  - Orders
  - Downloads
  - Addresses
  - Account details

- [ ] **Menu Cart** - Header sepet ikonu
  - Item count badge
  - Mini cart dropdown
  - Link to cart/checkout

#### 5.4 Theme-Specific / Custom Widgets
- [ ] **Author Box** - Yazar kutusu
- [ ] **Post Navigation** - Önceki/Sonraki yazı
- [ ] **Post Comments** - Yorumlar listesi
- [ ] **Breadcrumbs** - Breadcrumb navigasyon
- [ ] **Search Form** - Arama formu
- [ ] **Sitemap** - Site haritası
- [ ] **Login/Register Form** - Giriş/Kayıt formu
- [ ] **Template** - Saved template ekleme

---

### 6. Theme Builder & Dinamik İçerik

#### 6.1 Dynamic Tags (Dinamik Etiketler)
- [ ] **Dynamic Tag System**
  - Tag categories: Site, Post, Archive, Author, Comments, Media, etc.

- [ ] **Site Tags**
  - Site Title
  - Site Tagline
  - Site Logo
  - Site URL
  - Current Date/Time

- [ ] **Post Tags**
  - Post Title
  - Post Excerpt
  - Post Content
  - Post URL
  - Post Date
  - Post Author Name
  - Post Author Avatar
  - Post Featured Image
  - Post Terms (Categories, Tags)
  - Custom Fields (ACF integration)

- [ ] **Archive Tags**
  - Archive Title
  - Archive Description
  - Archive URL

- [ ] **Author Tags**
  - Author Name
  - Author Bio
  - Author Email
  - Author Website
  - Author Profile Picture

- [ ] **User Tags**
  - Current User Name
  - Current User Email
  - Current User ID

- [ ] **Media Tags**
  - Image from Custom Field
  - Image from URL (external)

- [ ] **WooCommerce Tags**
  - Product Title, Price, SKU, Stock, etc.
  - Cart Total, Item Count

#### 6.2 Display Conditions (Koşullu Görünüm)
- [ ] **Condition Builder**
  - Logical operators: AND, OR, NOT
  - Nested condition groups

- [ ] **Location Rules**
  - **General**: Entire Site, All Pages, Home Page, 404 Page, Search Results
  - **Posts**: All Posts, Specific Post, Post by Category, Post by Tag, Post by Author
  - **Pages**: All Pages, Specific Page, Parent Page, Child Page
  - **Archives**: All Archives, Category Archive, Tag Archive, Author Archive, Date Archive, Search Results
  - **WooCommerce**: Shop Page, Product Page, Product Category, Cart, Checkout, Account Pages
  - **Custom Post Types**: Custom post type archive, single, taxonomy

- [ ] **User Conditions**
  - Logged in / Logged out
  - User role (Administrator, Editor, Author, Subscriber, etc.)
  - Specific user ID

- [ ] **Device Conditions**
  - Desktop, Tablet, Mobile

- [ ] **Date/Time Conditions**
  - Date range (from - to)
  - Time of day
  - Day of week
  - Recurring schedule

- [ ] **Browser/OS Conditions**
  - Browser type (Chrome, Firefox, Safari, Edge, etc.)
  - Operating system

#### 6.3 Loop Builder (Özel Post/Ürün Kartları)
- [ ] **Loop Builder System**
  - Design custom post/product card
  - Apply to Posts widget, Products Grid, etc.
  - Dynamic tags inside loop item
  - Repeater support

- [ ] **Loop Features**
  - Custom query builder
  - Pagination styles
  - No results message
  - Loading spinner

#### 6.4 Global Widgets
- [ ] **Global Widget System**
  - Save widget as global
  - Reuse across pages/templates
  - Edit once, update everywhere
  - Unlink from global
  - Global widget library

#### 6.5 Template System
- [ ] **Template Types**
  - **Page Template**: Full page designs
  - **Header**: Site header
  - **Footer**: Site footer
  - **Single Post**: Blog post layout
  - **Archive**: Category/tag listing layout
  - **Product**: WooCommerce single product
  - **Product Archive**: Shop page layout
  - **Popup**: Modal/popup designs
  - **404 Page**: Error page
  - **Search Results**: Search page

- [ ] **Template Hierarchy**
  - Template priority system (specific > general)
  - Preview with real post data
  - Device-specific templates (optional)

---

### 7. Gelişmiş / Developer Özellikleri

#### 7.1 Custom Code
- [ ] **Custom CSS**
  - Per element (widget, section, column)
  - `{{WRAPPER}}` selector placeholder
  - Syntax highlighting
  - Media query support in CSS editor
  - Global custom CSS

- [ ] **Custom JavaScript**
  - Per page JS
  - Global JS
  - Before </head> injection
  - Before </body> injection

- [ ] **Custom Attributes**
  - Add custom HTML attributes to elements
  - `data-*` attributes
  - ARIA attributes
  - Useful for JS interactions

#### 7.2 Role Manager
- [ ] **User Permissions**
  - Who can access editor (by role)
  - What features visible per role
  - Export/Import permissions per role
  - Template library access per role

#### 7.3 Maintenance Mode
- [ ] **Maintenance/Coming Soon**
  - Enable/disable toggle
  - Custom page design
  - Exclude roles (admin bypass)
  - Exclude IPs
  - Google Analytics while in maintenance

#### 7.4 Developer Tools
- [ ] **Debug Mode**
  - Show element IDs
  - Show CSS classes
  - Performance metrics
  - Error console in editor

- [ ] **API / Hooks System** (Laravel Events)
  - Before render
  - After render
  - On save
  - Custom widget registration

- [ ] **CLI Tools** (Artisan Commands)
  - Clear cache
  - Regenerate CSS
  - Import/export data

- [ ] **Headless Mode** (API-first)
  - REST API endpoint for layout JSON
  - Render HTML via API
  - Use with Next.js, Nuxt, etc.

---

### 8. Pazarlama ve Popup Builder

#### 8.1 Popup Builder
- [ ] **Popup Designer**
  - Full page builder for popup content
  - Popup size: S, M, L, XL, Full screen, Custom (px, %)
  - Position: center, top, bottom, left, right, corners
  - Overlay: color, opacity, blur
  - Close button: style, position, show/hide
  - Close on overlay click
  - Close on ESC key
  - Prevent scroll when open

- [ ] **Popup Triggers**
  - **On Page Load**: Delay (seconds)
  - **On Scroll**: Scroll % or scroll to element
  - **On Scroll to Element**: When specific element in viewport
  - **On Click**: Bind to button/link (via CSS selector or ID)
  - **After Inactivity**: No mouse movement for X seconds
  - **On Exit Intent**: Mouse leaves viewport (desktop)

- [ ] **Advanced Popup Rules**
  - Show after X page views
  - Show once per session / per day / per week / always
  - Cookie-based tracking
  - Hide for logged-in users
  - Device-specific (desktop/mobile)
  - Show on specific pages (Display Conditions)
  - A/B testing (multiple popup variants)

#### 8.2 Conversion Tools
- [ ] **Form Integrations**
  - Mailchimp, ConvertKit, ActiveCampaign
  - Webhook support
  - Zapier integration

- [ ] **Countdown Timer** (Scarcity)
  - Evergreen countdown (resets per user)
  - Fixed deadline
  - Show/hide element on expire

- [ ] **Sticky Bar** (Announcement)
  - Top or bottom sticky bar
  - Close button
  - Display conditions
  - Cookie remember closed state

---

### 9. Kütüphane ve Dışa Aktarım

#### 9.1 Template Library
- [ ] **Local Library**
  - Save page as template
  - Save section/widget as block
  - Organize in folders/categories
  - Search & filter
  - Thumbnail preview
  - Template metadata (date, author, tags)

- [ ] **Cloud Library** (Optional)
  - Pre-made templates
  - Categories: landing page, homepage, about, contact, shop, blog, etc.
  - One-click import
  - Regular updates

- [ ] **Template Kits**
  - Collections of related templates
  - Import entire kit at once

#### 9.2 Export/Import
- [ ] **Export**
  - Export page as JSON
  - Export template as JSON
  - Export all settings as JSON
  - Export with/without content (structure only)

- [ ] **Import**
  - Import JSON template/page
  - Validate JSON structure
  - Handle missing widgets (fallback)
  - Import from URL
  - Import from file upload

- [ ] **Cross-Site Copy-Paste**
  - Copy from site A
  - Paste to site B (via JSON in clipboard)

#### 9.3 Blocks & Pre-made Content
- [ ] **Block Categories**
  - Hero sections
  - Features sections
  - Call-to-Action
  - Team sections
  - Testimonials
  - Pricing tables
  - FAQs
  - Footers
  - Headers
  - 404 pages
  - Contact forms
  - Gallery sections

- [ ] **Page Templates**
  - Homepage designs (10+ variants)
  - About page
  - Services page
  - Contact page
  - Blog listing & single post
  - Shop & product pages
  - Landing pages (leads, sales, webinar)

---

## 🚀 Phased Implementation Roadmap

### Phase 1: Foundation & Core Architecture (Week 1-2)
**Goal**: Sağlam bir frontend ve backend temeli oluşturmak

#### Backend Tasks
- [ ] Database schema expansion
  - `pages` table enhancements (add `revision_history`, `template_type`)
  - `templates` table (id, name, type, structure_json, thumbnail, category)
  - `global_settings` table (site-wide colors, fonts, styles)
  - `revisions` table (page_id, structure_json, created_at)

- [ ] API Endpoints (Laravel Controllers & Routes)
  - `GET /api/pages/{id}` - Fetch page data
  - `PUT /api/pages/{id}` - Update page
  - `POST /api/pages` - Create page
  - `GET /api/templates` - List templates
  - `POST /api/templates` - Save template
  - `GET /api/global-settings` - Fetch global settings
  - `PUT /api/global-settings` - Update global settings

- [ ] BuilderService enhancements
  - Refactor to support Container (Flexbox/Grid)
  - Dynamic widget registration system
  - Style generation improvements (support for all CSS properties)

#### Frontend Tasks
- [ ] **Choose Frontend Framework**: Vue 3 + Composition API (recommended) veya React
  - Install dependencies: `npm install vue@3 @vitejs/plugin-vue pinia`
  - Setup Vite config for Vue

- [ ] **Editor UI Structure**
  - Left Panel: Widget list (drag source)
  - Center Canvas: Live preview (drop zone)
  - Right Panel: Settings panel (contextual)
  - Top Bar: Save, Preview, Responsive switcher, Undo/Redo

- [ ] **State Management** (Pinia for Vue or Zustand/Redux for React)
  - `pageStore`: current page data, selected element, history stack
  - `settingsStore`: global settings
  - `uiStore`: panel visibility, responsive mode, loading states

- [ ] **Drag & Drop System**
  - Use library: `@shopify/draggable` or `vue-draggable` (Vue) / `react-beautiful-dnd` (React)
  - Drag widgets from left panel
  - Drop into canvas sections/containers
  - Ghost/placeholder during drag
  - Drop validation (can't drop section inside widget)

**Deliverable**:
- Sürükle-bırak ile Section > Container > Widget eklenebilen temel editor
- Element seçimi ve basit ayarlar paneli
- Save/Load functionality

---

### Phase 2: Container System & Layout (Week 3-4)
**Goal**: Modern Flexbox/Grid tabanlı layout sistemi

#### Features
- [ ] **Container Widget** (modern layout sistemi)
  - Flexbox mode tam implementasyonu
    - Direction, Justify, Align, Gap, Wrap ayarları
    - Visual preview in settings panel (diagram)
  - CSS Grid mode başlangıç (basic grid-template-columns)

- [ ] **Sizing & Spacing Controls**
  - Width, Height, Min/Max controls
  - Padding, Margin editors (linked/unlinked)
  - Unit selector (px, %, em, rem, vw, vh)
  - Responsive values (farklı değer her cihaz için)

- [ ] **Positioning**
  - Position: relative, absolute, fixed, sticky
  - Z-Index control
  - Overflow control

- [ ] **HTML Tag Selector**
  - Select semantic HTML tag (div, section, article, etc.)
  - Custom CSS class input
  - Custom ID input

**Deliverable**:
- Flexbox/Grid ile istediğiniz layout oluşturabilme
- Responsive layout (desktop/tablet/mobile farklı ayarlar)

---

### Phase 3: Styling System - Typography & Colors (Week 5-6)
**Goal**: Tam teşekküllü tipografi ve renk sistemi

#### Features
- [ ] **Global Settings (Site Settings)**
  - Color palette manager (8-10 renkli palet)
  - Typography presets (H1-H6, body, button)
  - Default button styles
  - Global custom CSS

- [ ] **Typography Controls**
  - Font family selector (Google Fonts API integration)
  - Size, Weight, Style, Transform, Decoration
  - Line-height, Letter-spacing, Word-spacing
  - Text shadow
  - Responsive font sizes

- [ ] **Color System**
  - Color picker component (HEX, RGB, HSL)
  - Opacity slider
  - Global palette integration
  - Recent colors

- [ ] **Background System - Part 1**
  - Solid color
  - Single image (upload, position, size, repeat)
  - Gradient (linear, radial) with color stops

**Deliverable**:
- Google Fonts entegrasyonu
- Global color palette kullanımı
- Tam tipografi kontrolü

---

### Phase 4: Advanced Styling - Backgrounds & Effects (Week 7-8)
**Goal**: Video arkaplan, shape dividers, filters

#### Features
- [ ] **Background System - Part 2**
  - Video background (YouTube, Vimeo, self-hosted)
    - Fallback image for mobile
    - Mute/unmute, loop controls
  - Slideshow background (multi-image carousel)
    - Transition effects
    - Ken Burns effect (zoom & pan)
  - Background overlay (color/gradient over background)

- [ ] **Borders & Shadows**
  - Border: type, width, color, radius (per-corner)
  - Box shadow: inner/outer, multiple shadows, presets
  - Outline (separate from border)

- [ ] **Shape Dividers**
  - Built-in SVG shapes library (waves, curves, etc.)
  - Position: top, bottom
  - Height, color, flip controls
  - Custom SVG upload

- [ ] **CSS Filters**
  - Blur, Brightness, Contrast, Saturation, Hue, Grayscale, Sepia, Invert sliders
  - Real-time preview

- [ ] **Blend Modes & Masks**
  - Mix-blend-mode selector
  - Mask shapes (circle, triangle, custom SVG)

**Deliverable**:
- Video arkaplan özelliği
- Shape dividers ile modern tasarımlar
- Filter ve mask efektleri

---

### Phase 5: Motion Effects & Animations (Week 9-10)
**Goal**: Entrance animations, scroll effects, hover effects

#### Features
- [ ] **Entrance Animations**
  - Animation library (Animate.css integration or custom)
  - 50+ animation options (fadeIn, slideIn, zoomIn, bounce, etc.)
  - Duration, delay, easing controls

- [ ] **Scroll Effects**
  - Intersection Observer API kullanarak scroll tracking
  - Vertical/Horizontal parallax
  - Transparency fade on scroll
  - Blur, rotate, scale on scroll
  - Trigger offset control

- [ ] **Mouse Effects**
  - Mouse track (element follows cursor)
  - 3D Tilt effect (tilt.js integration)

- [ ] **Sticky (Position Sticky)**
  - Sticky top/bottom
  - Offset control
  - Effects on sticky (shrink, shadow, etc.)

- [ ] **Hover Effects**
  - Hover color change (background, text, border)
  - Hover shadow, transform
  - Transition duration & easing

**Deliverable**:
- Sayfaya giriş animasyonları
- Scroll-based parallax ve effects
- Hover interactions

---

### Phase 6: Widget Library Expansion (Week 11-14)
**Goal**: Tüm basic ve pro widgetları eklemek

#### Week 11-12: Basic Widgets Completion
- [ ] Google Maps widget
- [ ] Icon widget (icon library: Font Awesome / Heroicons)
- [ ] Icon List, Icon Box
- [ ] Star Rating
- [ ] Image Box
- [ ] Social Icons
- [ ] Alert, Progress Bar, Counter
- [ ] Tabs, Accordion, Toggle

#### Week 13-14: Pro Widgets - Part 1
- [ ] Posts widget (blog post grid/list)
  - Query builder (category, tag, author filters)
  - Pagination, Load More
  - Custom card design with Loop Builder

- [ ] Gallery widget
  - Masonry, Grid, Justified layout
  - Lightbox (PhotoSwipe or Fancybox)

- [ ] Form Builder
  - Drag & drop form fields
  - Validation rules
  - Email notification
  - Success/error messages
  - Third-party integrations (Mailchimp webhook)

- [ ] Login widget
- [ ] Slides (Carousel) widget
  - Swiper.js integration
  - Per-slide content editing

**Deliverable**:
- 20+ basic widgets
- Blog post query & display
- Form builder

---

### Phase 7: Advanced Widgets & E-commerce (Week 15-18)
**Goal**: Advanced widgets, WooCommerce integration (or custom e-commerce)

#### Week 15-16: Pro Widgets - Part 2
- [ ] Nav Menu (mega menu)
- [ ] Animated Headline (text effects)
- [ ] Price List & Price Table
- [ ] Flip Box (3D flip effect)
- [ ] Call to Action (CTA box)
- [ ] Testimonial & Testimonial Carousel
- [ ] Countdown Timer (fixed & evergreen)
- [ ] Share Buttons
- [ ] Blockquote
- [ ] Lottie animation player
- [ ] Code Highlight (Prism.js)
- [ ] Table of Contents (auto-generate from headings)
- [ ] Hotspot (image annotations)

#### Week 17-18: E-commerce Widgets
**IF using WooCommerce:**
- [ ] Product Image, Title, Price, Rating
- [ ] Add to Cart button
- [ ] Product Meta, Content, Short Description
- [ ] Product Tabs
- [ ] Upsells, Related Products
- [ ] Products Grid
  - WooCommerce query (category, tag, on-sale, featured)
  - Custom product card design
- [ ] Menu Cart (mini cart in header)
- [ ] Cart page, Checkout page widgets
- [ ] My Account widgets

**IF using custom e-commerce:**
- [ ] Design custom product model & migrations
- [ ] Product CRUD APIs
- [ ] Product widgets similar to WooCommerce

**Deliverable**:
- Tüm advanced widgets
- E-commerce entegrasyonu veya custom product system

---

### Phase 8: Dynamic Content & Theme Builder (Week 19-22)
**Goal**: Dynamic tags, display conditions, loop builder, global widgets

#### Features
- [ ] **Dynamic Tags System**
  - Tag registry (Site, Post, Author, User tags)
  - Dynamic tag selector in widget settings
  - Render engine (replace tag with actual data)
  - ACF/Custom Fields integration (optional)

- [ ] **Display Conditions**
  - Condition builder UI (AND/OR logic)
  - Location rules (entire site, home, post, page, etc.)
  - User conditions (logged in, role)
  - Device conditions (desktop, tablet, mobile)
  - Date/Time conditions

- [ ] **Loop Builder**
  - Design custom post/product card
  - Use in Posts widget, Products Grid
  - Dynamic tags inside loop template

- [ ] **Global Widgets**
  - Save widget as global
  - Edit once, updates everywhere
  - Unlink option

- [ ] **Template System**
  - Template types: Page, Header, Footer, Single Post, Archive, Product, Popup, 404
  - Template library (user-created templates)
  - Display conditions per template
  - Template preview with real data

**Deliverable**:
- Header/Footer builder
- Single post template builder
- Blog archive template
- E-commerce product template (if applicable)
- Dynamic content everywhere

---

### Phase 9: Editor UX Enhancements (Week 23-25)
**Goal**: Navigator, Finder, History/Revisions, Responsive mode, Context menu

#### Features
- [ ] **Navigator (Layers Panel)**
  - Tree view of page structure
  - Drag to reorder in tree
  - Show/hide elements (eye icon)
  - Lock elements (lock icon)
  - Expand/collapse nodes
  - Search elements by name

- [ ] **Finder (Quick Search)**
  - Keyboard shortcut (Cmd/Ctrl + E)
  - Search pages, widgets, settings, templates
  - Fuzzy search

- [ ] **History & Revisions**
  - History panel (undo/redo list, last 50 actions)
  - Revision snapshots (auto-save every 5 min)
  - Revision comparison UI
  - Restore to previous revision

- [ ] **Responsive Mode Switcher**
  - Desktop, Tablet, Mobile preview in canvas
  - Per-device settings (hide on mobile, different font size, etc.)
  - Responsive visibility toggle per widget

- [ ] **Right-Click Context Menu**
  - Copy, Paste, Paste Style
  - Duplicate, Delete
  - Copy to other page
  - Save as template
  - Lock/unlock

- [ ] **Copy & Paste Between Pages/Sites**
  - Clipboard manager (store JSON)
  - Cross-domain paste (export/import JSON via clipboard)

- [ ] **Inline Editing**
  - Click text to edit without opening panel
  - Formatting toolbar (bold, italic, link)

- [ ] **Keyboard Shortcuts**
  - Save (Cmd/Ctrl + S)
  - Undo/Redo (Cmd/Ctrl + Z / Shift+Z)
  - Copy/Paste (Cmd/Ctrl + C/V)
  - Delete (Del/Backspace)
  - Duplicate (Cmd/Ctrl + D)
  - Find (Cmd/Ctrl + F)

**Deliverable**:
- Navigator panel
- Finder search
- Full history & revisions
- Complete responsive editor
- Keyboard shortcuts

---

### Phase 10: Popups & Marketing Tools (Week 26-27)
**Goal**: Popup builder with triggers, conversion tools

#### Features
- [ ] **Popup Builder**
  - Design popup like a page (full builder)
  - Popup size, position, overlay settings
  - Close button style & position

- [ ] **Popup Triggers**
  - On page load (delay)
  - On scroll (%)
  - On scroll to element
  - On click (bind to button via selector)
  - After inactivity (X seconds)
  - On exit intent (mouse leaves viewport)

- [ ] **Advanced Popup Rules**
  - Show once per session / per day / always
  - Cookie-based frequency control
  - Hide for logged-in users
  - Device-specific display
  - Display conditions (same as templates)

- [ ] **Conversion Tools**
  - Form integrations (Mailchimp, ConvertKit, Webhook)
  - Evergreen countdown timer
  - Sticky announcement bar (top/bottom)

**Deliverable**:
- Popup builder
- Trigger system
- Conversion-optimized tools

---

### Phase 11: Template Library & Export/Import (Week 28-29)
**Goal**: Template library, import/export, pre-made blocks

#### Features
- [ ] **Local Template Library**
  - Save page/section/widget as template
  - Organize in folders
  - Search & filter
  - Thumbnail preview
  - Insert template to page (one-click)

- [ ] **Export/Import**
  - Export page/template as JSON
  - Import from JSON file/URL
  - Export all settings
  - Validation on import

- [ ] **Pre-made Block Library**
  - 50+ pre-designed blocks
  - Categories: Hero, Features, CTA, Team, Testimonials, Pricing, FAQ, Footer, Header, etc.
  - One-click insert
  - Customizable after insert

- [ ] **Template Kits**
  - Collections of templates (e.g., "Agency Kit", "E-commerce Kit")
  - Import entire kit at once

**Deliverable**:
- Template library UI
- Export/Import functionality
- 50+ pre-made blocks

---

### Phase 12: Developer Tools & Optimizations (Week 30-32)
**Goal**: Custom CSS/JS, role manager, maintenance mode, performance

#### Features
- [ ] **Custom CSS**
  - Per-element custom CSS (with `{{WRAPPER}}` placeholder)
  - Global custom CSS
  - Syntax highlighting (CodeMirror or Monaco Editor)

- [ ] **Custom JavaScript**
  - Per-page JS
  - Global JS
  - Head/Body injection points

- [ ] **Custom Attributes**
  - Add `data-*` attributes
  - ARIA attributes for accessibility

- [ ] **Role Manager**
  - Define who can access editor (by role)
  - Feature restrictions per role
  - Template library access per role

- [ ] **Maintenance Mode**
  - Enable/disable toggle
  - Custom maintenance page design
  - Exclude roles & IPs

- [ ] **Debug Mode**
  - Show element IDs, CSS classes
  - Performance metrics (render time, element count)
  - Error console

- [ ] **Performance Optimizations**
  - Lazy load images
  - Minify generated CSS
  - Critical CSS extraction
  - Caching strategy (Redis/Memcached)
  - CDN integration for assets

- [ ] **API / Hooks System**
  - Laravel events: `PageBeforeRender`, `PageAfterSave`, etc.
  - Custom widget registration API
  - Headless mode (API endpoint for JSON)

**Deliverable**:
- Developer-friendly features
- Role-based access control
- Maintenance mode
- Optimized performance

---

### Phase 13: Polish, Testing & Documentation (Week 33-36)
**Goal**: Bug fixes, UX polish, comprehensive testing, documentation

#### Tasks
- [ ] **Cross-browser Testing**
  - Test on Chrome, Firefox, Safari, Edge
  - Fix browser-specific issues

- [ ] **Responsive Testing**
  - Test all widgets on mobile, tablet, desktop
  - Fix layout issues

- [ ] **Accessibility (A11y)**
  - Keyboard navigation in editor
  - ARIA labels
  - Screen reader compatibility
  - WCAG 2.1 AA compliance check

- [ ] **Performance Testing**
  - Page load time optimization
  - Lighthouse audit (aim for 90+ score)
  - Reduce JS bundle size (code splitting, lazy loading)

- [ ] **User Testing**
  - Conduct usability tests with real users
  - Gather feedback
  - Iterate based on feedback

- [ ] **Documentation**
  - User guide (how to use editor, widgets, etc.)
  - Video tutorials (basic & advanced)
  - Developer documentation (API, hooks, custom widgets)
  - FAQ section

- [ ] **Localization (i18n)**
  - Multi-language support for editor UI
  - Translation files (English, Turkish, etc.)

**Deliverable**:
- Polished, production-ready page builder
- Comprehensive documentation
- Video tutorials

---

## 📐 Technical Architecture

### Frontend Architecture (Vue 3 Recommendation)

```
/resources/js/
├── builder/
│   ├── main.js                 # Vue app entry point
│   ├── App.vue                 # Root component
│   ├── components/
│   │   ├── Editor/
│   │   │   ├── Canvas.vue      # Main drag-drop canvas
│   │   │   ├── LeftPanel.vue   # Widget list
│   │   │   ├── RightPanel.vue  # Settings panel
│   │   │   ├── TopBar.vue      # Save, preview, responsive switcher
│   │   │   ├── Navigator.vue   # Layers tree
│   │   │   └── Finder.vue      # Quick search
│   │   ├── Widgets/
│   │   │   ├── Heading.vue
│   │   │   ├── Text.vue
│   │   │   ├── Button.vue
│   │   │   └── ... (50+ widget components)
│   │   ├── Controls/
│   │   │   ├── ColorPicker.vue
│   │   │   ├── FontPicker.vue
│   │   │   ├── SpacingControl.vue
│   │   │   ├── ResponsiveControl.vue
│   │   │   └── ... (reusable setting controls)
│   │   └── Shared/
│   │       ├── Modal.vue
│   │       ├── Dropdown.vue
│   │       └── Tooltip.vue
│   ├── stores/
│   │   ├── pageStore.js        # Page data, history, undo/redo
│   │   ├── settingsStore.js    # Global settings
│   │   └── uiStore.js          # UI state (panels, responsive mode)
│   ├── utils/
│   │   ├── dragDrop.js         # Drag & drop logic
│   │   ├── styleGenerator.js   # CSS generation
│   │   ├── dynamicTags.js      # Dynamic tag resolver
│   │   └── api.js              # API calls to Laravel backend
│   └── composables/
│       ├── useHistory.js       # Undo/redo composable
│       ├── useResponsive.js    # Responsive mode composable
│       └── useDynamicTags.js   # Dynamic tags composable
```

### Backend Architecture (Laravel)

```
/app/
├── Models/
│   ├── Page.php
│   ├── Template.php
│   ├── Revision.php
│   └── GlobalSetting.php
├── Http/Controllers/
│   ├── PageBuilderController.php
│   ├── TemplateController.php
│   ├── GlobalSettingsController.php
│   └── MediaController.php
├── Services/
│   ├── BuilderService.php      # Render engine
│   ├── DynamicTagService.php   # Dynamic tag resolver
│   ├── StyleService.php        # CSS generation
│   └── WidgetRegistry.php      # Widget management
└── Events/
    ├── PageSaved.php
    ├── PageBeforeRender.php
    └── PageAfterRender.php

/database/migrations/
├── 2025_xx_xx_create_pages_table.php
├── 2025_xx_xx_create_templates_table.php
├── 2025_xx_xx_create_revisions_table.php
├── 2025_xx_xx_create_global_settings_table.php
└── 2025_xx_xx_create_products_table.php  # If custom e-commerce

/routes/
├── api.php                     # API routes for builder
└── web.php                     # Frontend routes
```

### Database Schema

```sql
-- pages table
CREATE TABLE pages (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  slug VARCHAR(255) UNIQUE,
  layout_data JSON,
  template_type ENUM('page', 'header', 'footer', 'single', 'archive', 'product', 'popup', '404') DEFAULT 'page',
  display_conditions JSON,  -- Conditions for when to show this template
  status ENUM('draft', 'published') DEFAULT 'draft',
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);

-- templates table (saved designs)
CREATE TABLE templates (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  type ENUM('page', 'section', 'widget', 'block', 'kit'),
  structure_json JSON,
  thumbnail VARCHAR(255),  -- Preview image
  category VARCHAR(100),   -- hero, footer, pricing, etc.
  tags JSON,               -- Searchable tags
  is_global BOOLEAN DEFAULT FALSE,  -- For global widgets
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);

-- revisions table (version history)
CREATE TABLE revisions (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  page_id BIGINT,
  structure_json JSON,
  created_by BIGINT,       -- User ID
  created_at TIMESTAMP,
  FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
);

-- global_settings table
CREATE TABLE global_settings (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  key VARCHAR(255) UNIQUE,  -- e.g., 'color_palette', 'typography_presets'
  value JSON,
  updated_at TIMESTAMP
);

-- products table (if custom e-commerce)
CREATE TABLE products (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  slug VARCHAR(255) UNIQUE,
  price DECIMAL(10, 2),
  sale_price DECIMAL(10, 2),
  description TEXT,
  short_description TEXT,
  sku VARCHAR(100),
  stock INT,
  images JSON,  -- Array of image URLs
  category_id BIGINT,
  status ENUM('draft', 'published') DEFAULT 'draft',
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

---

## 🎯 Priority Matrix

| Özellik Grubu | Öncelik | Complexity | Impact |
|---------------|---------|------------|--------|
| Drag & Drop System | 🔴 Critical | High | High |
| Container (Flexbox/Grid) | 🔴 Critical | High | High |
| Basic Widgets | 🔴 Critical | Medium | High |
| Styling (Typography, Colors, Backgrounds) | 🔴 Critical | Medium | High |
| Responsive Mode | 🟠 High | Medium | High |
| Animations & Motion Effects | 🟠 High | Medium | Medium |
| Advanced Widgets (Form, Posts, Gallery) | 🟠 High | High | High |
| Dynamic Tags & Theme Builder | 🟠 High | High | High |
| Navigator & History | 🟡 Medium | Medium | Medium |
| Popup Builder | 🟡 Medium | Medium | Medium |
| Template Library | 🟡 Medium | Medium | Medium |
| E-commerce Widgets | 🟡 Medium (if needed) | High | High (for e-commerce) |
| Global Widgets | 🟢 Low | Low | Medium |
| Maintenance Mode | 🟢 Low | Low | Low |
| Debug Mode | 🟢 Low | Low | Low |

---

## ⏱️ Estimated Timeline

**Total Timeline**: 36 weeks (~9 months)

- **Phases 1-5**: Foundation, Layout, Styling, Effects (10 weeks)
- **Phases 6-7**: Widget Library & E-commerce (8 weeks)
- **Phases 8-10**: Dynamic Content, UX, Popups (9 weeks)
- **Phases 11-13**: Templates, Developer Tools, Polish (9 weeks)

**Team Size Impact**:
- Solo developer: 36 weeks (full-time)
- 2 developers: 20-24 weeks
- 3-4 developers: 14-18 weeks

---

## 🛠️ Technology Recommendations

### Frontend
- **Framework**: Vue 3 (Composition API) - lightweight, reactive, great ecosystem
- **Alternative**: React 18 - larger ecosystem, more libraries
- **Drag & Drop**: `@shopify/draggable`, `vue-draggable-next`, or `react-beautiful-dnd`
- **UI Components**: Headless UI (Tailwind), Radix UI (React), or custom with Tailwind
- **State Management**: Pinia (Vue), Zustand (React)
- **Rich Text Editor**: Quill, TinyMCE, or Lexical (for inline editing)
- **Animation**: GSAP, Animate.css, Framer Motion (React)
- **Carousel**: Swiper.js
- **Lightbox**: PhotoSwipe, Fancybox
- **Syntax Highlighting**: Prism.js, Highlight.js
- **Lottie**: lottie-web

### Backend
- **Framework**: Laravel 12 (already set up)
- **Database**: PostgreSQL (better JSON support) or MySQL 8+
- **Caching**: Redis (for sessions, page cache, revisions)
- **Queue**: Redis queue (for heavy processing like template exports, email sends)
- **Storage**: AWS S3 or local storage for media

### DevOps
- **Version Control**: Git (GitHub/GitLab)
- **CI/CD**: GitHub Actions, GitLab CI
- **Deployment**: Docker, Laravel Forge, or custom VPS
- **Monitoring**: Sentry (error tracking), New Relic/Scout (performance)

---

## 🚀 Next Steps

1. **Review & Approve Roadmap**: Sizin onayınız ile başlıyoruz
2. **Setup Development Environment**:
   - Vue 3 + Vite + Pinia kurulumu
   - Tailwind CSS v4 config
   - Laravel API routes setup
3. **Start Phase 1**:
   - Database migrations
   - Basic editor UI skeleton
   - Simple drag & drop POC (Proof of Concept)

---

## 📚 Referanslar

- [Elementor Official Site](https://elementor.com/)
- [GrapesJS](https://grapesjs.com/) - Open-source page builder inspiration
- [Craft.js](https://craft.js.org/) - React page builder library
- [Vue Draggable](https://github.com/SortableJS/vue.draggable.next)
- [Tailwind CSS](https://tailwindcss.com/)
- [Laravel 12 Docs](https://laravel.com/docs/12.x)

---

## 📝 Notes

- Bu roadmap **çok kapsamlı** bir projedir. Her özelliği eklemek yerine, **MVP (Minimum Viable Product)** yaklaşımı ile başlamak daha mantıklı olabilir.
- **Phase 1-5** temel özellikleri kapsıyor ve kullanılabilir bir editor sağlıyor (10 hafta).
- **E-commerce özellikleri** (Phase 7) projeniz için kritikse öncelik verilmeli.
- **Phase 8 (Dynamic Content & Theme Builder)** size Elementor gibi "header/footer builder" ve "single post template" özelliklerini verecek.

---

Bu döküman sizin **Master Roadmap**'iniz. Her phase'i tamamladıkça işaretleyebilir, ihtiyaca göre sıra değiştirebilirsiniz. Başlamak için onay verirseniz, **Phase 1**'den başlayalım! 🚀
