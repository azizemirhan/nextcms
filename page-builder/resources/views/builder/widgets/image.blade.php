@php
    $styleProps = [
        'width' => $settings['width'] ?? '100%',
        'max-width' => $settings['maxWidth'] ?? null,
        'height' => $settings['height'] ?? null,
        'border-radius' => $settings['borderRadius'] ?? null,
        'margin-top' => $settings['marginTop'] ?? null,
        'margin-right' => $settings['marginRight'] ?? null,
        'margin-bottom' => $settings['marginBottom'] ?? null,
        'margin-left' => $settings['marginLeft'] ?? null,
    ];
    
    $style = collect($styleProps)
        ->filter(fn($value) => !empty($value) && $value !== '0')
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
        
    $wrapperStyle = '';
    if (!empty($settings['textAlign'])) {
        $wrapperStyle = "text-align: {$settings['textAlign']}";
    }
    
    $src = $content ?: 'https://via.placeholder.com/800x400?text=Görsel+Seçin';
    $alt = $settings['alt'] ?? 'Görsel';
@endphp

<div class="builder-widget-image" data-id="{{ $id }}" @if($wrapperStyle) style="{{ $wrapperStyle }}" @endif>
    <img src="{{ $src }}" alt="{{ $alt }}" class="img-fluid" @if($style) style="{{ $style }}" @endif>
</div>
