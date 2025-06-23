@extends('layouts.master')
@section('title')
    Edit_Post
@endsection

@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            News
        @endslot
        @slot('title')
            Edit News
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="/post/edit/{{ $editpost->news_id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6 mb-3">
                                <div class="col-md-12">
                                    <input type="hidden" value="{{ Auth::id() }}" name="id">
                                    <label>News Title</label>
                                    <textarea class="form-control" type="text" name="title">{{ $editpost->news_title }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label>News Category</label>
                                    <select class="form-control" name="category" id="category">
                                        @foreach ($newscategory as $key => $value)
                                            <option value="{{ $value->id_category }}"
                                                {{ $value->id_category == $editpost->id_category ? 'selected' : '' }}>
                                                {{ $value->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label>News Body</label>
                                <textarea class="col-md-12 form-control" id="body" name="body">{{$editpost->news_body}}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                @if ($editpost->feature_image == null)
                                    <img src="{{ '/../upload/feature_image/ui5.png' }}" class="img-fluid tab-img rounded"
                                        style="width: 60%;">
                                    <p>No Feature Image uploaded</p>
                                @else
                                    <img src="{{ '/../upload/feature_image/' . $editpost->feature_image }}"
                                        class="img-fluid tab-img rounded" style="width: 60%;">
                                    <p>Feature Image has been uploaded</p>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label" for="feature_image">Upload Feature Image</label>
                                    <input id="feature_image" name="feature_image" type="file" class="form-control"
                                        accept="image/png, image/jpeg, image/jpg"placeholder="#">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    @if ($editpost->images == Null)
                                        <img src="{{ '/../upload/images/ni3.png' }}"
                                            class="img-fluid tab-img rounded" style="width: 45%;">
                                        <p>No Images uploaded yet</p>
                                    @else
                                        <img src="{{ '/../upload/images/' . $editpost->images }}"
                                            class="img-fluid tab-img rounded" style="width: 60%;">
                                        <p>Image has been uploaded</p>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label" for="content_image">Upload Content Image</label>
                                        <input id="content_image" name="content_image" type="file" class="form-control"
                                            accept="image/png, image/jpeg, image/jpg"placeholder="#">
                                    </div>
                                </div>
                            </div>
                        </div>
                            <button type="submit" class="btn btn-primary mt-3">Post it! <i
                                    class="fab fa-telegram-plane ms-1"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/ckeditor/ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script> --}}
    <script>
        ClassicEditor.defaultConfig = {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'insertTable',
                    '|'
                ]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            },
            language: 'en'
        };

        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
