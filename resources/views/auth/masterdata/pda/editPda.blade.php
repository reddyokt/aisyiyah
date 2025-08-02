@extends('layouts.master')
@section('title')
    Edit PDA
@endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            PDA
        @endslot
        @slot('title')
            Edit PDA
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div id="editproduct-accordion" class="custom-accordion">
                @include('flashmessage')
                <div class="card">
                <form action="{{ url('pda/update/' . Crypt::encrypt($pda->pda_id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{ Auth::id() }}" name="id">
                    <a href="#editproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="editproduct-billinginfo-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            01
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Edit PDA Information</h5>
                                    <p class="text-muted text-truncate mb-0">Update information below</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>

                        </div>
                    </a>
                    <div id="editproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#editproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Nama PDA</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                               value="{{ old('name', $pda->pda_name) }}" placeholder="Enter PDA name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Kota/Kabupaten Administrative</label>
                                        <select class="select2 form-control select2-multiple" name="regencies" data-placeholder="Choose ...">
                                            @foreach ($regencies as $value)
                                                <option value="{{ $value->id }}" 
                                                    {{ $pda->regencies_id == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}
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
                                        <textarea class="form-control" name="address" id="address">{{ old('address', $pda->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col ms-auto">
                        <div class="d-flex flex-wrap gap-3">
                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                id="sa-edit-success">Update</button>
                        </div>
                    </div>
                </form> <!-- end col -->
                </div> <!-- end row-->
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/ecommerce-add-product.init.js') }}"></script>
@endsection
