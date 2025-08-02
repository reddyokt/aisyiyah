@extends('layouts.master')
@section('title')
    Edit AUM
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            AUM
        @endslot
        @slot('title')
            Edit Data AUM
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data</h4>
                    <form action="{{ url('/aum/update/' . Crypt::encrypt($aum->id_aum)) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ Auth::id() }}">

                        <!-- Pengelolaan -->
                        <div class="mb-3 row">
                            <label class="form-label col-form-label">Pengelolaan oleh</label>
                            <div class="d-flex gap-3">
                                @foreach (['Ranting', 'PCA', 'PDA'] as $type)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="pengelola{{ $type }}" value="{{ $type }}"
                                            {{ $aum->pengelolaby == $type ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="pengelola{{ $type }}">{{ $type }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <!-- Dropdown Ranting -->
                            <div class="col-lg-12 mb-3" id="divrantings" style="display:none;">
                                <label class="form-label">Pilih Ranting</label>
                                <select class="form-control select2" name="ranting_id">
                                    <option value="">Pilih Ranting</option>
                                    @foreach ($ranting as $r)
                                        <option value="{{ $r->ranting_id }}"
                                            {{ $aum->ranting_id == $r->ranting_id ? 'selected' : '' }}>
                                            {{ $r->ranting_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown PCA -->
                            <div class="col-lg-12 mb-3" id="divpcas" style="display:none;">
                                <label class="form-label">Pilih PCA</label>
                                <select class="form-control select2" name="pca">
                                    <option value="">Pilih PCA</option>
                                    @foreach ($pca as $pc)
                                        <option value="{{ $pc->pca_id }}"
                                            {{ $aum->pca_id == $pc->pca_id ? 'selected' : '' }}>
                                            {{ $pc->pca_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown PDA -->
                            <div class="col-lg-12 mb-3" id="divpdas" style="display:none;">
                                <label class="form-label">Pilih PDA</label>
                                <select class="form-control select2" name="pda">
                                    <option value="">Pilih PDA</option>
                                    @foreach ($pda as $pd)
                                        <option value="{{ $pd->pda_id }}"
                                            {{ $aum->pda_id == $pd->pda_id ? 'selected' : '' }}>
                                            {{ $pd->pda_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Nama, Bidang Usaha, Kepemilikan -->
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Nama AUM</label>
                                <input class="form-control" name="name" type="text" value="{{ $aum->aum_name }}"
                                    required>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Bidang Usaha</label>
                                <select class="form-control select2" name="bidangusaha" required>
                                    @foreach ($bidangusaha as $b)
                                        <option value="{{ $b->id_bidangusaha }}"
                                            {{ $aum->id_bidangusaha == $b->id_bidangusaha ? 'selected' : '' }}>
                                            {{ $b->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Kepemilikan</label>
                                <select class="form-control select2" name="kepemilikan" required>
                                    @foreach ($kepemilikan as $k)
                                        <option value="{{ $k->id_kepemilikan }}"
                                            {{ $aum->id_kepemilikan == $k->id_kepemilikan ? 'selected' : '' }}>
                                            {{ $k->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="address">{{ $aum->address }}</textarea>
                        </div>

                        <!-- Existing Images -->
                        <div class="mb-3">
                            <label class="form-label">Foto AUM Saat Ini</label>
                            <div class="d-flex flex-wrap gap-3">
                                @forelse($images as $img)
                                    <div class="position-relative image-wrapper" data-id="{{ $img->id_aum_image }}">
                                        <img src="{{ asset('upload/aum/' . $img->images) }}" class="rounded border"
                                            width="120" height="100" alt="AUM Image">
                                        <button type="button"
                                            class="btn btn-sm btn-danger p-1 btn-delete-image position-absolute top-0 end-0">
                                            <i class="uil uil-trash-alt"></i>
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada foto yang diunggah.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Upload Foto Baru -->
                        <div class="mb-3">
                            <label class="form-label">Tambah Foto Baru</label>
                            <input class="form-control" type="file" name="images[]" multiple
                                accept="image/png, image/jpeg, image/jpg">
                            <small class="text-muted">Anda dapat memilih lebih dari satu foto.</small>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url('/aum') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            function toggleDropdowns() {
                let selected = $('input[name="inlineRadioOptions"]:checked').val();
                $('#divrantings, #divpcas, #divpdas').hide();

                if (selected === 'Ranting') $('#divrantings').show();
                if (selected === 'PCA') $('#divpcas').show();
                if (selected === 'PDA') $('#divpdas').show();
            }

            $('input[name="inlineRadioOptions"]').change(toggleDropdowns);
            toggleDropdowns();

            // AJAX Delete Image with SweetAlert2
            $('.btn-delete-image').click(function() {
                const wrapper = $(this).closest('.image-wrapper');
                const imageId = wrapper.data('id');

                Swal.fire({
                    title: 'Hapus Foto?',
                    text: "Anda yakin ingin menghapus foto ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('aum.image.delete') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: imageId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        timer: 1200,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location
                                    .reload(); // reload halaman edit setelah alert
                                    });
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!',
                                    'Terjadi kesalahan saat menghapus gambar.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
