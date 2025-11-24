@extends('layouts.builder')

@section('title', 'Sayfalarım - Page Builder')

@section('content')
<div class="min-vh-100 py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="text-white fw-bold mb-1">
                    <i class="bi bi-layers me-2"></i>Page Builder
                </h1>
                <p class="text-white-50 mb-0">Sayfalarınızı sürükle-bırak ile tasarlayın</p>
            </div>
            <form action="{{ route('builder.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light btn-lg shadow">
                    <i class="bi bi-plus-lg me-2"></i>Yeni Sayfa
                </button>
            </form>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Pages Grid -->
        <div class="row g-4">
            @forelse($pages as $page)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                        <!-- Preview Thumbnail -->
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                            <div class="text-center">
                                <i class="bi bi-file-earmark-richtext text-primary" style="font-size: 3rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-2">{{ $page->title }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-link-45deg me-1"></i>{{ $page->slug }}
                            </p>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-clock me-1"></i>{{ $page->updated_at->diffForHumans() }}
                            </p>
                            
                            <!-- Status Badge -->
                            <span class="badge {{ $page->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }} mb-3">
                                <i class="bi {{ $page->status === 'published' ? 'bi-check-circle' : 'bi-pencil' }} me-1"></i>
                                {{ $page->status === 'published' ? 'Yayında' : 'Taslak' }}
                            </span>
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-top-0 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('builder.editor', $page) }}" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-pencil-square me-1"></i>Düzenle
                                </a>
                                <a href="{{ route('builder.preview', $page) }}" target="_blank" class="btn btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('builder.export', $page) }}">
                                                <i class="bi bi-download me-2"></i>Export JSON
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('builder.destroy', $page) }}" method="POST" 
                                                  onsubmit="return confirm('Bu sayfayı silmek istediğinize emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Sil
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-12">
                    <div class="card shadow border-0 text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 mb-2">Henüz sayfa yok</h4>
                            <p class="text-muted mb-4">İlk sayfanızı oluşturarak başlayın ve web sitenizi tasarlayın.</p>
                            <form action="{{ route('builder.create') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-plus-lg me-2"></i>İlk Sayfanızı Oluşturun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Footer Info -->
        @if($pages->count() > 0)
            <div class="text-center mt-4">
                <span class="badge bg-white bg-opacity-25 text-white px-3 py-2">
                    <i class="bi bi-collection me-1"></i>Toplam {{ $pages->count() }} sayfa
                </span>
            </div>
        @endif
    </div>
</div>
@endsection
