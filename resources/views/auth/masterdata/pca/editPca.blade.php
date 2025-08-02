@extends('layouts.master')
@section('title')
    Edit PCA
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            PCA
        @endslot
        @slot('title')
            Edit PCA
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div id="editproduct-accordion" class="custom-accordion">
                @include('flashmessage')
                <div class="card">
                    <form action="{{ url('pca/update/' . Crypt::encrypt($pca->pca_id)) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ Auth::id() }}" name="id">

                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Nama PCA</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                               value="{{ old('name', $pca->pca_name) }}" placeholder="Enter PCA name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="address">Alamat</label>
                                        <textarea class="form-control" name="address" id="address">{{ old('address', $pca->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">                                            
                                    <label class="form-label">Pilih PDA</label>
                                    <select class="form-control" name="pda">
                                        @foreach ($pda as $value)
                                            <option value="{{ $value->pda_id }}" 
                                                {{ $pca->pda_id == $value->pda_id ? 'selected' : '' }}>
                                                {{ $value->pda_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pilih Kecamatan/Administrative</label>
                                    <select class="form-control" name="districts">
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" 
                                                {{ $pca->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col ms-auto">
                                <div class="d-flex flex-wrap gap-3 p-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
@endsection
