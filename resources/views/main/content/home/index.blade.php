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
                    <div class="btn-primary-soft py-2 px-3 rounded intro-mainpg">Show the world what you're creating. Drop a
                        photo or video below.</div>
                </div>
                <!-- Share feed toolbar START -->
                <ul class="nav nav-pills nav-stack small fw-normal intro-mainpg">
                    <li class="nav-item">
                        <a  class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                            data-bs-target="#feedActionMultiple" title="More Options"> <i class="fa-solid fa-plus"></i> </a>
                    </li>
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
                            data-bs-target="#modalCreateBlog"> <i
                                class="bi bi-calendar2-event-fill text-danger pe-2"></i>Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#"><i
                                class="bi bi-chat-left-dots-fill text-success pe-2"></i>Ask
                            a question </a>
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

            @if ($posts->nextPageUrl())
                <div class="text-center" id="loadMoreWrap">
                    <button class="btn btn-primary-soft btn-lg w-100" id="loadMoreBtn"
                        data-next-page="{{ route('posts.loadMore', ['page' => $posts->currentPage() + 1]) }}">
                        Load more
                    </button>
                </div>
            @endif


            <!-- Card feed item END -->

        </div>
        <!-- Main content END -->

        <!-- Right sidebar START -->
        @include('main.content.home.rightside')
        <!-- Right sidebar END -->

    </div> <!-- Row END -->

    @include('main.modals.homeModals.multipleCreateModal')

    <!-- Modal create Feed photo START -->
    @include('main.modals.homeModals.postCreateModal')
    <!-- Modal create Feed photo END -->

    <!-- Modal create Feed video START -->
    @include('main.modals.homeModals.videoCreateModal')
    <!-- Modal create Feed video END -->

    <!-- Modal create blogs START -->
    @include('main.modals.homeModals.blogCreateModal')
    <!-- Modal create blogs END -->

    @include('main.modals.homeModals.postEditModal')


@endsection

@section('script')

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    @include('main.content.home.js.stories')

    @include('main.content.home.js.index')

@endsection

