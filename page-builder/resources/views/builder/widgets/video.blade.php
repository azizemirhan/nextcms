@php
    $wrapperStyleProps = [
        'margin-top' => $settings['marginTop'] ?? null,
        'margin-bottom' => $settings['marginBottom'] ?? null,
    ];
    
    $wrapperStyle = collect($wrapperStyleProps)
        ->filter(fn($value) => !empty($value) && $value !== '0')
        ->map(fn($value, $prop) => "{$prop}: {$value}")
        ->implode('; ');
    
    // YouTube ID çıkart
    $videoId = null;
    if ($content) {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $content, $matches);
        $videoId = $matches[1] ?? null;
    }
@endphp

<div class="builder-widget-video" data-id="{{ $id }}" @if($wrapperStyle) style="{{ $wrapperStyle }}" @endif>
    @if($videoId)
        <div class="ratio ratio-16x9">
            <iframe 
                src="https://www.youtube.com/embed/{{ $videoId }}" 
                title="Video"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
    @else
        <div class="ratio ratio-16x9 bg-dark d-flex align-items-center justify-content-center">
            <div class="text-white text-center">
                <i class="bi bi-play-circle" style="font-size: 3rem;"></i>
                <p class="mb-0 mt-2">Video URL'si eklenmemiş</p>
            </div>
        </div>
    @endif
</div>
