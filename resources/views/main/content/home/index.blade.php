@extends('main.body.master')

@section('title', 'Homepage')



@section('style')

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

    @include('main.content.home.css.index')

@endsection

@section('main')
    <div class="row g-4">

        <!-- Sidenav START -->
        <div class="col-lg-3">

            <!-- Advanced filter responsive toggler START -->
            <div class="d-flex align-items-center d-lg-none">
                <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasSideNavbar" aria-controls="offcanvasSideNavbar">
                    <span class="btn btn-primary"><i class="fa-solid fa-sliders-h"></i></span>
                    <span class="h6 mb-0 fw-bold d-lg-none ms-2">My profile</span>
                </button>
            </div>
            <!-- Advanced filter responsive toggler END -->

            <!-- Navbar START-->
            @include('main.content.home.leftside')
            <!-- Navbar END-->
        </div>
        <!-- Sidenav END -->

        <!-- Main content START -->
        <div class="col-md-8 col-lg-6 vstack gap-4">

            <!-- Story START -->
            
                @include('main.content.home.stories')

            <!-- Story END -->

            <!-- Share feed START -->
            <div class="card card-body">
                <div class="d-flex mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-xs me-2">
                        <a href="#"> <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg"
                                alt=""> </a>
                    </div>
                    <!-- Post input -->
                    <form class="w-100">
                        <textarea class="form-control pe-4 border-0" rows="2" data-autoresize placeholder="Share your thoughts..."></textarea>
                    </form>
                </div>
                <!-- Share feed toolbar START -->
                <ul class="nav nav-pills nav-stack small fw-normal">
                    <li class="nav-item">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                            data-bs-target="#feedActionPhoto"> <i class="bi bi-image-fill text-success pe-2"></i>Photo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                            data-bs-target="#feedActionVideo"> <i
                                class="bi bi-camera-reels-fill text-info pe-2"></i>Video</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link bg-light py-1 px-2 mb-0" data-bs-toggle="modal"
                            data-bs-target="#modalCreateEvents"> <i
                                class="bi bi-calendar2-event-fill text-danger pe-2"></i>Event </a>
                    </li>
                    <li class="nav-item dropdown ms-lg-auto">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#" id="feedActionShare"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </a>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="feedActionShare">
                            <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Create
                                    a poll</a></li>
                            <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark-check fa-fw pe-2"></i>Ask
                                    a question </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"> <i
                                        class="bi bi-pencil-square fa-fw pe-2"></i>Help</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Share feed toolbar END -->
            </div>
            <!-- Share feed END -->

            <!-- Card feed item START -->
            <div id="postsFeed">
                @foreach ($posts as $post)
                    @include('main.post_card.index', ['post' => $post])
                @endforeach
            </div>


            <!-- Card feed item END -->

            <!-- Card feed item START -->
            <div class="card">
                <!-- Card header START -->
                <div class="card-header d-flex justify-content-between align-items-center border-0 pb-0">
                    <h6 class="card-title mb-0">People you may know</h6>
                    <button class="btn btn-sm btn-primary-soft"> See all </button>
                </div>
                <!-- Card header START -->

                <!-- Card body START -->
                <div class="card-body">
                    <div class="tiny-slider arrow-hover">
                        <div class="tiny-slider-inner ms-n4" data-arrow="true" data-dots="false" data-items-xl="3"
                            data-items-lg="2" data-items-md="2" data-items-sm="2" data-items-xs="1" data-gutter="12"
                            data-edge="30">
                            <!-- Slider items -->
                            <div>
                                <!-- Card add friend item START -->
                                <div class="card shadow-none text-center">
                                    <!-- Card body -->
                                    <div class="card-body p-2 pb-0">
                                        <div class="avatar avatar-xl">
                                            <a href="#!"><img class="avatar-img rounded-circle"
                                                    src="assets/images/avatar/09.jpg" alt=""></a>
                                        </div>
                                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Amanda Reed </a></h6>
                                        <p class="mb-0 small lh-sm">50 mutual connections</p>
                                    </div>
                                    <!-- Card footer -->
                                    <div class="card-footer p-2 border-0">
                                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                                    </div>
                                </div>
                                <!-- Card add friend item END -->
                            </div>
                            <div>
                                <!-- Card add friend item START -->
                                <div class="card shadow-none text-center">
                                    <!-- Card body -->
                                    <div class="card-body p-2 pb-0">
                                        <div class="avatar avatar-story avatar-xl">
                                            <a href="#!"><img class="avatar-img rounded-circle"
                                                    src="assets/images/avatar/10.jpg" alt=""></a>
                                        </div>
                                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Larry Lawson </a></h6>
                                        <p class="mb-0 small lh-sm">33 mutual connections</p>
                                    </div>
                                    <!-- Card footer -->
                                    <div class="card-footer p-2 border-0">
                                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                                    </div>
                                </div>
                                <!-- Card add friend item END -->
                            </div>
                            <div>
                                <!-- Card add friend item START -->
                                <div class="card shadow-none text-center">
                                    <!-- Card body -->
                                    <div class="card-body p-2 pb-0">
                                        <div class="avatar avatar-xl">
                                            <a href="#!"><img class="avatar-img rounded-circle"
                                                    src="assets/images/avatar/11.jpg" alt=""></a>
                                        </div>
                                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Louis Crawford </a></h6>
                                        <p class="mb-0 small lh-sm">45 mutual connections</p>
                                    </div>
                                    <!-- Card footer -->
                                    <div class="card-footer p-2 border-0">
                                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                                    </div>
                                </div>
                                <!-- Card add friend item END -->
                            </div>
                            <div>
                                <!-- Card add friend item START -->
                                <div class="card shadow-none text-center">
                                    <!-- Card body -->
                                    <div class="card-body p-2 pb-0">
                                        <div class="avatar avatar-xl">
                                            <a href="#!"><img class="avatar-img rounded-circle"
                                                    src="assets/images/avatar/12.jpg" alt=""></a>
                                        </div>
                                        <h6 class="card-title mb-1 mt-3"> <a href="#!"> Dennis Barrett </a></h6>
                                        <p class="mb-0 small lh-sm">21 mutual connections</p>
                                    </div>
                                    <!-- Card footer -->
                                    <div class="card-footer p-2 border-0">
                                        <button class="btn btn-sm btn-primary-soft w-100"> Add friend </button>
                                    </div>
                                </div>
                                <!-- Card add friend item END -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card body END -->
            </div>
            <!-- Card feed item END -->

            <!-- Story START -->
            <div>
                <h6 class="mb-3">Suggested stories </h6>
                <div class="tiny-slider arrow-hover overflow-hidden">
                    <div class="tiny-slider-inner ms-n4" data-arrow="true" data-dots="true" data-loop="false"
                        data-autoplay="false" data-items-xl="4" data-items-lg="3" data-items-md="3" data-items-sm="3"
                        data-items-xs="2" data-gutter="12" data-edge="24">

                        <!-- Slider items -->
                        <div>
                            <!-- Card START -->
                            <div class="card card-overlay-bottom border-0 position-relative h-150px"
                                style="background-image:url(assets/images/post/1by1/02.jpg); background-position: center left; background-size: cover;">
                                <div class="card-img-overlay d-flex align-items-center p-2">
                                    <div class="w-100 mt-auto">
                                        <!-- Name -->
                                        <a href="#!" class="stretched-link text-white small">Judy Nguyen</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card END -->
                        </div>

                        <!-- Slider items -->
                        <div>
                            <!-- Card START -->
                            <div class="card card-overlay-bottom border-0 position-relative h-150px"
                                style="background-image:url(assets/images/post/1by1/03.jpg); background-position: center left; background-size: cover;">
                                <div class="card-img-overlay d-flex align-items-center p-2">
                                    <div class="w-100 mt-auto">
                                        <!-- Name -->
                                        <a href="#!" class="stretched-link text-white small">Samuel Bishop</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card END -->
                        </div>

                        <!-- Slider items -->
                        <div>
                            <!-- Card START -->
                            <div class="card card-overlay-bottom border-0 position-relative h-150px"
                                style="background-image:url(assets/images/post/1by1/04.jpg); background-position: center left; background-size: cover;">
                                <div class="card-img-overlay d-flex align-items-center p-2">
                                    <div class="w-100 mt-auto">
                                        <!-- Name -->
                                        <a href="#!" class="stretched-link text-white small">Carolyn Ortiz</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card END -->
                        </div>

                        <!-- Slider items -->
                        <div>
                            <!-- Card START -->
                            <div class="card card-overlay-bottom border-0 position-relative h-150px"
                                style="background-image:url(assets/images/post/1by1/05.jpg); background-position: center left; background-size: cover;">
                                <div class="card-img-overlay d-flex align-items-center p-2">
                                    <div class="w-100 mt-auto">
                                        <!-- Name -->
                                        <a href="#!" class="stretched-link text-white small">Amanda Reed</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card END -->
                        </div>

                        <!-- Slider items -->
                        <div>
                            <!-- Card START -->
                            <div class="card card-overlay-bottom border-0 position-relative h-150px"
                                style="background-image:url(assets/images/post/1by1/01.jpg); background-position: center left; background-size: cover;">
                                <div class="card-img-overlay d-flex align-items-center p-2">
                                    <div class="w-100 mt-auto">
                                        <!-- Name -->
                                        <a href="#!" class="stretched-link text-white small">Lori Stevens</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card END -->
                        </div>

                        <!-- Slider items -->
                        <div>
                            <!-- Card START -->
                            <div class="card card-overlay-bottom border-0 position-relative h-150px"
                                style="background-image:url(assets/images/post/1by1/06.jpg); background-position: center left; background-size: cover;">
                                <div class="card-img-overlay d-flex align-items-center p-2">
                                    <div class="w-100 mt-auto">
                                        <!-- Name -->
                                        <a href="#!" class="stretched-link text-white small">Joan Wallace</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card END -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Story END -->

            <!-- Load more button START -->
            <a href="#!" role="button" class="btn btn-loader btn-primary-soft" data-bs-toggle="button"
                aria-pressed="true">
                <span class="load-text"> Load more </span>
                <div class="load-icon">
                    <div class="spinner-grow spinner-grow-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </a>
            <!-- Load more button END -->

        </div>
        <!-- Main content END -->

        <!-- Right sidebar START -->
        @include('main.content.home.rightside')
        <!-- Right sidebar END -->

    </div> <!-- Row END -->

    <!-- Modal create Feed photo START -->
    @include('main.modals.homeModals.postCreateModal')

    <!-- Modal create Feed photo END -->

    <!-- Modal create Feed video START -->
    @include('main.modals.homeModals.videoCreateModal')
    <!-- Modal create Feed video END -->

    <!-- Modal create events START -->
    @include('main.modals.homeModals.eventCreateModal')
    <!-- Modal create events END -->

    @include('main.modals.homeModals.postEditModal')


@endsection

@section('script')

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    @include('main.content.home.js.stories')

    @include('main.content.home.js.index')

@endsection
