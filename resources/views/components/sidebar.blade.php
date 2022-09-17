
        <!--APP-SIDEBAR-->
        <div class="sticky">
            <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
            <div class="app-sidebar">
                <div class="side-header">
                    <a class="header-brand1" href="/">
                        <img src="/assets/images/brand/logo-3.png" class="header-brand-img desktop-logo" alt="logo">
                        <img src="/assets/images/brand/logo-1.png" class="header-brand-img toggle-logo" alt="logo">
                        <img src="/assets/images/brand/logo-2.png" class="header-brand-img light-logo" alt="logo">
                        <img src="/assets/images/brand/logo-3.png?1" class="header-brand-img light-logo1" alt="logo">
                    </a>
                    <!-- LOGO -->
                </div>
                <div class="main-sidemenu">
                    <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
                    <ul class="side-menu">
                        <li class="sub-category">
                            <h3>Modul Utama</h3>
                        </li>
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="{!! url('/'); !!}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                        </li>
                        @if (getPermissions('e_kinerja_kemenkes')['checked'])
                        <li class="slide active  @yield('ekinerjaMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">E-Kinerja</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                              @if (getPermissions('e_kinerja_iki')['checked'])
                              <li><a href="{!! url('/e_kinerja_iki'); !!}" class="slide-item"> IKI</a></li>
                              @endif
                              @if (getPermissions('e_kinerja_ikt')['checked'])
                              <li><a href="{!! url('/e_kinerja_ikt'); !!}" class="slide-item"> IKT</a></li>
                              @endif
                            </ul>
                        </li>
                        @endif
                        @if (getPermissions('e_kinerja')['checked'])
                        <li class="slide active  @yield('userRequestSdmMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">E-Remun</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                              @if (getPermissions('penilaian_prestasi_kerja')['checked'])
                              <li><a href="{!! url('/penilaian_prestasi_kerja'); !!}" class="slide-item"> Penilaian Prestasi Kerja</a></li>
                              @endif
                              @if (getPermissions('penilaian_perilaku_kerja')['checked'])
                              <li><a href="{!! url('/penilaian_perilaku_kerja'); !!}" class="slide-item"> Penilaian Perilaku Kerja</a></li>
                              @endif
                              @if (getPermissions('penilaian_prestasi_kerja_approval')['checked'])
                              <li><a href="{!! url('/penilaian_prestasi_kerja_approval'); !!}" class="slide-item"> Approval Prestasi Kerja</a></li>
                              @endif
                              @if (getPermissions('report_skp')['checked'])
                              <li><a href="{!! url('/report_skp'); !!}" class="slide-item"> Rekap SKP</a></li>
                              @endif
                            </ul>
                        </li>
                        @endif
                        @if (getPermissions('user_request_sdm')['checked'])
                        <li class="slide active  @yield('userRequestSdmMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Approval SDM</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{!! url('/user_request/status/new/sdm'); !!}" class="slide-item @yield('userRequestNewSdmMenuClass')"> Request Baru</a></li>
                                <li><a href="{!! url('/user_request/status/request_approval/sdm'); !!}" class="slide-item @yield('userRequestRequestApprovalSdmMenuClass')"> Permintaan Approval</a></li>
                                <li><a href="{!! url('/user_request/status/approved/sdm'); !!}" class="slide-item @yield('userRequestApprovedSdmMenuClass')"> Disetujui</a></li>
                                <li><a href="{!! url('/user_request/status/rejected/sdm'); !!}" class="slide-item @yield('userRequestRejectedSdmMenuClass')"> Ditolak</a></li>
                            </ul>
                        </li>
                        @endif
                        @if (getPermissions('user_request_diklat')['checked'])
                        <li class="slide @yield('userRequestDiklatMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">Approval Diklat</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{!! url('/user_request/status/new/diklat'); !!}" class="slide-item  @yield('userRequestNewDiklatMenuClass')"> Request Baru</a></li>
                                <li><a href="{!! url('/user_request/status/request_approval/diklat'); !!}" class="slide-item @yield('userRequestRequestApprovalDiklatMenuClass')"> Permintaan Approval</a></li>
                                <li><a href="{!! url('/user_request/status/approved/diklat'); !!}" class="slide-item @yield('userRequestApprovedDiklatMenuClass')"> Disetujui</a></li>
                                <li><a href="{!! url('/user_request/status/rejected/diklat'); !!}" class="slide-item @yield('userRequestRejectedDiklatMenuClass')"> Ditolak</a></li>
                            </ul>
                        </li>
                        @endif

                        @if (getPermissions('approval_penilaian_sdm')['checked'])
                        <li class="slide @yield('userRequestDiklatMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">Approval Penilaian SDM</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{!! url('/approval_penilaian_sdm/status/pending'); !!}" class="slide-item @yield('userRequestRequestApprovalDiklatMenuClass')"> Permintaan Approval</a></li>
                                <li><a href="{!! url('/approval_penilaian_sdm/status/approved'); !!}" class="slide-item @yield('userRequestApprovedDiklatMenuClass')"> Disetujui</a></li>
                            </ul>
                        </li>
                        @endif

                        @if (getPermissions('dokumen')['checked'])
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="{!! url('/document_unit'); !!}"><i class="side-menu__icon fe fe-folder"></i><span class="side-menu__label">Dokumen</span></a>
                        </li>
                        @endif

                        @if (getPermissions('complaint')['checked'])
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="{!! url('/complaint'); !!}"><i class="side-menu__icon fe fe-folder"></i><span class="side-menu__label">E-Complaint</span></a>
                        </li>
                        @endif

                        @if (getPermissions('e_monev')['checked'])
                        <li class="slide @yield('MonevMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">E-Monev</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{!! url('/kebutuhan_belanja'); !!}" class="slide-item @yield('KebutuhanBelanjaMenuClass')"> Kebutuhan Belanja</a></li>
                            </ul>
                        </li>
                        @endif

                        @if (getPermissions('laporan')['checked'])
                        <li class="slide @yield('LaporanMenuClass')">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-clipboard"></i><span class="side-menu__label">Laporan</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{!! url('/laporan_iki'); !!}" class="slide-item @yield('LaporanIkiMenuClass')"> Laporan IKI</a></li>
                            </ul>
                        </li>
                        @endif

                        @if (getPermissions('modul_pengguna')['checked'])
                        <li class="sub-category">
                            <h3>Modul Pengguna</h3>
                        </li>
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">User</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                              @if (getPermissions('profile')['checked'])
                              <li><a href="{!! url('/profile'); !!}" class="slide-item"> Profil User</a></li>
                              @endif
                              @if (getPermissions('change_password')['checked'])
                              <li><a href="{!! url('/change_password'); !!}" class="slide-item"> Ganti Password</a></li>
                              @endif
                              @if (getPermissions('hak_akses')['checked'])
                              <li><a href="{!! url('/position'); !!}" class="slide-item"> Hak Akses</a></li>
                              @endif
                              @if (getPermissions('user')['checked'])
                              <li><a href="{!! url('/user'); !!}" class="slide-item"> User</a></li>
                              @endif
                            </ul>
                        </li>
                        @endif

                        @if (getPermissions('master_data')['checked'])
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fe fe-shopping-bag"></i><span class="side-menu__label">Master Data</span><i class="angle fe fe-chevron-right"></i></a>
                            <ul class="slide-menu">
                              @if (getPermissions('golongan')['checked'])
                              <li><a href="{!! url('/golongan'); !!}" class="slide-item"> Golongan</a></li>
                              @endif
                              @if (getPermissions('indikator_kinerja')['checked'])
                              <li><a href="{!! url('/indikator_kinerja'); !!}" class="slide-item"> Indikator Kinerja</a></li>
                              @endif
                              @if (getPermissions('indikator_tetap')['checked'])
                              <li><a href="{!! url('/indikator_tetap'); !!}" class="slide-item"> Indikator Tetap</a></li>
                              @endif
                              @if (getPermissions('unit_kerja')['checked'])
                              <li><a href="{!! url('/unit_kerja'); !!}" class="slide-item"> Unit Kerja</a></li>
                              @endif
                              @if (getPermissions('jabatan')['checked'])
                              <li><a href="{!! url('/jabatan'); !!}" class="slide-item"> Jabatan</a></li>
                              @endif
                              @if (getPermissions('jabatan_fungsional')['checked'])
                              <li><a href="{!! url('/jabatan_fungsional'); !!}" class="slide-item"> Jabatan Fungsional</a></li>
                              @endif
                              @if (getPermissions('pendidikan')['checked'])
                              <li><a href="{!! url('/pendidikan'); !!}" class="slide-item"> Pendidikan</a></li>
                              @endif
                              @if (getPermissions('status_pegawai')['checked'])
                              <li><a href="{!! url('/status_pegawai'); !!}" class="slide-item"> Status Pegawai</a></li>
                              @endif
                              @if (getPermissions('pelatihan')['checked'])
                              <li><a href="{!! url('/pelatihan'); !!}" class="slide-item"> Pelatihan</a></li>
                              @endif
                              @if (getPermissions('kampus')['checked'])
                              <li><a href="{!! url('/kampus'); !!}" class="slide-item"> Kampus</a></li>
                              @endif
                              @if (getPermissions('mata_anggaran')['checked'])
                              <li><a href="{!! url('/mata_anggaran'); !!}" class="slide-item"> Mata Anggaran</a></li>
                              @endif
                            </ul>
                        </li>
                        @endif
                        @if (getPermissions('config')['checked'])
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="/config">
                              <i class="side-menu__icon fe fe-settings"></i>
                              <span class="side-menu__label">Konfigurasi</span>
                            </a>
                        </li>
                        @endif
                        @if (getPermissions('audit_trail')['checked'])
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="/audit_trail">
                              <i class="side-menu__icon fe fe-book"></i>
                              <span class="side-menu__label">Audit Trail</span>
                            </a>
                        </li>
                        @endif
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" target="_blank" href="/Juknis.Simpeg.Ver.0.2.pdf">
                              <i class="side-menu__icon fe fe-book  "></i>
                              <span class="side-menu__label">Buku Petunjuk</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="/logout">
                              <i class="side-menu__icon fe fe-log-out"></i>
                              <span class="side-menu__label">Logout</span>
                            </a>
                        </li>
                      </ul>
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
                </div>
            </div>
            <!--/APP-SIDEBAR-->
        </div>
