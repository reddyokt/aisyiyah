@extends('layouts.master')
@section('title')
    Landing Property
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
        Landing Property
        @endslot
        @slot('title')
            detail
        @endslot
    @endcomponent

    <div class="row" style="min-height: 800px;">
        <div class="col-12">
            <div class="card">
            @include('flashmessage')
                <div class="card-body">
                    <h4 class="card-title font-size-20">Silahkan ubah beberapa property untuk landing page dibawah ini</h4>
                    {{-- <p class="card-title-desc">Lengkapi field dibawah ini untuk membuat sebuah Role Baru</p> --}}
                    <form action="/landingprop/update" method="POST" id="updatelandingprop">
                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="id">

                        <div class="mb-3 row">
                            <label for="description" class="col-form-label font-size-18">Header 1</label>
                            <div class="col-md-12">
                                <input class="form-control font-size-18" type="text" id="header1" name="header1"
                                    value="{{$landing->header1}}" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-form-label font-size-16">Header 2</label>
                            <div class="col-md-12">
                                <input class="form-control font-size-16" type="text" id="header2" name="header2"
                                    value="{{$landing->header2}}" required>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            {{-- <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button> --}}
                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                id="sa-add-success">Simpan</button>

                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

