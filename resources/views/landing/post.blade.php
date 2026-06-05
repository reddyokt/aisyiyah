@extends('layouts-landing.master')
@section('title')
    Semua Berita - PWA 'Aisyiyah DKI Jakarta
@endsection

@section('content')
    <!-- Page Header -->
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-300 text-white"
        data-image-src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}">
        <div class="container pt-20 pb-16">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 text-white mb-3">Berita 'Aisyiyah</h1>
                    <p class="lead fs-lg text-white mb-0">Seluruh informasi dan kegiatan Pimpinan Wilayah 'Aisyiyah DKI Jakarta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Content -->
    <section class="wrapper bg-light">
        <div class="container py-14 py-md-16">
            <div class="row gx-lg-8 gx-xl-12">

                <!-- Filter Toggle Button (Mobile) -->
                <div class="col-12 d-lg-none mb-4">
                    <button class="btn btn-soft-primary rounded-pill w-100" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarFilter" aria-expanded="false" aria-controls="sidebarFilter">
                        <i class="uil uil-filter me-1"></i> Filter Kategori
                        @if(request('category'))
                            <span class="badge bg-primary rounded-pill ms-1">Aktif</span>
                        @endif
                    </button>
                </div>

                <!-- Sidebar -->
                <aside class="col-lg-4 order-lg-0">
                    <div class="collapse d-lg-block" id="sidebarFilter">
                        <div class="card shadow-sm" style="top: 80px; position: sticky;">
                            <div class="card-body p-4">
                                <h5 class="mb-4 d-none d-lg-block">
                                    <i class="uil uil-filter me-2 text-primary"></i>Filter Kategori
                                </h5>

                                <!-- All Link -->
                                <div class="mb-2">
                                    <a href="{{ route('berita') }}"
                                        class="d-flex justify-content-between align-items-center text-body p-2 rounded {{ !request('category') ? 'bg-soft-primary text-primary fw-bold' : 'hover-bg-light' }}">
                                        <span><i class="uil uil-list-ul me-2"></i>Semua Kategori</span>
                                        <span class="badge bg-primary rounded-pill">{{ $categories->count() }}</span>
                                    </a>
                                </div>

                                <!-- Category Links -->
                                @foreach ($categories as $cat)
                                    <div class="mb-2">
                                        <a href="{{ route('berita', ['category' => $cat->id_category]) }}"
                                            class="d-flex justify-content-between align-items-center text-body p-2 rounded {{ request('category') == $cat->id_category ? 'bg-soft-primary text-primary fw-bold' : 'hover-bg-light' }}">
                                            <span><i class="uil uil-folder me-2"></i>{{ $cat->category }}</span>
                                            <span class="badge bg-soft-primary text-primary rounded-pill">
                                                {{ $categoryCounts[$cat->id_category] ?? 0 }}
                                            </span>
                                        </a>
                                    </div>
                                @endforeach

                                @if(request('category'))
                                    <hr class="my-3">
                                    <a href="{{ route('berita') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100">
                                        <i class="uil uil-times me-1"></i>Hapus Filter
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="col-lg-8 order-lg-1">
                    @if ($postLanding->count() > 0)
                        <div class="row gy-8">
                            @foreach ($postLanding as $post)
                                <div class="col-md-6" data-cues="fadeIn" data-delay="{{ ($loop->index % 2) * 200 }}">
                                    <article class="card shadow-sm lift h-100">
                                        <figure class="card-img-top overlay overlay-1 hover-scale">
                                            <a href="/read/post/{{ $post->slug }}">
                                                @if (!empty($post->feature_image) && file_exists(base_path() . '/public/upload/feature_image/' . $post->feature_image))
                                                    <img src="{{ '/../upload/feature_image/' . $post->feature_image }}"
                                                        alt="{{ $post->news_title }}" style="height: 200px; object-fit: cover; width: 100%;">
                                                @else
                                                    <img src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}"
                                                        alt="Default" style="height: 200px; object-fit: cover; width: 100%;">
                                                @endif
                                            </a>
                                            <figcaption>
                                                <h6 class="from-top mb-0">Baca Selengkapnya</h6>
                                            </figcaption>
                                        </figure>
                                        <div class="card-body d-flex flex-column p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary rounded-pill">{{ $post->category ?? 'Umum' }}</span>
                                                <small class="text-muted">
                                                    <i class="uil uil-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($post->created_at)->locale('id')->translatedFormat('d M Y') }}
                                                </small>
                                            </div>
                                            <h3 class="post-title h5 mb-3">
                                                <a class="link-dark" href="/read/post/{{ $post->slug }}">
                                                    {{ \Str::limit($post->news_title, 70) }}
                                                </a>
                                            </h3>
                                            <p class="card-text text-muted small flex-grow-1">
                                                {{ \Str::limit(strip_tags($post->news_body ?? ''), 130) }}
                                            </p>
                                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="uil uil-user me-1"></i>{{ $post->author ?? 'Admin' }}
                                                </small>
                                                <a href="/read/post/{{ $post->slug }}" class="btn btn-sm btn-soft-primary rounded-pill">
                                                    Baca <i class="uil uil-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-10">
                            {{ $postLanding->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mb-4">
                                <i class="uil uil-newspaper fs-60 text-muted"></i>
                            </div>
                            <h4 class="text-muted">Tidak ada berita</h4>
                            <p class="text-muted">
                                @if(request('category'))
                                    Tidak ada berita dalam kategori ini.
                                    <a href="{{ route('berita') }}" class="text-primary">Lihat semua berita</a>
                                @else
                                    Belum ada berita yang dipublikasikan.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card.lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card.lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        .hover-bg-light:hover {
            background-color: rgba(0,0,0,0.04);
            transition: background-color 0.2s ease;
        }
    </style>
@endsection