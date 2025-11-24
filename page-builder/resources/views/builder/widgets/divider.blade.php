@php
    $styleProps = [
        'border-color' => $settings['color'] ?? '#dee2e6',
        'border-width' => $settings['thickness'] ?? '1px',
        'border-style' => $settings['style'] ?? 'solid',
        'margin-top' => $settings['marginTop'] ?? '20px',
        'margin-bottom' => $settings['marginBottom'] ?? '20px',
        'opacity' => '1',
    ];
    
    $style = collect($styleProps)
        ->filter(fn($value) => !empty($value))
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
@endphp

<hr class="builder-widget-divider" data-id="{{ $id }}" style="{{ $style }}; border-top: 0;">
