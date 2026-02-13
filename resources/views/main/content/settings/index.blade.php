@extends('main.body.master')

@section('title', 'settings')

@section('main')
    <div class="row">

        <!-- Sidenav START -->
        <div class="col-lg-3">

            <!-- Advanced filter responsive toggler START -->
            <!-- Divider -->
            <div class="d-flex align-items-center mb-4 d-lg-none">
                <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="btn btn-primary"><i class="fa-solid fa-sliders-h"></i></span>
                    <span class="h6 mb-0 fw-bold d-lg-none ms-2">Settings</span>
                </button>
            </div>
            <!-- Advanced filter responsive toggler END -->

            <nav class="navbar navbar-light navbar-expand-lg mx-0">
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                    <!-- Offcanvas header -->
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <!-- Offcanvas body -->
                    <div class="offcanvas-body p-0">
                        <!-- Card START -->
                        <div class="card w-100">
                            <!-- Card body START -->
                            <div class="card-body">

                                <!-- Side Nav START -->
                                <ul class="nav nav-tabs nav-pills nav-pills-soft flex-column fw-bold gap-2 border-0">
                                    <li class="nav-item" data-bs-dismiss="offcanvas">
                                        <a class="nav-link d-flex mb-0 active" href="#nav-setting-tab-1"
                                            data-bs-toggle="tab"> <img class="me-2 h-20px fa-fw"
                                                src="{{ asset('assets/images/icon/person-outline-filled.svg') }}"
                                                alt=""><span>Account </span></a>
                                    </li>
                                    <li class="nav-item" data-bs-dismiss="offcanvas">
                                        <a class="nav-link d-flex mb-0" href="#nav-setting-tab-2" data-bs-toggle="tab"> <img
                                                class="me-2 h-20px fa-fw"
                                                src="{{ asset('assets/images/icon/notification-outlined-filled.svg') }}"
                                                alt=""><span>Notification </span></a>
                                    </li>
                                    <li class="nav-item" data-bs-dismiss="offcanvas">
                                        <a class="nav-link d-flex mb-0" href="#nav-setting-tab-3" data-bs-toggle="tab"> <img
                                                class="me-2 h-20px fa-fw" src="{{ asset('assets/images/icon/shield-outline-filled.svg') }}"
                                                alt=""><span>Privacy and safety </span></a>
                                    </li>
                                    <li class="nav-item" data-bs-dismiss="offcanvas">
                                        <a class="nav-link d-flex mb-0" href="#nav-setting-tab-4" data-bs-toggle="tab"> <img
                                                class="me-2 h-20px fa-fw"
                                                src="{{ asset('assets/images/icon/handshake-outline-filled.svg') }}"
                                                alt=""><span>Communications </span></a>
                                    </li>
                                    <li class="nav-item" data-bs-dismiss="offcanvas">
                                        <a class="nav-link d-flex mb-0" href="#nav-setting-tab-5" data-bs-toggle="tab"> <img
                                                class="me-2 h-20px fa-fw"
                                                src="{{ asset('assets/images/icon/chat-alt-outline-filled.svg') }}"
                                                alt=""><span>Messaging </span></a>
                                    </li>
                                    <li class="nav-item" data-bs-dismiss="offcanvas">
                                        <a class="nav-link d-flex mb-0" href="#nav-setting-tab-6" data-bs-toggle="tab"> <img
                                                class="me-2 h-20px fa-fw"
                                                src="{{ asset('assets/images/icon/trash-var-outline-filled.svg') }}"
                                                alt=""><span>Close account </span></a>
                                    </li>
                                </ul>
                                <!-- Side Nav END -->

                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- Card END -->
                    </div>
                    <!-- Offcanvas body -->

                    <p class="small text-center mt-3">©2024 <a class="text-reset" target="_blank"
                            href="https://stackbros.in/"> StackBros </a></p>

                </div>
            </nav>
        </div>
        <!-- Sidenav END -->

        <!-- Main content START -->
        <div class="col-lg-6 vstack gap-4">
            <!-- Setting Tab content START -->
            <div class="tab-content py-0 mb-0">

                <!-- Account setting tab START -->
                    @include('main.content.settings.partials.profile')
                <!-- Account setting tab END -->

                <!-- Notification tab START -->
                    @include('main.content.settings.partials.notification')
                <!-- Notification tab END -->

                <!-- Privacy and safety tab START -->
                    @include('main.content.settings.partials.privacy')
                <!-- Privacy and safety tab END -->

                <!-- Communications tab START -->
                    @include('main.content.settings.partials.communication')
                <!-- Communications tab END -->

                <!-- Messaging tab START -->
                    @include('main.content.settings.partials.message')
                <!-- Messaging tab END -->

                <!-- Close account tab START -->
                    @include('main.content.settings.partials.close-account')
                <!-- Close account tab END -->

            </div>
            <!-- Setting Tab content END -->
        </div>

    </div> <!-- Row END -->

@endsection

@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr", {
                dateFormat: "Y-m-d"
            });
        });
    </script>

@endsection