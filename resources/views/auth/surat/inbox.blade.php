@extends('layouts.master')
@section('title')
    @lang('translation.Inbox')
@endsection

@section('css')
    <style>
        .email-item.unread {
            background-color: #f0f7ff;
            color: blue;
            /* Biru muda */
            border-left: 4px solid #007bff;
            /* highlight kiri */
        }

        .email-item.read {
            background-color: #ffffff;
        }

        .email-item:hover {
            background-color: #e8eaed;
        }
    </style>
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            e-Surat
        @endslot
        @slot('title')
            Inbox
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <!-- Left sidebar -->
            <div class="email-leftbar card">
                <a href="/surat/create" type="button" class="btn btn-danger waves-effect waves-light">
                    Compose </a>
                </button>
                <div class="mail-list mt-4">
                    <a href="/inbox/{{ Session::get('user_id') }}"><i
                            class="mdi mdi-email-outline font-size-16 align-middle me-2"></i>
                        Inbox <span class="ms-1 float-end">({{ count($inbox) }})</span></a>
                    <a href="/sent/{{ Session::get('user_id') }}"><i
                            class="mdi mdi-email-check-outline font-size-16 align-middle me-2"></i>
                        Sent <span class="ms-1 float-end">({{ count($sent) }})</span></a></a>
                    <a href="#"><i class="mdi mdi-trash-can-outline font-size-16 align-middle me-2"></i>Trash</a>
                </div>
            </div>
            <!-- End Left sidebar -->

            <!-- Right Sidebar -->
            <div class="email-rightbar mb-3">

                <div class="card">
                    <div class="btn-toolbar p-3" role="toolbar">

                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($inbox as $item)
                            <li class="list-group-item email-item {{ $item->isOpened == 'N' ? 'unread' : 'read' }}"
                                data-id="{{ $item->id_surat }}" style="cursor:pointer;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/images/default-avatar.png') }}"
                                            class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                        <div>
                                            <span
                                                class="{{ $item->isOpened == 'N' ? 'fw-bold text-primary' : 'fw-normal' }}">
                                                {{ $item->dari }}
                                            </span>
                                            <div class="small text-muted">{{ $item->subject }}</div>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                                    </small>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-4">
                                <i class="mdi mdi-email-off-outline mdi-24px"></i> Your inbox is empty
                            </li>
                        @endforelse
                    </ul>
                </div> <!-- card -->

                <div class="row">
                    <div class="col-7">
                        Showing 1 - 20
                    </div>
                    <div class="col-5">
                        <div class="btn-group float-end">
                            <button type="button" class="btn btn-sm btn-success waves-effect"><i
                                    class="fa fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-sm btn-success waves-effect"><i
                                    class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div> <!-- end Col-9 -->
        </div>
    </div><!-- End row -->

    <!-- Modal Detail Surat -->
    <div class="modal fade" id="modalDetailSurat" tabindex="-1" aria-labelledby="modalDetailSuratLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header d-flex align-items-center bg-light">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/default-avatar.png') }}" id="pengirimAvatar"
                            class="rounded-circle me-3" width="48" height="48" alt="Avatar Pengirim">
                        <div>
                            <h5 class="mb-0 fw-bold" id="detailPengirim">Nama Pengirim</h5>
                            <small class="text-muted" id="detailTanggal"></small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" id="btnReply">
                            <i class="mdi mdi-reply"></i> Balas
                        </button>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <h4 id="detailSubject" class="fw-bold mb-3"></h4>

                    <div class="mb-2">
                        <strong>Kepada:</strong> <span id="detailPenerima" class="text-muted"></span>
                    </div>
                    <hr>

                    <div id="detailBody" class="mb-4" style="white-space: pre-line;"></div>

                    <div id="detailAttachment" class="mt-3" style="display:none;">
                        <p class="fw-bold">Lampiran:</p>
                        <a id="attachmentLink" href="#" target="_blank" class="btn btn-outline-secondary btn-sm">
                            <i class="mdi mdi-paperclip"></i> Lihat Lampiran
                        </a>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/email-editor.init.js') }}"></script>
    <script>
        $(document).on('click', '.email-item', function() {
            let id = $(this).data('id');

            $.get(`/inbox/read/${id}`, function(response) {
                $('#detailPengirim').text(response.surat.pengirim_name);
                $('#detailTanggal').text(response.surat.created_at);
                $('#detailSubject').text(response.surat.subject);
                $('#detailBody').html(response.surat.body);

                let penerimaNames = response.penerima.map(p => p.name).join(', ');
                $('#detailPenerima').text(penerimaNames);

                if (response.surat.file_uploaded) {
                    $('#detailAttachment').show();
                    $('#attachmentLink').attr('href', `/upload/attachment/${response.surat.file_uploaded}`);
                } else {
                    $('#detailAttachment').hide();
                }

                if (response.surat.profile_picture) {
                    $('#pengirimAvatar').attr('src', `/upload/profile/${response.surat.profile_picture}`);
                } else {
                    $('#pengirimAvatar').attr('src', `/assets/images/default-avatar.png`);
                }

                $('#modalDetailSurat').modal('show');
            });
        });
    </script>
@endsection
