@php
    $wrapperStyleProps = [
        'margin-top' => $settings['marginTop'] ?? null,
        'margin-bottom' => $settings['marginBottom'] ?? null,
        'padding-top' => $settings['paddingTop'] ?? null,
        'padding-bottom' => $settings['paddingBottom'] ?? null,
    ];
    
    $wrapperStyle = collect($wrapperStyleProps)
        ->filter(fn($value) => !empty($value) && $value !== '0')
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
@endphp

<div class="builder-widget-html" data-id="{{ $id }}" @if($wrapperStyle) style="{{ $wrapperStyle }}" @endif>
    {!! $content !!}
</div>
