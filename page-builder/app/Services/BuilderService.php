<?php

namespace App\Services;

use Illuminate\Support\Str;

class BuilderService
{
    /**
     * JSON layout verisini HTML'e dönüştürür
     */
    public function render(array $layoutData): string
    {
        $html = '';

        foreach ($layoutData as $section) {
            $html .= $this->renderSection($section);
        }

        return $html;
    }

    /**
     * Section render
     */
    protected function renderSection(array $section): string
    {
        $settings = $section['settings'] ?? [];
        $style = $this->buildInlineStyle($settings);
        
        // Container class based on fullWidth setting
        $containerClass = !empty($settings['fullWidth']) ? 'container-fluid' : 'container';

        $columnsHtml = '';
        foreach ($section['columns'] ?? [] as $column) {
            $columnsHtml .= $this->renderColumn($column);
        }

        return view('builder.components.section', [
            'id' => $section['id'] ?? Str::uuid(),
            'style' => $style,
            'settings' => $settings,
            'containerClass' => $containerClass,
            'columnsHtml' => $columnsHtml,
        ])->render();
    }

    /**
     * Column render
     */
    protected function renderColumn(array $column): string
    {
        $widgetsHtml = '';
        foreach ($column['widgets'] ?? [] as $widget) {
            $widgetsHtml .= $this->renderWidget($widget);
        }

        // Get Bootstrap column class
        $colClass = $column['class'] ?? 'col-12';

        return view('builder.components.column', [
            'id' => $column['id'] ?? Str::uuid(),
            'class' => $colClass,
            'widgetsHtml' => $widgetsHtml,
        ])->render();
    }

    /**
     * Widget render - Dynamic Component Rendering
     */
    protected function renderWidget(array $widget): string
    {
        $type = $widget['type'] ?? 'text';
        $viewName = "builder.widgets.{$type}";

        // Widget view'ı var mı kontrol et
        if (!view()->exists($viewName)) {
            $viewName = 'builder.widgets.text'; // Fallback
        }

        return view($viewName, [
            'id' => $widget['id'] ?? Str::uuid(),
            'content' => $widget['content'] ?? '',
            'settings' => $widget['settings'] ?? [],
        ])->render();
    }

    /**
     * Settings array'den inline CSS üretir
     */
    protected function buildInlineStyle(array $settings): string
    {
        $styles = [];

        $mapping = [
            'backgroundColor' => 'background-color',
            'background' => 'background-color',
            'color' => 'color',
            'fontSize' => 'font-size',
            'fontWeight' => 'font-weight',
            'textAlign' => 'text-align',
            'lineHeight' => 'line-height',
            'letterSpacing' => 'letter-spacing',
            'paddingTop' => 'padding-top',
            'paddingRight' => 'padding-right',
            'paddingBottom' => 'padding-bottom',
            'paddingLeft' => 'padding-left',
            'marginTop' => 'margin-top',
            'marginRight' => 'margin-right',
            'marginBottom' => 'margin-bottom',
            'marginLeft' => 'margin-left',
            'borderRadius' => 'border-radius',
            'borderWidth' => 'border-width',
            'borderColor' => 'border-color',
            'borderStyle' => 'border-style',
            'width' => 'width',
            'maxWidth' => 'max-width',
            'minHeight' => 'min-height',
            'height' => 'height',
        ];

        foreach ($mapping as $key => $cssProperty) {
            if (!empty($settings[$key])) {
                $styles[] = "{$cssProperty}: {$settings[$key]}";
            }
        }

        return implode('; ', $styles);
    }

    /**
     * Boş sayfa için varsayılan layout
     */
    public function getDefaultLayout(): array
    {
        return [
            [
                'id' => 'section_' . Str::random(8),
                'type' => 'section',
                'settings' => [
                    'backgroundColor' => '#ffffff',
                    'paddingTop' => '80px',
                    'paddingBottom' => '80px',
                    'fullWidth' => false,
                ],
                'columns' => [
                    [
                        'id' => 'col_' . Str::random(8),
                        'class' => 'col-12',
                        'widgets' => [
                            [
                                'id' => 'widget_' . Str::random(8),
                                'type' => 'heading',
                                'content' => 'Hoş Geldiniz',
                                'settings' => [
                                    'tag' => 'h1',
                                    'color' => '#212529',
                                    'textAlign' => 'center',
                                    'fontSize' => '48px',
                                    'fontWeight' => '700',
                                    'marginBottom' => '20px',
                                ],
                            ],
                            [
                                'id' => 'widget_' . Str::random(8),
                                'type' => 'text',
                                'content' => '<p class="lead">Bu sayfa, Laravel Page Builder ile oluşturulmuştur. Sol taraftaki widget\'ları sürükleyip bırakarak sayfanızı tasarlayabilirsiniz.</p>',
                                'settings' => [
                                    'color' => '#6c757d',
                                    'textAlign' => 'center',
                                    'fontSize' => '18px',
                                    'lineHeight' => '1.8',
                                ],
                            ],
                            [
                                'id' => 'widget_' . Str::random(8),
                                'type' => 'button',
                                'content' => 'Başlayın',
                                'settings' => [
                                    'link' => '#',
                                    'btnClass' => 'btn-primary',
                                    'btnSize' => 'btn-lg',
                                    'textAlign' => 'center',
                                    'borderRadius' => '8px',
                                    'marginTop' => '20px',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
