@php
    $btnClass = $settings['btnClass'] ?? 'btn-primary';
    $btnSize = $settings['btnSize'] ?? '';
    $link = $settings['link'] ?? '#';
    $textAlign = $settings['textAlign'] ?? 'left';
    
    $btnStyleProps = [
        'border-radius' => $settings['borderRadius'] ?? null,
    ];
    
    // Custom colors override btn class
    if (!empty($settings['backgroundColor'])) {
        $btnStyleProps['background-color'] = $settings['backgroundColor'];
        $btnStyleProps['border-color'] = $settings['backgroundColor'];
    }
    if (!empty($settings['color'])) {
        $btnStyleProps['color'] = $settings['color'];
    }
    
    $btnStyle = collect($btnStyleProps)
        ->filter(fn($value) => !empty($value))
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
    
    $wrapperStyleProps = [
        'text-align' => $textAlign,
        'margin-top' => $settings['marginTop'] ?? null,
        'margin-bottom' => $settings['marginBottom'] ?? null,
    ];
    
    $wrapperStyle = collect($wrapperStyleProps)
        ->filter(fn($value) => !empty($value) && $value !== '0')
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
@endphp

<div class="builder-widget-button" data-id="{{ $id }}" @if($wrapperStyle) style="{{ $wrapperStyle }}" @endif>
    <a href="{{ $link }}" class="btn {{ $btnClass }} {{ $btnSize }}" @if($btnStyle) style="{{ $btnStyle }}" @endif>
        {{ $content ?: 'Buton' }}
    </a>
</div>
