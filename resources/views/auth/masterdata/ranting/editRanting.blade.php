@extends('layouts.master')
@section('title')
    Edit Ranting
@endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Ranting
        @endslot
        @slot('title')
            Edit Ranting
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div id="editranting-accordion" class="custom-accordion">
                @include('flashmessage')
                <div class="card">
                    <form action="{{ url('ranting/update/' . Crypt::encrypt($ranting->ranting_id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ Auth::id() }}" name="id">

                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Nama Ranting</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                               value="{{ old('name', $ranting->ranting_name) }}" placeholder="Enter Ranting name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih PCA</label>
                                        <select class="form-control" name="pca" id="pcaforranting">
                                            @foreach ($pca as $value)
                                                <option value="{{ $value->pca_id }}" 
                                                    {{ $ranting->pca_id == $value->pca_id ? 'selected' : '' }}>
                                                    {{ $value->pca_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="address">Alamat</label>
                                        <textarea class="form-control" name="address" id="address">{{ old('address', $ranting->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Kelurahan</label>
                                        <select class="form-control" name="villages">
                                            @foreach ($villages as $village)
                                                <option value="{{ $village->id }}" 
                                                    {{ $ranting->villages_id == $village->id ? 'selected' : '' }}>
                                                    {{ $village->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col ms-auto">
                                <div class="d-flex flex-wrap gap-3 p-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/ecommerce-add-product.init.js') }}"></script>
@endsection
