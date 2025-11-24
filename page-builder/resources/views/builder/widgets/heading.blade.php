@php
    $tag = $settings['tag'] ?? 'h2';
    
    $styleProps = [
        'color' => $settings['color'] ?? null,
        'font-size' => $settings['fontSize'] ?? null,
        'font-weight' => $settings['fontWeight'] ?? null,
        'text-align' => $settings['textAlign'] ?? null,
        'line-height' => $settings['lineHeight'] ?? null,
        'letter-spacing' => $settings['letterSpacing'] ?? null,
        'margin-top' => $settings['marginTop'] ?? null,
        'margin-right' => $settings['marginRight'] ?? null,
        'margin-bottom' => $settings['marginBottom'] ?? null,
        'margin-left' => $settings['marginLeft'] ?? null,
        'padding-top' => $settings['paddingTop'] ?? null,
        'padding-right' => $settings['paddingRight'] ?? null,
        'padding-bottom' => $settings['paddingBottom'] ?? null,
        'padding-left' => $settings['paddingLeft'] ?? null,
    ];
    
    $style = collect($styleProps)
        ->filter(fn($value) => !empty($value) && $value !== '0')
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
@endphp

<{{ $tag }} class="builder-widget-heading" data-id="{{ $id }}" @if($style) style="{{ $style }}" @endif>
    {{ $content }}
</{{ $tag }}>
