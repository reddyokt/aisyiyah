@extends('layouts-landing.master')
@section('title')
    {{ $landingprop->header1 ?? 'PWA Aisyiyah DKI Jakarta' }}
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-400 bg-content text-white"
        data-image-src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}">
        <div class="container pt-18 pb-16" style="z-index: 5; position:relative">
            <div class="row gx-0 gy-12 align-items-center">
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-6 content text-center text-lg-start"
                    data-cues="slideInDown" data-group="page-title" data-delay="600">
                    <h1 class="display-2 mb-5 text-white">{{ $landingprop->header1 ?? 'PWA Aisyiyah DKI Jakarta' }}</h1>
                    <p class="lead fs-lg lh-sm mb-7 pe-xl-10">{{ $landingprop->header2 ?? 'Organisasi Otonom Muhammadiyah yang bergerak di bidang pemberdayaan perempuan' }}</p>
                    <div class="d-flex justify-content-center justify-content-lg-start" data-cues="slideInDown"
                        data-group="page-title-buttons" data-delay="900">
                        <span><a href="#news" class="btn btn-lg btn-white rounded-pill me-2">Berita Terkini</a></span>
                        <span><a href="#visi-misi" class="btn btn-lg btn-outline-white rounded-pill">Visi & Misi</a></span>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="swiper-container dots-over shadow-lg" data-margin="5" data-nav="true" data-dots="true"
                        data-autoplay="true" data-autoplaytime="7000">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ URL::asset('landing/assets/img/aisyiyah-berkemajuan.svg') }}"
                                        class="rounded" alt="Aisyiyah Berkemajuan" />
                                </div>
                                <div class="swiper-slide">
                                    <a href="{{ URL::asset('landing/assets/media/Mars-Aisyiyah.mp4') }}"
                                        class="btn btn-circle btn-white btn-play ripple mx-auto mb-5 position-absolute"
                                        style="top:50%; left: 50%; transform: translate(-50%,-50%); z-index:3;"
                                        data-glightbox data-gallery="hero">
                                        <i class="icn-caret-right"></i>
                                    </a>
                                    <img src="{{ URL::asset('landing/assets/img/thumb-mars.svg') }}"
                                        class="rounded" alt="Mars Aisyiyah" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ URL::asset('landing/assets/img/siti-walidah.svg') }}"
                                        class="rounded" alt="Siti Walidah" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section class="wrapper bg-light" id="visi-misi">
        <div class="container py-14 py-md-16">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                <div class="col-lg-6">
                    <figure class="rounded shadow-lg">
                        <img src="{{ URL::asset('landing/assets/img/Kemitraan-Aisyiyah.png') }}"
                            alt="Kemitraan Aisyiyah" class="rounded">
                    </figure>
                </div>
                <div class="col-lg-6">
                    <h2 class="fs-16 text-uppercase text-primary mb-3">Tentang Kami</h2>
                    <h3 class="display-4 mb-8">Visi & Misi <br><span class="underline-3 style-2 yellow">PWA 'Aisyiyah DKI Jakarta</span></h3>
                    <div class="row gy-6">
                        <div class="col-md-6" data-cues="fadeIn" data-delay="200">
                            <div class="d-flex flex-row">
                                <div>
                                    <span class="icon btn btn-circle btn-soft-primary pe-none me-4">
                                        <i class="uil uil-eye fs-24"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Visi Ideal</h4>
                                    <p class="mb-0 text-muted">Tegaknya agama Islam dan terwujudnya masyarakat Islam yang sebenar-benarnya.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" data-cues="fadeIn" data-delay="400">
                            <div class="d-flex flex-row">
                                <div>
                                    <span class="icon btn btn-circle btn-soft-violet pe-none me-4">
                                        <i class="uil uil-lightbulb-alt fs-24"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Visi Pengembangan</h4>
                                    <p class="mb-0 text-muted">Terwujudnya perempuan berkemajuan yang berlandaskan nilai-nilai Islam untuk kemaslahatan umat.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" data-cues="fadeIn" data-delay="600">
                            <div class="d-flex flex-row">
                                <div>
                                    <span class="icon btn btn-circle btn-soft-orange pe-none me-4">
                                        <i class="uil uil-bullseye fs-24"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Misi</h4>
                                    <p class="mb-0 text-muted">Meningkatkan kualitas pelayanan kesehatan, pendidikan, dan pemberdayaan ekonomi perempuan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" data-cues="fadeIn" data-delay="800">
                            <div class="d-flex flex-row">
                                <div>
                                    <span class="icon btn btn-circle btn-soft-green pe-none me-4">
                                        <i class="uil uil-heart-alt fs-24"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Misi Sosial</h4>
                                    <p class="mb-0 text-muted">Memperkuat gerakan dakwah kultural dan sosial kemasyarakatan untuk pemberdayaan umat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="wrapper bg-white" id="news">
        <div class="container py-14 py-md-16">
            <div class="row text-center mb-10">
                <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto">
                    <h2 class="fs-16 text-uppercase text-primary mb-3">Informasi Terbaru</h2>
                    <h3 class="display-4 mb-4">Berita 'Aisyiyah DKI Jakarta</h3>
                    <p class="lead fs-lg text-muted">Ikuti kabar terbaru seputar kegiatan dan program Pimpinan Wilayah 'Aisyiyah DKI Jakarta.</p>
                </div>
            </div>

            @if (empty($postLanding) || count($postLanding) == 0)
                <div class="text-center py-10">
                    <div class="mb-4">
                        <i class="uil uil-newspaper fs-60 text-muted"></i>
                    </div>
                    <h4 class="text-muted">Belum ada berita</h4>
                    <p class="text-muted">Kembali lagi nanti untuk informasi terbaru.</p>
                </div>
            @else
                <div class="row gx-md-6 gy-8">
                    @foreach ($postLanding as $index => $post)
                        <div class="col-lg-3 col-md-6" data-cues="fadeIn" data-delay="{{ ($index % 4) * 150 }}">
                            <article class="card shadow-sm lift h-100">
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="/read/post/{{ $post->slug }}">
                                        @if (!empty($post->feature_image) && file_exists(base_path() . '/public/upload/feature_image/' . $post->feature_image))
                                    <img src="{{ '/../upload/feature_image/' . $post->feature_image }}"
                                                alt="{{ $post->news_title }}" class="w-100" style="height: 180px; object-fit: cover;">
                                        @else
                                            <img src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}"
                                                alt="Default" class="w-100" style="height: 180px; object-fit: cover;">
                                        @endif
                                    </a>
                                    <figcaption>
                                        <h6 class="from-top mb-0">Baca</h6>
                                    </figcaption>
                                </figure>
                                <div class="card-body d-flex flex-column p-3">
                                    <span class="badge bg-primary rounded-pill mb-2 align-self-start">
                                        {{ $post->category ?? 'Umum' }}
                                    </span>
                                    <h4 class="post-title h6 mb-2" style="line-height: 1.4;">
                                        <a class="link-dark" href="/read/post/{{ $post->slug }}">
                                            {{ \Illuminate\Support\Str::limit($post->news_title, 55) }}
                                        </a>
                                    </h4>
                                    <p class="card-text text-muted small flex-grow-1 d-none d-md-block">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($post->news_body ?? ''), 80) }}
                                    </p>
                                    <div class="post-footer mt-auto pt-2 border-top">
                                        <ul class="post-meta d-flex justify-content-between align-items-center mb-0 small text-muted">
                                            <li>
                                                <i class="uil uil-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($post->created_at)->locale('id')->translatedFormat('d M Y') }}
                                            </li>
                                            <li>
                                                <i class="uil uil-user me-1"></i>{{ \Illuminate\Support\Str::limit($post->author ?? 'Admin', 12) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Button Semua Berita -->
                <div class="text-center mt-10">
                    <a href="{{ route('berita') }}" class="btn btn-primary rounded-pill btn-lg px-6">
                        <i class="uil uil-newspaper me-2"></i>Lihat Semua Berita
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- YouTube Section -->
    <section class="wrapper bg-light" id="youtube">
        <div class="container py-14 py-md-16">
            <div class="row text-center mb-10">
                <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto">
                    <h2 class="fs-16 text-uppercase text-primary mb-3">Media</h2>
                    <h3 class="display-4 mb-4">YouTube 'Aisyiyah DKI Jakarta</h3>
                    <p class="lead fs-lg text-muted">Saksikan video kegiatan dan program PWA 'Aisyiyah DKI Jakarta.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg rounded-4 overflow-hidden">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/BjMcqj6un4I?si=ZC0FQZBsWfu4o0e4"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics / CTA Section -->
    <section class="wrapper bg-primary text-white">
        <div class="container py-10 py-md-12">
            <div class="row gy-6 text-center">
                <div class="col-md-4" data-cues="zoomIn" data-delay="200">
                    <div class="icon btn btn-circle btn-white pe-none mx-auto mb-3">
                        <i class="uil uil-map-marker fs-24 text-primary"></i>
                    </div>
                    <h3 class="counter counter-lg text-white">6</h3>
                    <p class="mb-0 text-white-50">Wilayah Administrasi</p>
                </div>
                <div class="col-md-4" data-cues="zoomIn" data-delay="400">
                    <div class="icon btn btn-circle btn-white pe-none mx-auto mb-3">
                        <i class="uil uil-building fs-24 text-primary"></i>
                    </div>
                    <h3 class="counter counter-lg text-white">44</h3>
                    <p class="mb-0 text-white-50">Kecamatan</p>
                </div>
                <div class="col-md-4" data-cues="zoomIn" data-delay="600">
                    <div class="icon btn btn-circle btn-white pe-none mx-auto mb-3">
                        <i class="uil uil-users-alt fs-24 text-primary"></i>
                    </div>
                    <h3 class="counter counter-lg text-white">Aisyiyah</h3>
                    <p class="mb-0 text-white-50">Berkemajuan</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('head')
<style>
    .card.lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card.lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    }
    .counter-lg {
        font-size: 2.5rem;
        font-weight: 700;
    }
</style>
@endpush