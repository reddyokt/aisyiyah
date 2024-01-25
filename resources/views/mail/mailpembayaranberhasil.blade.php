<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Detail Anggota</title>
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="{{asset('assets/media/logo-IMM.png')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Body-->
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
					<style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
					<div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
						<div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
											<!--begin:Email content-->
											<div style="text-align:center; margin:0 60px 34px 60px">
												<!--begin:Logo-->
												<div style="margin-bottom: 10px">
													<a href="{{url('/')}}" rel="noopener" target="_blank">
														<img alt="Logo" src="{{asset('assets/media/logo-IMM-2.png')}}" class="mb-10" style="height: 85px;" />
													</a>
												</div>
												<!--end:Logo-->
												<!--begin:Media-->
												<div style="margin-bottom: 15px">
													<img alt="Logo" src="{{asset('assets/media/email/icon-positive-vote-3.svg')}}" style="height: 150px;width: 150px;" />
												</div>
												<!--end:Media-->
												<!--begin:Text-->
												<div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
													<p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Pembayaran Berhasil!</p>
													<p style="margin-bottom:2px; color:#7E8299">Selamat, anda telah menjadi anggota aktif</p>
													<p style="margin-bottom:2px; color:#7E8299"><b>IKATAN MAHASISWA MUHAMMADIYAH</b></p>
													<p style="margin-bottom:2px; color:#7E8299">Klik tombol dibawah ini untuk unduh Kartu Anggota</p>
												</div>
												<!--end:Text-->
												<!--begin:Action-->
												<a href="{{url('generate-card/'.$member_id)}}" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Unduh Kartu</a>
												<!--begin:Action-->
											</div>
											<!--end:Email content-->
										</td>
									</tr>
									<tr>
										<td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
											<p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">IKATAN MAHASISWA MUHAMMADIYAH</p>
											<p style="margin-bottom:2px">Dewan Pimpinan Pusat Ikatan Mahasiswa Muhammadiyah</p>
											<p style="margin-bottom:4px">Kunjungi kami di 
											<a href="https://dpp-imm.or.id" rel="noopener" target="_blank" style="font-weight: 600">Official Website</a> kami
                                            <br/>dan media sosial kami</p>
											
										</td>
									</tr>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 20px;">
											<a href="https://twitter.com/dppimmofficial" style="margin-right:10px">
												<img alt="Logo" src="{{asset('assets/media/email/icon-twitter.svg')}}" />
											</a>
											<a href="https://www.instagram.com/dpp.imm/" style="margin-right:10px">
												<img alt="Logo" src="{{asset('assets/media/svg/social-logos/instagram.svg')}}" />
											</a>
											<a href="https://www.facebook.com/dpp.imm.1" style="margin-right:10px">
												<img alt="Logo" src="{{asset('assets/media/email/icon-facebook.svg')}}" />
											</a>
											<a href="https://www.youtube.com/@IkatanMahasiswaMuhammadiyah">
												<img alt="Logo" src="{{asset('assets/media/svg/social-logos/youtube.svg')}}" />
											</a>
										</td>
									</tr>
									<tr>
										<td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
											<p>&copy; Copyright 2023 <b>Ikatan Mahasiswa Muhammadiyah</b></p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!--end::Email template-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>