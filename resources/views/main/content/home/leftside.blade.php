<nav class="navbar navbar-expand-lg mx-0">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
        <!-- Offcanvas header -->
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <!-- Offcanvas body -->
        <div class="offcanvas-body d-block px-2 px-lg-0">
            <!-- Card START -->
            <div class="card overflow-hidden">
                <!-- Cover image -->
                <div class="h-50px"
                    style="background-image:url(assets/images/bg/01.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;">
                </div>
                <!-- Card body START -->
                <div class="card-body pt-0">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="avatar avatar-lg mt-n5 mb-3">
                            <a href="#!"><img style="height: 100%"
                                    src="{{ Auth::user()->image ? asset('assets/images/users/' . Auth::user()->image) : asset('assets/images/07.jpg') }}"
                                    class="rounded-circle" width="120" height="120" alt="Profile Image"></a>
                        </div>
                        <!-- Info -->
                        <h5 class="mb-0"> <a href="{{ route('profile.index') }}">{{ Auth::user()->username }}</a>
                        </h5>
                        <small>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</small>
    @if(Auth::user()->is_subscribed)
        <span class="ms-1 text-primary" title="Verified Member">
            <i class="bi bi-patch-check-fill text-success small"></i>
        </span>
    @endif
            
                        <p class="mt-3">{{ \Illuminate\Support\Str::limit(Auth::user()->description, 75, '...') }}
                        </p>

                        <!-- User stat START -->
                        <div class="hstack gap-2 gap-xl-3 justify-content-center">
                            <!-- User stat item -->
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->posts()->count() }}</h6>
                                <small>Post</small>
                            </div>
                            <!-- Divider -->
                            <div class="vr"></div>
                            <!-- User stat item -->
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->followers()->count() }}</h6>
                                <small>Followers</small>
                            </div>
                            <!-- Divider -->
                            <div class="vr"></div>
                            <!-- User stat item -->
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->following()->count() }}</h6>
                                <small>Following</small>
                            </div>
                        </div>
                        <!-- User stat END -->
                    </div>

                    <!-- Divider -->
                    <hr>

                    <!-- Side Nav START -->
                    <ul class="nav nav-link-secondary flex-column fw-bold gap-2">

                        <!-- PROFILE TABS (hash-based) -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}">
                                <img class="me-2 h-20px fa-fw"
                                    src="{{ asset('assets/images/icon/person-outline-filled.svg') }}" alt="">
                                <span>Profile</span>
                            </a>
                        </li>

                        <li class="nav-item">
    <a class="nav-link" href="{{ route('plans.index') }}#plans"> <img class="me-2 h-20px fa-fw"
            src="{{ asset('assets/images/icon/clipboard-outline-filled.svg') }}" alt="">
        <span>Plans</span>
    </a>
</li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}#posts">
                                <img class="me-2 h-20px fa-fw"
                                    src="{{ asset('assets/images/icon/home-outline-filled.svg') }}" alt="">
                                <span>Posts</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}#connections">
                                <img class="me-2 h-20px fa-fw"
                                    src="{{ asset('assets/images/icon/handshake-outline-filled.svg') }}"
                                    alt="">
                                <span>Connections</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('messages.index') }}">
                                <img class="me-2 h-20px fa-fw"
                                    src="{{ asset('assets/images/icon/chat-outline-filled.svg') }}" alt="">
                                <span>Messages</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home.pp') }}">
                                <img class="me-2 h-20px fa-fw"
                                    src="{{ asset('assets/images/icon/shield-outline-filled.svg') }}" alt="">
                                <span>Privacy & Terms</span>
                            </a>
                        </li>

                    </ul>

                    <!-- Side Nav END -->
                </div>
                <!-- Card body END -->
            </div>
            <!-- Card END -->
            <ul class="nav justify-content-center justify-content-sm-center my-2">
                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="#"><i class="fa-brands fa-facebook-square"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="#"><i class="fa-brands fa-twitter-square"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="#"><i class="fa-brands fa-linkedin"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="#"><i class="fa-brands fa-youtube-square"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="#"><i class="fa-brands fa-instagram"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 fs-5" href="#"><i class="fa-brands fa-tiktok"></i></a>
                </li>
            </ul>
            <!-- Copyright -->
            <p class="small text-center">©2024 <a class="text-reset" target="_blank" href="https://stackbros.in/">
                    StackBros </a></p>
        </div>
    </div>
</nav>
