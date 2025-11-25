<?php

namespace App\Http\Controllers;

use App\Models\Page;
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
     * Sayfa sil
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('builder.index')
            ->with('success', 'Sayfa silindi!');
    }
}