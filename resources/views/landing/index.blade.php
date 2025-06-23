@extends('layouts-landing.master')
@section('title')
@endsection

@section('content')
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-400 bg-content text-white"
        data-image-src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}">
        <div class="container pt-18 pb-16" style="z-index: 5; position:relative">
            <div class="row gx-0 gy-12 align-items-center">
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-6 content text-center text-lg-start"
                    data-cues="slideInDown" data-group="page-title" data-delay="600">
                    <h1 class="display-2 mb-5 text-white">{{$landingprop->header1}}</h1>
                    <p class="lead fs-lg lh-sm mb-7 pe-xl-10">{{$landingprop->header2}}</p>
                    <div class="d-flex justify-content-center justify-content-lg-start" data-cues="slideInDown"
                        data-group="page-title-buttons" data-delay="900">
                        {{-- <span><a href="#" class="btn btn-lg btn-white rounded-pill me-2">Explore Now</a></span>
                        <span><a href="#" class="btn btn-lg btn-outline-white rounded-pill">Contact Us</a></span> --}}
                    </div>
                </div>
                <!--/column -->
                <div class="col-lg-5 offset-lg-1">
                    <div class="swiper-container dots-over shadow-lg" data-margin="5" data-nav="true" data-dots="true"
                        data-autoplay="true" data-autoplaytime="7000">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img
                                        src="{{ URL::asset('landing/assets/img/aisyiyah-berkemajuan.svg') }}"
                                        srcset="{{ URL::asset('landing/assets/img/aisyiyah-berkemajuan.svg') }}"
                                        class="rounded" alt="" />
                                </div>
                                <div class="swiper-slide"><a
                                        href="{{ URL::asset('landing/assets/media/Mars-Aisyiyah.mp4') }}"
                                        class="btn btn-circle btn-white btn-play ripple mx-auto mb-5 position-absolute"
                                        style="top:50%; left: 50%; transform: translate(-50%,-50%); z-index:3;"
                                        data-glightbox data-gallery="hero"><i class="icn-caret-right"></i></a><img
                                        src="{{ URL::asset('landing/assets/img/thumb-mars.svg') }}"
                                        srcset="{{ URL::asset('landing/assets/img/thumb-mars.svg') }}" class="rounded"
                                        alt="" /></div>
                                <div class="swiper-slide"><img src="{{ URL::asset('landing/assets/img/siti-walidah.svg') }}"
                                        srcset="{{ URL::asset('landing/assets/img/siti-walidah.svg') }}" class="rounded"
                                        alt="" />
                                </div>
                            </div>
                            <!--/.swiper-wrapper -->
                        </div>
                        <!--/.swiper -->
                    </div>
                    <!-- /.swiper-container -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <section class="wrapper bg-light" id="about">
        <div class="container py-10 py-md-10">
            <div class="row gy-10 gy-sm-13 gx-md-8 gx-xl-12 align-items-center">
                <div class="col-lg-6">
                    <div class="row gx-md-5 gy-5">
                        <div class="col-12">
                            <figure class="rounded"><img src="{{ URL::asset('landing/assets/img/Kemitraan-Aisyiyah.png') }}"
                                    srcset="{{ URL::asset('landing/assets/img/Kemitraan-Aisyiyah.png') }}" alt="">
                            </figure>
                        </div>
                        <!--/column -->
                        {{-- <div class="col-md-8">
                            <figure class="rounded"><img
                                    src="{{ URL::asset('landing/assets/img/Map-Aisyiyah-1030x755.png') }}"
                                    srcset="{{ URL::asset('landing/assets/img/Map-Aisyiyah-1030x755.png') }}"
                                    alt=""></figure>
                        </div> --}}
                        <!--/column -->
                        {{-- <div class="col-md-4">
                            <figure class="rounded"><img
                                    src="{{ URL::asset('landing/assets/img/Wilayah-Kerja-Aisyiyah.png') }}"
                                    srcset="{{ URL::asset('landing/assets/img/Wilayah-Kerja-Aisyiyah.png') }}"
                                    alt=""></figure>
                        </div> --}}
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/column -->
                <div class="col-lg-6">
                    <h2 class="fs-16 text-uppercase text-muted mb-1"></h2>
                    <h3 class="display-3 mb-10"><span class="underline-3 style-2 yellow">Visi Misi</span> <br> PWA 'Aisyiyah
                        DKI Jakarta</h3>
                    <div class="row gy-5">
                        <div class="col-md-6">
                            <div class="d-flex flex-row">
                                <div>
                                    <img src="{{ URL::asset('assets/images/logo_aisyiyah.svg') }}"
                                        class="svg-inject icon-svg icon-svg-xs solid-mono text-fuchsia me-4"
                                        alt="" />
                                </div>
                                <div>
                                    <h4 class="mb-1">Visi Ideal</h4>
                                    <p class="mb-0">Tegaknya agama Islam dan terwujudnya masyarakat Islam yang
                                        sebenar-benarnya.</p>
                                </div>
                            </div>
                        </div>
                        <!--/column -->
                        <div class="col-md-6">
                            <div class="d-flex flex-row">
                                <div>
                                    <img src="{{ URL::asset('assets/images/logo_aisyiyah.svg') }}"
                                        class="svg-inject icon-svg icon-svg-xs solid-mono text-violet me-4"
                                        alt="" />
                                </div>
                                <div>
                                    <h4 class="mb-1">Visi Pengembangan</h4>
                                    <p class="mb-0">Tegaknya agama Islam dan terwujudnya masyarakat Islam yang
                                        sebenar-benarnya. </p>
                                </div>
                            </div>
                        </div>
                        <!--/column -->
                        <div class="col-md-6">
                            <div class="d-flex flex-row">
                                <div>
                                    <img src="{{ URL::asset('landing/assets/img/icons/solid/puzzle.svg') }}"
                                        class="svg-inject icon-svg icon-svg-xs solid-mono text-orange me-4"
                                        alt="" />
                                </div>
                                <div>
                                    <h4 class="mb-1">Misi</h4>
                                    <p class="mb-0">Curabitur blandit lacus porttitor ridiculus mus.</p>
                                </div>
                            </div>
                        </div>
                        <!--/column -->
                        <div class="col-md-6">
                            <div class="d-flex flex-row">
                                <div>
                                    <img src="{{ URL::asset('landing/assets/img/icons/solid/puzzle.svg') }}"
                                        class="svg-inject icon-svg icon-svg-xs solid-mono text-green me-4" alt="" />
                                </div>
                                <div>
                                    <h4 class="mb-1">Misi</h4>
                                    <p class="mb-0">Curabitur blandit lacus porttitor ridiculus mus.</p>
                                </div>
                            </div>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    {{-- <hr> --}}

    <section class="wrapper bg-light">
        <div class="container py-2 py-md-2" id="news">
            <h2 class="display-4 mb-3 text-center">Berita 'Aisyiyah DKI Jakarta</h2>
            <div class="swiper-container blog grid-view mb-6" data-margin="30" data-dots="true" data-items-xl="4"
                data-items-md="2" data-items-xs="1" id="blog" data-autoplay="true" data-autoplaytime="7000">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @if ($postLanding == null)
                            <div class="mx-auto d-block">
                                <p>Belum ada Berita</p>
                            </div>
                        @else
                            @foreach ($postLanding as $post)
                                <div class="swiper-slide">
                                    <article>
                                        <figure class="overlay overlay-1 hover-scale rounded mb-5"><a
                                                href="/read/post/{{ $post->slug }}"> <img
                                                    src="{{ '/../upload/feature_image/' . $post->feature_image }}"
                                                    alt="" /></a>
                                            <figcaption>
                                                <h5 class="from-top mb-0">Read More</h5>
                                            </figcaption>
                                        </figure>
                                        <div class="post-header">
                                            <div class="post-category text-line">
                                                <a href="#" class="hover"
                                                    rel="category">{{ $post->category }}</a>
                                            </div>
                                            <!-- /.post-category -->
                                            <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark"
                                                    href="/read/post/{{ $post->slug }}">{{ $post->news_title }}</a></h2>
                                        </div>
                                        <!-- /.post-header -->
                                        <div class="post-footer">
                                            <ul class="post-meta">
                                                <li class="post-date"><i
                                                        class="uil uil-calendar-alt"></i><span>{{ \Carbon\Carbon::parse($post->created_at)->format('l, d/m/Y') }}</span>
                                                </li>
                                                <li class="post-comments"><a href="#"><i
                                                            class="uil uil-user-square"></i>{{ $post->author }}</a></li>
                                            </ul>
                                            <!-- /.post-meta -->
                                        </div>
                                        <!-- /.post-footer -->
                                    </article>
                                    <!-- /article -->
                                </div>
                            @endforeach
                            <!--/.swiper-slide -->
                    </div>
                    @endif
                    <!--/.swiper-wrapper -->
                </div>
                <!-- /.swiper -->
            </div>
            <!-- /.swiper-container -->
        </div>
        <!-- /.container -->
    </section>
    {{-- <hr> --}}

    <section id="snippet-4" class="wrapper py-16">
        <h2 class="display-4 mb-3 text-center">Youtube 'Aisyiyah DKI Jakarta</h2>
        <div class="card">
          <div class="card-body">
            <div class="ratio ratio-16x9 mxauto d-block text-center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/BjMcqj6un4I?si=ZC0FQZBsWfu4o0e4"
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
                encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <!--/.ratio -->
          </div>
          <!--/.card-body -->
        </div>
        <!--/.card -->
      </section>

@endsection
