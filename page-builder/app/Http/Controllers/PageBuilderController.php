<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\GlobalSettings;
use App\Services\BuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageBuilderController extends Controller
{
    public function __construct(
        protected BuilderService $builderService
    ) {}

    /**
     * Sayfa listesi
     */
    public function index()
    {
        $pages = Page::orderBy('updated_at', 'desc')->get();
        return view('builder.index', compact('pages'));
    }

    /**
     * Vue Builder App
     */
    public function app()
    {
        return view('builder.app');
    }

    /**
     * API: Get all pages
     */
    public function indexApi()
    {
        $pages = Page::orderBy('updated_at', 'desc')->get();
        return response()->json($pages);
    }

    /**
     * API: Get page data
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return response()->json($page);
    }

    /**
     * API: Create new page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'layout_data' => 'nullable|array',
            'status' => 'nullable|in:draft,published',
        ]);

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']) . '-' . Str::random(6),
            'layout_data' => $validated['layout_data'] ?? $this->builderService->getDefaultLayout(),
            'status' => $validated['status'] ?? 'draft',
        ]);

        return response()->json($page, 201);
    }

    /**
     * API: Update page
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'layout_data' => 'nullable|array',
            'status' => 'nullable|in:draft,published',
        ]);

        $page->update(array_filter($validated));

        return response()->json($page);
    }

    /**
     * Yeni sayfa oluştur
     */
    public function create()
    {
        $page = Page::create([
            'title' => 'Yeni Sayfa',
            'slug' => 'yeni-sayfa-' . Str::random(6),
            'layout_data' => $this->builderService->getDefaultLayout(),
            'status' => 'draft',
        ]);

        return redirect()->route('builder.editor', $page->id);
    }

    /**
     * Editor arayüzü
     */
    public function editor(Page $page)
    {
        $layoutData = $page->layout_data ?? $this->builderService->getDefaultLayout();

        return view('builder.editor', [
            'page' => $page,
            'layoutData' => $layoutData,
            'layoutJson' => json_encode($layoutData),
        ]);
    }

    /**
     * AJAX ile kaydet
     */
    public function save(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'layout_data' => 'required|array',
        ]);

        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . $page->id,
            'layout_data' => $validated['layout_data'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sayfa başarıyla kaydedildi!',
        ]);
    }

    /**
     * Ön izleme
     */
    public function preview(Page $page)
    {
        $layoutData = $page->layout_data ?? [];
        $renderedHtml = $this->builderService->render($layoutData);

        return view('builder.preview', [
            'page' => $page,
            'content' => $renderedHtml,
        ]);
    }

    /**
     * JSON Export
     */
    public function export(Page $page)
    {
        $filename = Str::slug($page->title) . '-template.json';

        return response()->json($page->layout_data)
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }

    /**
     * JSON Import
     */
    public function import(Request $request, Page $page)
    {
        $request->validate([
            'template_file' => 'required|file|mimes:json',
        ]);

        $content = file_get_contents($request->file('template_file')->path());
        $layoutData = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->with('error', 'Geçersiz JSON dosyası!');
        }

        $page->update(['layout_data' => $layoutData]);

        return redirect()->route('builder.editor', $page->id)
            ->with('success', 'Template başarıyla import edildi!');
    }

    /**
     * Sayfa sil (API & Web)
     */
    public function destroy(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        // API request - return JSON
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Page deleted successfully',
            ]);
        }

        // Web request - redirect
        return redirect()->route('builder.index')
            ->with('success', 'Sayfa silindi!');
    }

    /**
     * API: Get global settings
     */
    public function getGlobalSettings()
    {
        $defaultSettings = [
            'colorPalette' => [
                ['name' => 'Primary', 'value' => '#4F46E5'],
                ['name' => 'Secondary', 'value' => '#10B981'],
                ['name' => 'Accent', 'value' => '#F59E0B'],
                ['name' => 'Dark', 'value' => '#1F2937'],
                ['name' => 'Light', 'value' => '#F3F4F6'],
                ['name' => 'Success', 'value' => '#10B981'],
                ['name' => 'Warning', 'value' => '#F59E0B'],
                ['name' => 'Error', 'value' => '#EF4444'],
            ],
            'typographyPresets' => [
                'h1' => ['fontFamily' => 'Inter', 'fontSize' => '48px', 'fontWeight' => '700', 'lineHeight' => '1.2'],
                'h2' => ['fontFamily' => 'Inter', 'fontSize' => '40px', 'fontWeight' => '700', 'lineHeight' => '1.3'],
                'h3' => ['fontFamily' => 'Inter', 'fontSize' => '32px', 'fontWeight' => '600', 'lineHeight' => '1.3'],
                'h4' => ['fontFamily' => 'Inter', 'fontSize' => '24px', 'fontWeight' => '600', 'lineHeight' => '1.4'],
                'h5' => ['fontFamily' => 'Inter', 'fontSize' => '20px', 'fontWeight' => '600', 'lineHeight' => '1.4'],
                'h6' => ['fontFamily' => 'Inter', 'fontSize' => '16px', 'fontWeight' => '600', 'lineHeight' => '1.5'],
                'body' => ['fontFamily' => 'Inter', 'fontSize' => '16px', 'fontWeight' => '400', 'lineHeight' => '1.6'],
                'button' => ['fontFamily' => 'Inter', 'fontSize' => '14px', 'fontWeight' => '500', 'lineHeight' => '1.5'],
            ],
            'selectedFonts' => ['Inter', 'Roboto', 'Open Sans'],
        ];

        $settings = GlobalSettings::getAll();

        return response()->json([
            'colorPalette' => $settings['colorPalette'] ?? $defaultSettings['colorPalette'],
            'typographyPresets' => $settings['typographyPresets'] ?? $defaultSettings['typographyPresets'],
            'selectedFonts' => $settings['selectedFonts'] ?? $defaultSettings['selectedFonts'],
        ]);
    }

    /**
     * API: Update global settings
     */
    public function updateGlobalSettings(Request $request)
    {
        $validated = $request->validate([
            'colorPalette' => 'nullable|array',
            'colorPalette.*.name' => 'required|string',
            'colorPalette.*.value' => 'required|string',
            'typographyPresets' => 'nullable|array',
            'selectedFonts' => 'nullable|array',
        ]);

        // Save each setting separately
        if (isset($validated['colorPalette'])) {
            GlobalSettings::setValue('colorPalette', $validated['colorPalette']);
        }

        if (isset($validated['typographyPresets'])) {
            GlobalSettings::setValue('typographyPresets', $validated['typographyPresets']);
        }

        if (isset($validated['selectedFonts'])) {
            GlobalSettings::setValue('selectedFonts', $validated['selectedFonts']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Global settings saved successfully',
        ]);
    }

    /**
     * API: Get Google Fonts list
     */
    public function getGoogleFonts()
    {
        // Popular Google Fonts list (can be extended with real API call)
        // To use real Google Fonts API, add your API key to .env as GOOGLE_FONTS_API_KEY
        // and uncomment the code below

        /*
        $apiKey = env('GOOGLE_FONTS_API_KEY');
        if ($apiKey) {
            try {
                $response = Http::get("https://www.googleapis.com/webfonts/v1/webfonts?key={$apiKey}&sort=popularity");
                if ($response->successful()) {
                    $fonts = collect($response->json('items'))->take(100)->pluck('family')->toArray();
                    return response()->json(['fonts' => $fonts]);
                }
            } catch (\Exception $e) {
                // Fall back to static list
            }
        }
        */

        // Static list of popular Google Fonts (top 100+)
        $popularFonts = [
            'ABeeZee', 'Abel', 'Abril Fatface', 'Acme', 'Alegreya', 'Alegreya Sans', 'Alex Brush',
            'Alfa Slab One', 'Amatic SC', 'Amiri', 'Archivo', 'Archivo Black', 'Arimo', 'Arvo',
            'Assistant', 'Asap', 'Barlow', 'Bebas Neue', 'Bitter', 'Cabin', 'Cairo', 'Catamaran',
            'Caveat', 'Cinzel', 'Comfortaa', 'Commissioner', 'Cormorant', 'Courier Prime', 'Crimson Text',
            'DM Sans', 'DM Serif Display', 'Dancing Script', 'Dosis', 'EB Garamond', 'Exo', 'Exo 2',
            'Fira Sans', 'Figtree', 'Fjalla One', 'Francois One', 'Frank Ruhl Libre', 'Fredoka',
            'Great Vibes', 'Heebo', 'Hind', 'IBM Plex Mono', 'IBM Plex Sans', 'IBM Plex Serif',
            'Inconsolata', 'Indie Flower', 'Inter', 'Josefin Sans', 'Jost', 'Kalam', 'Kanit',
            'Karla', 'Lato', 'Libre Baskerville', 'Libre Franklin', 'Lobster', 'Lora', 'Manrope',
            'Marcellus', 'Maven Pro', 'Merriweather', 'Montserrat', 'Mukta', 'Mulish', 'Nanum Gothic',
            'Noticia Text', 'Noto Sans', 'Noto Sans JP', 'Noto Sans KR', 'Noto Serif', 'Nunito',
            'Nunito Sans', 'Old Standard TT', 'Open Sans', 'Oswald', 'Outfit', 'Overpass', 'Oxygen',
            'PT Sans', 'PT Serif', 'Pacifico', 'Paytone One', 'Permanent Marker', 'Playfair Display',
            'Plus Jakarta Sans', 'Poppins', 'Prompt', 'Public Sans', 'Questrial', 'Quicksand',
            'Raleway', 'Righteous', 'Roboto', 'Roboto Condensed', 'Roboto Flex', 'Roboto Mono',
            'Roboto Slab', 'Rokkitt', 'Rubik', 'Russo One', 'Sacramento', 'Saira', 'Saira Condensed',
            'Satisfy', 'Shadows Into Light', 'Signika', 'Signika Negative', 'Slabo 27px', 'Source Code Pro',
            'Source Sans Pro', 'Source Serif Pro', 'Space Grotesk', 'Space Mono', 'Spectral',
            'Tajawal', 'Teko', 'Titillium Web', 'Ubuntu', 'Varela Round', 'Vollkorn', 'Work Sans',
            'Yanone Kaffeesatz', 'Yantramanav', 'Zilla Slab'
        ];

        return response()->json(['fonts' => $popularFonts]);
    }
}