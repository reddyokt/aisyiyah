@extends('layouts.master')
@section('title')
    Detail AUM
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/owl-carousel/owl-carousel.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            AUM
        @endslot
        @slot('title')
            Detail
        @endslot
    @endcomponent
    <div class="row mb-3">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="dropdown float-end">
                            <a class="text-body dropdown-toggle font-size-18" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true">
                                <i class="uil uil-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Edit</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="text-muted">
                        <h5 class="font-size-16">Amal Usaha Muhammadiyah</h5>
                        <div class="table-responsive mt-4">
                            <div>
                                <h5 class="mb-1">Name AUM:</h5>
                                <p class="font-size-14">{{ $aum->aum_name }}</p>
                            </div>
                            <div class="mt-4">
                                <h5 class="mb-1">Pengelola : </h5> 
                                                            @if ($aum->pengelola == 'Ranting')
                                                            <p class="font-size-14">Ranting {{$aum->ranting_name}} - PDA {{$aum->pda_name}}</p>
                                                            @elseif ($aum->pengelola == 'PCA')
                                                            <p class="font-size-14">PCA {{$aum->pca_name}} - PDA {{$aumm->pda_name}}</p>
                                                            @elseif ($aum->pengelola == 'PDA')                                                  
                                                            <p class="font-size-14">PDA {{$aum->pda_name}}</p>
                                                            @endif                                
                            </div>
                            <div class="mt-4">
                                <h5 class="mb-1">Bidang Usaha :</h5>
                                <p class="font-size-14">{{$aum->bidangusaha}}</p>
                            </div>
                            <div class="mt-4">
                                <h5 class="mb-1">Kepemilikan :</h5>
                                <p class="font-size-14">{{$aum->kepemilikan}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-0">
                <!-- Tab content -->
                <div class="tab-content p-4">
                    <div class="tab-pane active" id="about" role="tabpanel">
                        <div>
                            <div>
                                <div class="mt-4">
                                    {{-- <i class="uil-map-marker"></i><p class="mb-1">Alamat :</p> --}}
                                    <h5 class="font-size-16 mb-3"><i class="uil uil-map-marker font-size-20 align-middle me-2"></i> Lokasi AUM</h5>
                                    <p class="font-size-14">{{$aum->address}}</p>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-1">Galerry  :</p>
                                    <div class="zoom-gallery">
                                        @foreach ($aum_image as $image)
                                            @if ($image->images != null)
                                                <a class="border-primary rounded" href="{{ '/../upload/aum/' . $image->images }}" title="{{$image->images}}">
                                                    <img  src="{{ '/../upload/aum/' . $image->images }}" class="img-fluid p-3" alt="{{$image->images}}" width="40%;"> 
                                                </a>
                                            @else
                                                <img src="{{ URL::asset('assets/media/Image_not_available.png') }}" alt=""
                                                    class="img-fluid mx-auto d-block">
                                            @endif                                                          
                                        @endforeach                                               
                                    </div>                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/owl-carousel/owl-carousel.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/timeline.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/magnific-popup/magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/lightbox.init.js') }}"></script>
@endsection
