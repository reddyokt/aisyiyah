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

                    {{-- ✅ FIX: gunakan route + method PUT --}}
                    <form action="{{ route('aum.update.legacy', Crypt::encrypt($aum->id_aum)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ Auth::id() }}">

                        {{-- hidden supaya pca/pda auto tetap terkirim walau select disabled --}}
                        <input type="hidden" name="pca" id="pca_hidden" value="{{ $aum->pca_id }}">
                        <input type="hidden" name="pda" id="pda_hidden" value="{{ $aum->pda_id }}">

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

                            {{-- RANTING (manual) --}}
                            <div class="col-lg-12 mb-3" id="divrantings" style="display:none;">
                                <label class="form-label">Pilih Ranting</label>
                                <select class="form-control select2" name="ranting_id" id="rantings">
                                    <option value="">Pilih Ranting</option>
                                    @foreach ($ranting as $r)
                                        <option value="{{ $r->ranting_id }}"
                                            {{ $aum->ranting_id == $r->ranting_id ? 'selected' : '' }}>
                                            {{ $r->ranting_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- PCA (manual) --}}
                            <div class="col-lg-12 mb-3" id="divpcas" style="display:none;">
                                <label class="form-label">Pilih PCA</label>
                                <select class="form-control select2" id="pcas">
                                    <option value="">Pilih PCA</option>
                                    @foreach ($pca as $pc)
                                        <option value="{{ $pc->pca_id }}"
                                            {{ $aum->pca_id == $pc->pca_id ? 'selected' : '' }}>
                                            {{ $pc->pca_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- PCA (auto, disabled) --}}
                            <div class="col-lg-6 mb-3" id="divpcass" style="display:none;">
                                <label class="form-label">PCA</label>
                                <select class="form-control select2" id="pcass" disabled></select>
                            </div>

                            {{-- PDA (manual) --}}
                            <div class="col-lg-12 mb-3" id="divpdas" style="display:none;">
                                <label class="form-label">Pilih PDA</label>
                                <select class="form-control select2" id="pdas">
                                    <option value="">Pilih PDA</option>
                                    @foreach ($pda as $pd)
                                        <option value="{{ $pd->pda_id }}"
                                            {{ $aum->pda_id == $pd->pda_id ? 'selected' : '' }}>
                                            {{ $pd->pda_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- PDA (auto, disabled) --}}
                            <div class="col-lg-6 mb-3" id="divpdass" style="display:none;">
                                <label class="form-label">PDA</label>
                                <select class="form-control select2" id="pdass" disabled></select>
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
        $(function() {
            $('.select2').select2({
                width: '100%'
            });

            const $divRanting = $('#divrantings');
            const $divPcas = $('#divpcas');
            const $divPdas = $('#divpdas');
            const $divPcass = $('#divpcass');
            const $divPdass = $('#divpdass');

            const $rantings = $('#rantings');
            const $pcas = $('#pcas');
            const $pdas = $('#pdas');
            const $pcass = $('#pcass');
            const $pdass = $('#pdass');

            const $pcaHidden = $('#pca_hidden');
            const $pdaHidden = $('#pda_hidden');

            function hideAll() {
                $divRanting.hide();
                $divPcas.hide();
                $divPdas.hide();
                $divPcass.hide();
                $divPdass.hide();
            }

            function setOptions($select, items, valueKey, textKey, placeholderText) {
                $select.empty();
                if (placeholderText !== null) {
                    $select.append(new Option(placeholderText, '', true, true));
                }
                (items || []).forEach(it => $select.append(new Option(it[textKey], it[valueKey])));
                $select.trigger('change');
            }

            async function fetchJson(url) {
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!res.ok) throw new Error('Fetch failed: ' + url);
                return await res.json();
            }

            async function setAutoFromRanting(rantingId) {
                const pcaArr = await fetchJson('{{ url('aum/pcas/pcasbyrantings') }}/' + rantingId);
                setOptions($pcass, pcaArr, 'pca_id', 'pca_name', null);
                $divPcass.show();

                const pcaId = (pcaArr && pcaArr[0]) ? pcaArr[0].pca_id : '';
                $pcaHidden.val(pcaId);

                const pdaArr = await fetchJson('{{ url('aum/pdas/pdasbyrantings') }}/' + rantingId);
                setOptions($pdass, pdaArr, 'pda_id', 'pda_name', null);
                $divPdass.show();

                const pdaId = (pdaArr && pdaArr[0]) ? pdaArr[0].pda_id : '';
                $pdaHidden.val(pdaId);
            }

            async function setAutoFromPca(pcaId) {
                const pdaArr = await fetchJson('{{ url('aum/pdas/pdasbypcass') }}/' + pcaId);
                setOptions($pdass, pdaArr, 'pda_id', 'pda_name', null);
                $divPdass.show();

                $pcaHidden.val(pcaId);
                const pdaId = (pdaArr && pdaArr[0]) ? pdaArr[0].pda_id : '';
                $pdaHidden.val(pdaId);
            }

            function toggleDropdowns() {
                const selected = $('input[name="inlineRadioOptions"]:checked').val();
                hideAll();

                if (selected === 'Ranting') $divRanting.show();
                if (selected === 'PCA') $divPcas.show();
                if (selected === 'PDA') $divPdas.show();

                // show auto boxes if already have values
                if (selected === 'Ranting') {
                    $divPcass.show();
                    $divPdass.show();
                }
                if (selected === 'PCA') {
                    $divPdass.show();
                }
            }

            $('input[name="inlineRadioOptions"]').on('change', function() {
                // reset auto values when change mode
                $pcass.empty().trigger('change');
                $pdass.empty().trigger('change');
                $pcaHidden.val('');
                $pdaHidden.val('');
                toggleDropdowns();
            });

            // initial render
            toggleDropdowns();

            // initial auto-fill for existing data
            const initialMode = $('input[name="inlineRadioOptions"]:checked').val();
            if (initialMode === 'Ranting' && $rantings.val()) {
                setAutoFromRanting($rantings.val());
            }
            if (initialMode === 'PCA' && $pcas.val()) {
                setAutoFromPca($pcas.val());
            }
            if (initialMode === 'PDA' && $('#pdas').val()) {
                $pdaHidden.val($('#pdas').val());
            }

            // change handlers
            $rantings.on('change', async function() {
                const rantingId = $(this).val();
                $pcaHidden.val('');
                $pdaHidden.val('');
                $pcass.empty().trigger('change');
                $pdass.empty().trigger('change');

                if (rantingId) await setAutoFromRanting(rantingId);
            });

            $pcas.on('change', async function() {
                const pcaId = $(this).val();
                $pcaHidden.val('');
                $pdaHidden.val('');
                $pdass.empty().trigger('change');

                if (pcaId) await setAutoFromPca(pcaId);
            });

            $pdas.on('change', function() {
                $pdaHidden.val($(this).val() || '');
            });

            // ✅ FIX: delete image route = DELETE
            $('.btn-delete-image').on('click', function() {
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
                            type: "DELETE",
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
                                    }).then(() => location.reload());
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
