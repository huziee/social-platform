@extends('main.body.master')

@section('title', 'My Profile')

@section('style')
    @include('main.content.home.css.index')

    <style>
        .profile-post-thumb {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .profile-post-thumb img,
        .profile-post-thumb video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-post-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            color: #fff;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .profile-post-thumb:hover .profile-post-overlay {
            opacity: 1;
        }

        /* Standardize media size inside profile post modal */
        #postModal .modal-dialog {
            max-width: 720px;
        }

        #postModal .card {
            max-width: 680px;
            margin: 0 auto;
        }

        /* Any media inside the loaded post card in the modal */
        #postModal [id^="post-media-"] img,
        #postModal [id^="post-media-"] video,
        #postModal .insta-slider img,
        #postModal .insta-slider video {
            width: 100%;
            max-height: 60vh;
            object-fit: contain;
        }
    </style>
@endsection

@section('main')


    <div class="row g-4">

        <!-- Main content START -->
        <div class="col-lg-8 vstack gap-4">
            <!-- My profile START -->
            <div class="card">
                <!-- Cover image -->
                <div class="h-200px rounded-top"
                    style="background-image:url({{ asset('assets/images/bg/05.jpg') }}); background-position: center; background-size: cover; background-repeat: no-repeat;">
                </div>
                <!-- Card body START -->
                <div class="card-body py-0">
                    <div class="d-sm-flex align-items-start text-center text-sm-start">
                        <div>
                            <!-- Avatar -->
                            <div class="avatar avatar-xxl mt-n5 mb-3">
                                <img class="avatar-img rounded-circle border border-white border-3"
                                    src="{{ Auth::user()->image ? asset('assets/images/users/' . Auth::user()->image) : asset('assets/images/07.jpg') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="ms-sm-4 mt-sm-3">
                            <!-- Info -->
                            <h1 class="mb-0 h5">{{ Auth::user()->first_name }}  {{ Auth::user()->last_name }} <i class="bi bi-patch-check-fill text-success small"></i></h1>
                            <p>{{ Auth::user()->username }}</p>
                        </div>
                        <!-- Button -->
                        <div class="d-flex mt-3 justify-content-center ms-sm-auto">
                            <button class="btn btn-sm btn-danger-soft me-2" type="button"> <i
                                                class="bi bi-file-earmark-pdf"></i></button>
                            <button class="btn btn-sm btn-primary-soft me-2" type="button"> <i
                                                class="bi bi-bookmark fa-fw"></i></button>
                            <button class="btn btn-sm btn-success-soft me-2" type="button"> <i
                                                class="bi bi-lock fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- List profile -->
                    <ul class="list-inline mb-0 text-center text-sm-start mt-3 mt-sm-0">
                        <li class="list-inline-item"><i class="bi bi-briefcase me-1"></i>{{ Auth::user()->description }}</li>
                </div>
                <!-- Card body END -->
                <div class="card-footer mt-2 pt-2 pb-0">
                    <ul class="nav nav-bottom-line justify-content-center justify-content-md-start border-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#posts">Posts ({{ Auth::user()->posts()->count() }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#connections">Followers ({{ Auth::user()->followers()->count() }})</a>
                        </li>

                    </ul>
                </div>

            </div>
            <!-- My profile END -->

            <div id="posts" class="profile-section">
                @include('main.content.myProfile.partials.posts')
            </div>

            <div id="connections" class="profile-section d-none">
                @include('main.content.myProfile.partials.connections')
            </div>

            <div id="about" class="profile-section d-none">
                @include('main.content.myProfile.partials.about')
            </div>



        </div>
        <!-- Main content END -->

        <!-- Right sidebar START -->
        <div class="col-lg-4">

            <div class="row g-4">

                <!-- Card START -->
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">About</h5>
                            <!-- Button modal -->
                        </div>
                        <!-- Card body START -->
                        <div class="card-body position-relative pt-0">
                            <p>He moonlights difficult engrossed it, sportsmen. Interested has all Devonshire difficulty gay
                                assistance joy.</p>
                            <!-- Date time -->
                            <ul class="list-unstyled mt-3 mb-0">
                                <li class="mb-2"> <i class="bi bi-calendar-date fa-fw pe-1"></i> Born: <strong> October
                                        20, 1990 </strong> </li>
                                <li class="mb-2"> <i class="bi bi-heart fa-fw pe-1"></i> Status: <strong> Single </strong>
                                </li>
                                <li> <i class="bi bi-envelope fa-fw pe-1"></i> Email: <strong> example@abc.com </strong>
                                </li>
                            </ul>
                        </div>
                        <!-- Card body END -->
                    </div>
                </div>
                <!-- Card END -->

                <!-- Card START -->
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-flex justify-content-between border-0">
                            <h5 class="card-title">Experience</h5>
                            <a class="btn btn-primary-soft btn-sm" href="#!"> <i class="fa-solid fa-plus"></i> </a>
                        </div>
                        <!-- Card header END -->
                        <!-- Card body START -->
                        <div class="card-body position-relative pt-0">
                            <!-- Experience item START -->
                            <div class="d-flex">
                                <!-- Avatar -->
                                <div class="avatar me-3">
                                    <a href="#!"> <img class="avatar-img rounded-circle"
                                            src="assets/images/logo/08.svg" alt=""> </a>
                                </div>
                                <!-- Info -->
                                <div>
                                    <h6 class="card-title mb-0"><a href="#!"> Apple Computer, Inc. </a></h6>
                                    <p class="small">May 2015 – Present Employment Duration 8 mos <a
                                            class="btn btn-primary-soft btn-xs ms-2" href="#!">Edit </a></p>
                                </div>
                            </div>
                            <!-- Experience item END -->

                            <!-- Experience item START -->
                            <div class="d-flex">
                                <!-- Avatar -->
                                <div class="avatar me-3">
                                    <a href="#!"> <img class="avatar-img rounded-circle"
                                            src="assets/images/logo/09.svg" alt=""> </a>
                                </div>
                                <!-- Info -->
                                <div>
                                    <h6 class="card-title mb-0"><a href="#!"> Microsoft Corporation </a></h6>
                                    <p class="small">May 2017 – Present Employment Duration 1 yrs 5 mos <a
                                            class="btn btn-primary-soft btn-xs ms-2" href="#!">Edit </a></p>
                                </div>
                            </div>
                            <!-- Experience item END -->

                            <!-- Experience item START -->
                            <div class="d-flex">
                                <!-- Avatar -->
                                <div class="avatar me-3">
                                    <a href="#!"> <img class="avatar-img rounded-circle"
                                            src="assets/images/logo/10.svg" alt=""> </a>
                                </div>
                                <!-- Info -->
                                <div>
                                    <h6 class="card-title mb-0"><a href="#!"> Tata Consultancy Services. </a></h6>
                                    <p class="small mb-0">May 2022 – Present Employment Duration 6 yrs 10 mos <a
                                            class="btn btn-primary-soft btn-xs ms-2" href="#!">Edit </a></p>
                                </div>
                            </div>
                            <!-- Experience item END -->

                        </div>
                        <!-- Card body END -->
                    </div>
                </div>
                <!-- Card END -->

                <!-- Card START -->
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex justify-content-between border-0">
                            <h5 class="card-title">Photos</h5>
                            <a class="btn btn-primary-soft btn-sm" href="#!"> See all photo</a>
                        </div>
                        <!-- Card header END -->
                        <!-- Card body START -->
                        <div class="card-body position-relative pt-0">
                            <div class="row g-2">
                                <!-- Photos item -->
                                <div class="col-6">
                                    <a href="assets/images/albums/01.jpg" data-gallery="image-popup" data-glightbox="">
                                        <img class="rounded img-fluid" src="assets/images/albums/01.jpg" alt="">
                                    </a>
                                </div>
                                <!-- Photos item -->
                                <div class="col-6">
                                    <a href="assets/images/albums/02.jpg" data-gallery="image-popup" data-glightbox="">
                                        <img class="rounded img-fluid" src="assets/images/albums/02.jpg" alt="">
                                    </a>
                                </div>
                                <!-- Photos item -->
                                <div class="col-4">
                                    <a href="assets/images/albums/03.jpg" data-gallery="image-popup" data-glightbox="">
                                        <img class="rounded img-fluid" src="assets/images/albums/03.jpg" alt="">
                                    </a>
                                </div>
                                <!-- Photos item -->
                                <div class="col-4">
                                    <a href="assets/images/albums/04.jpg" data-gallery="image-popup" data-glightbox="">
                                        <img class="rounded img-fluid" src="assets/images/albums/04.jpg" alt="">
                                    </a>
                                </div>
                                <!-- Photos item -->
                                <div class="col-4">
                                    <a href="assets/images/albums/05.jpg" data-gallery="image-popup" data-glightbox="">
                                        <img class="rounded img-fluid" src="assets/images/albums/05.jpg" alt="">
                                    </a>
                                    <!-- glightbox Albums left bar END  -->
                                </div>
                            </div>
                        </div>
                        <!-- Card body END -->
                    </div>
                </div>
                <!-- Card END -->

                <!-- Card START -->
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex justify-content-between align-items-center border-0">
                            <h5 class="card-title">Friends <span
                                    class="badge bg-danger bg-opacity-10 text-danger">230</span></h5>
                            <a class="btn btn-primary-soft btn-sm" href="#!"> See all friends</a>
                        </div>
                        <!-- Card header END -->
                        <!-- Card body START -->
                        <div class="card-body position-relative pt-0">
                            <div class="row g-3">

                                <div class="col-6">
                                    <!-- Friends item START -->
                                    <div class="card shadow-none text-center h-100">
                                        <!-- Card body -->
                                        <div class="card-body p-2 pb-0">
                                            <div class="avatar avatar-story avatar-xl">
                                                <a href="#!"><img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/02.jpg" alt=""></a>
                                            </div>
                                            <h6 class="card-title mb-1 mt-3"> <a href="#!"> Amanda Reed </a></h6>
                                            <p class="mb-0 small lh-sm">16 mutual connections</p>
                                        </div>
                                        <!-- Card footer -->
                                        <div class="card-footer p-2 border-0">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Send message"> <i
                                                    class="bi bi-chat-left-text"></i> </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Remove friend"> <i
                                                    class="bi bi-person-x"></i> </button>
                                        </div>
                                    </div>
                                    <!-- Friends item END -->
                                </div>

                                <div class="col-6">
                                    <!-- Friends item START -->
                                    <div class="card shadow-none text-center h-100">
                                        <!-- Card body -->
                                        <div class="card-body p-2 pb-0">
                                            <div class="avatar avatar-xl">
                                                <a href="#!"><img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/03.jpg" alt=""></a>
                                            </div>
                                            <h6 class="card-title mb-1 mt-3"> <a href="#!"> Samuel Bishop </a></h6>
                                            <p class="mb-0 small lh-sm">22 mutual connections</p>
                                        </div>
                                        <!-- Card footer -->
                                        <div class="card-footer p-2 border-0">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Send message"> <i
                                                    class="bi bi-chat-left-text"></i> </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Remove friend"> <i
                                                    class="bi bi-person-x"></i> </button>
                                        </div>
                                    </div>
                                    <!-- Friends item END -->
                                </div>

                                <div class="col-6">
                                    <!-- Friends item START -->
                                    <div class="card shadow-none text-center h-100">
                                        <!-- Card body -->
                                        <div class="card-body p-2 pb-0">
                                            <div class="avatar avatar-xl">
                                                <a href="#!"><img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/04.jpg" alt=""></a>
                                            </div>
                                            <h6 class="card-title mb-1 mt-3"> <a href="#"> Bryan Knight </a></h6>
                                            <p class="mb-0 small lh-sm">1 mutual connection</p>
                                        </div>
                                        <!-- Card footer -->
                                        <div class="card-footer p-2 border-0">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Send message"> <i
                                                    class="bi bi-chat-left-text"></i> </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Remove friend"> <i
                                                    class="bi bi-person-x"></i> </button>
                                        </div>
                                    </div>
                                    <!-- Friends item END -->
                                </div>

                                <div class="col-6">
                                    <!-- Friends item START -->
                                    <div class="card shadow-none text-center h-100">
                                        <!-- Card body -->
                                        <div class="card-body p-2 pb-0">
                                            <div class="avatar avatar-xl">
                                                <a href="#!"><img class="avatar-img rounded-circle"
                                                        src="assets/images/avatar/05.jpg" alt=""></a>
                                            </div>
                                            <h6 class="card-title mb-1 mt-3"> <a href="#!"> Amanda Reed </a></h6>
                                            <p class="mb-0 small lh-sm">15 mutual connections</p>
                                        </div>
                                        <!-- Card footer -->
                                        <div class="card-footer p-2 border-0">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Send message"> <i
                                                    class="bi bi-chat-left-text"></i> </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Remove friend"> <i
                                                    class="bi bi-person-x"></i> </button>
                                        </div>
                                    </div>
                                    <!-- Friends item END -->
                                </div>

                            </div>
                        </div>
                        <!-- Card body END -->
                    </div>
                </div>
                <!-- Card END -->
            </div>

        </div>
        <!-- Right sidebar END -->

    </div>

    <!-- Single post view modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0" id="postModalBody"></div>
            </div>
        </div>
    </div>

    {{-- <!-- Modal create Feed START -->
<div class="modal fade" id="modalCreateFeed" tabindex="-1" aria-labelledby="modalLabelCreateFeed" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <!-- Modal feed header START -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabelCreateFeed">Create post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal feed header END -->

      <!-- Modal feed body START -->
      <div class="modal-body">
         <!-- Add Feed -->
         <div class="d-flex mb-3">
          <!-- Avatar -->
          <div class="avatar avatar-xs me-2">
            <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
          </div>
          <!-- Feed box  -->
          <form class="w-100">
            <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="4" placeholder="Share your thoughts..." autofocus></textarea>
          </form>
        </div>
        <!-- Feed rect START -->
        <div class="hstack gap-2">
          <a class="icon-md bg-success bg-opacity-10 text-success rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Photo"> <i class="bi bi-image-fill"></i> </a>
          <a class="icon-md bg-info bg-opacity-10 text-info rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Video"> <i class="bi bi-camera-reels-fill"></i> </a>
          <a class="icon-md bg-danger bg-opacity-10 text-danger rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Events"> <i class="bi bi-calendar2-event-fill"></i> </a>
          <a class="icon-md bg-warning bg-opacity-10 text-warning rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Feeling/Activity"> <i class="bi bi-emoji-smile-fill"></i> </a>
          <a class="icon-md bg-light text-secondary rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Check in"> <i class="bi bi-geo-alt-fill"></i> </a>
          <a class="icon-md bg-primary bg-opacity-10 text-primary rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Tag people on top"> <i class="bi bi-tag-fill"></i> </a>
        </div>
        <!-- Feed rect END -->
      </div>
      <!-- Modal feed body END -->
      
      <!-- Modal feed footer -->
      <div class="modal-footer row justify-content-between">
        <!-- Select -->
        <div class="col-lg-3">
          <select class="form-select js-choice" data-position="top" data-search-enabled="false">
            <option value="PB">Public</option>
            <option value="PV">Friends</option>
            <option value="PV">Only me</option>
            <option value="PV">Custom</option>
          </select>
        </div>
        <!-- Button -->
        <div class="col-lg-8 text-sm-end">
          <button type="button" class="btn btn-danger-soft me-2"> <i class="bi bi-camera-video-fill pe-1"></i> Live video</button>
          <button type="button" class="btn btn-success-soft">Post</button>
        </div>
      </div>
      <!-- Modal feed footer -->

    </div>
  </div>
</div>
<!-- Modal create feed END -->

<!-- Modal create Feed photo START -->
<div class="modal fade" id="feedActionPhoto" tabindex="-1" aria-labelledby="feedActionPhotoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Modal feed header START -->
      <div class="modal-header">
        <h5 class="modal-title" id="feedActionPhotoLabel">Add post photo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal feed header END -->

        <!-- Modal feed body START -->
        <div class="modal-body">
        <!-- Add Feed -->
        <div class="d-flex mb-3">
          <!-- Avatar -->
          <div class="avatar avatar-xs me-2">
            <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
          </div>
          <!-- Feed box  -->
          <form class="w-100">
            <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="2" placeholder="Share your thoughts..."></textarea>
          </form>
        </div>

        <!-- Dropzone photo START -->
        <div>
          <label class="form-label">Upload attachment</label>
          <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
            <div class="dz-message">
              <i class="bi bi-images display-3"></i>
              <p>Drag here or click to upload photo.</p>
            </div>
          </div>
        </div>
        <!-- Dropzone photo END -->

        </div>
        <!-- Modal feed body END -->

        <!-- Modal feed footer -->
        <div class="modal-footer ">
          <!-- Button -->
            <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success-soft">Post</button>
        </div>
        <!-- Modal feed footer -->
    </div>
  </div>
</div>
<!-- Modal create Feed photo END -->

<!-- Modal create Feed video START -->
<div class="modal fade" id="feedActionVideo" tabindex="-1" aria-labelledby="feedActionVideoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
     <!-- Modal feed header START -->
     <div class="modal-header">
      <h5 class="modal-title" id="feedActionVideoLabel">Add post video</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <!-- Modal feed header END -->

      <!-- Modal feed body START -->
      <div class="modal-body">
       <!-- Add Feed -->
       <div class="d-flex mb-3">
        <!-- Avatar -->
        <div class="avatar avatar-xs me-2">
          <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
        </div>
        <!-- Feed box  -->
        <form class="w-100">
          <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="2" placeholder="Share your thoughts..."></textarea>
        </form>
      </div>

      <!-- Dropzone photo START -->
      <div>
        <label class="form-label">Upload attachment</label>
        <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
          <div class="dz-message">
            <i class="bi bi-camera-reels display-3"></i>
                <p>Drag here or click to upload video.</p>
          </div>
        </div>
      </div>
      <!-- Dropzone photo END -->

    </div>
      <!-- Modal feed body END -->

      <!-- Modal feed footer -->
      <div class="modal-footer">
        <!-- Button -->
        <button type="button" class="btn btn-danger-soft me-2"><i class="bi bi-camera-video-fill pe-1"></i> Live video</button>
        <button type="button" class="btn btn-success-soft">Post</button>
      </div>
      <!-- Modal feed footer -->
    </div>
  </div>
</div>
<!-- Modal create Feed video END -->

<!-- Modal create events START -->
<div class="modal fade" id="modalCreateEvents" tabindex="-1" aria-labelledby="modalLabelCreateAlbum" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Modal feed header START -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabelCreateAlbum">Create event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal feed header END -->
      <!-- Modal feed body START -->
      <div class="modal-body">
        <!-- Form START -->
        <form class="row g-4">
          <!-- Title -->
          <div class="col-12">
            <label class="form-label">Title</label>
            <input type="email" class="form-control" placeholder="Event name here">
          </div>
          <!-- Description -->
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="2" placeholder="Ex: topics, schedule, etc."></textarea>
          </div>
          <!-- Date -->
          <div class="col-sm-4">
            <label class="form-label">Date</label>
            <input type="text" class="form-control flatpickr" placeholder="Select date">
          </div>
          <!-- Time -->
          <div class="col-sm-4">
            <label class="form-label">Time</label>
            <input type="text" class="form-control flatpickr" data-enableTime="true" data-noCalendar="true" placeholder="Select time">
          </div>
          <!-- Duration -->
          <div class="col-sm-4">
            <label class="form-label">Duration</label>
            <input type="email" class="form-control" placeholder="1hr 23m">
          </div>
          <!-- Location -->
          <div class="col-12">
            <label class="form-label">Location</label>
            <input type="email" class="form-control" placeholder="Logansport, IN 46947">
          </div>
          <!-- Add guests -->
          <div class="col-12">
            <label class="form-label">Add guests</label>
            <input type="email" class="form-control" placeholder="Guest email">
          </div>
          <!-- Avatar group START -->
          <div class="col-12 mt-3">
            <ul class="avatar-group list-unstyled align-items-center mb-0">
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
              </li>
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
              </li>
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
              </li>
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar">
              </li>
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar">
              </li>
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt="avatar">
              </li>
              <li class="avatar avatar-xs">
                <img class="avatar-img rounded-circle" src="assets/images/avatar/07.jpg" alt="avatar">
              </li>
              <li class="ms-3">
                <small> +50 </small>
              </li>
            </ul>
          </div>
          <!-- Upload Photos or Videos -->
          <!-- Dropzone photo START -->
          <div>
            <label class="form-label">Upload attachment</label>
            <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
              <div class="dz-message">
                <i class="bi bi-file-earmark-text display-3"></i>
                <p>Drop presentation and document here or click to upload.</p>
              </div>
            </div>
          </div>
          <!-- Dropzone photo END -->
        </form>
        <!-- Form END -->
      </div>
      <!-- Modal feed body END -->
      <!-- Modal footer -->
      <!-- Button -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal"> Cancel</button>
        <button type="button" class="btn btn-success-soft">Create now</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal create events END --> --}}

@endsection
@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const sections = document.querySelectorAll('.profile-section');
            const tabs = document.querySelectorAll('.nav-link');

            function activateSection(hash) {

                if (!hash || !document.querySelector(hash)) {
                    hash = '#posts';
                }

                // hard reset
                sections.forEach(s => s.classList.add('d-none'));
                tabs.forEach(t => t.classList.remove('active'));

                // activate section
                document.querySelector(hash).classList.remove('d-none');

                // activate tab
                const activeTab = document.querySelector(`a[href="${hash}"]`);
                if (activeTab) activeTab.classList.add('active');
            }

            activateSection(location.hash);

            window.addEventListener('hashchange', () => {
                activateSection(location.hash);
            });

            // About section inline edit
            const aboutForm = document.getElementById('aboutForm');
            const editBtn = document.getElementById('aboutEditBtn');
            const descText = document.getElementById('aboutDescriptionText');
            const descInput = document.getElementById('aboutDescriptionInput');
            const dobText = document.getElementById('aboutDobText');
            const dobInput = document.getElementById('aboutDobInput');
            const phoneText = document.getElementById('aboutPhoneText');
            const phoneInput = document.getElementById('aboutPhoneInput');
            const firstNameText = document.getElementById('aboutFirstNameText');
            const lastNameText = document.getElementById('aboutLastNameText');
            const firstNameInput = document.getElementById('aboutFirstNameInput');
            const lastNameInput = document.getElementById('aboutLastNameInput');
            const roleText = document.getElementById('aboutRoleText');
            const roleInput = document.getElementById('aboutRoleInput');
            const statusText = document.getElementById('aboutStatusText');
            const statusInput = document.getElementById('aboutStatusInput');
            const addressText = document.getElementById('aboutAddressText');
            const addressInput = document.getElementById('aboutAddressInput');
            const emailText = document.getElementById('aboutEmailText');
            const emailInput = document.getElementById('aboutEmailInput');
            const actions = document.getElementById('aboutActions');
            const cancelBtn = document.getElementById('aboutCancelBtn');

            function enterEditMode() {
                if (!aboutForm) return;
                descText?.classList.add('d-none');
                descInput?.classList.remove('d-none');

                dobText?.classList.add('d-none');
                dobInput?.classList.remove('d-none');

                phoneText?.classList.add('d-none');
                phoneInput?.classList.remove('d-none');
                firstNameInput?.classList.remove('d-none');
                lastNameInput?.classList.remove('d-none');
                roleText?.classList.add('d-none');
                roleInput?.classList.remove('d-none');

                statusText?.classList.add('d-none');
                statusInput?.classList.remove('d-none');

                addressText?.classList.add('d-none');
                addressInput?.classList.remove('d-none');

                emailText?.classList.add('d-none');
                emailInput?.classList.remove('d-none');

                actions?.classList.remove('d-none');
                editBtn?.classList.add('d-none');
            }

            function exitEditMode() {
                if (!aboutForm) return;
                descText?.classList.remove('d-none');
                descInput?.classList.add('d-none');

                dobText?.classList.remove('d-none');
                dobInput?.classList.add('d-none');

                phoneText?.classList.remove('d-none');
                phoneInput?.classList.add('d-none');
                firstNameInput?.classList.add('d-none');
                lastNameInput?.classList.add('d-none');

                roleText?.classList.remove('d-none');
                roleInput?.classList.add('d-none');

                statusText?.classList.remove('d-none');
                statusInput?.classList.add('d-none');

                addressText?.classList.remove('d-none');
                addressInput?.classList.add('d-none');

                emailText?.classList.remove('d-none');
                emailInput?.classList.add('d-none');

                actions?.classList.add('d-none');
                editBtn?.classList.remove('d-none');
            }

            editBtn?.addEventListener('click', enterEditMode);
            cancelBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                exitEditMode();
            });

            aboutForm?.addEventListener('submit', function(e) {
                e.preventDefault();

                const payload = {
                    description: descInput?.value || '',
                    date_of_birth: dobInput?.value || null,
                    phone_number: phoneInput?.value || '',
                    first_name: firstNameInput?.value || '',
                    last_name: lastNameInput?.value || '',
                    email: emailInput?.value || '',
                    role: roleInput?.value || '',
                    status: statusInput?.value || '',
                    address: addressInput?.value || '',
                };

                fetch('{{ route('profile.about.update') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status !== 'success') {
                            alert('Could not update profile info.');
                            return;
                        }

                        if (descText) {
                            descText.textContent = payload.description ||
                                'No bio added yet. Tell people a bit about yourself.';
                        }

                        if (dobText) {
                            dobText.textContent = payload.date_of_birth || 'Not specified';
                        }

                        if (phoneText) {
                            phoneText.textContent = payload.phone_number || 'Not provided';
                        }

                        if (firstNameText) {
                            firstNameText.textContent = payload.first_name || '';
                        }

                        if (lastNameText) {
                            lastNameText.textContent = payload.last_name || '';
                        }

                        if (emailText) {
                            emailText.textContent = payload.email || '';
                        }
                        if (roleText) {
                            roleText.textContent = payload.role || 'Not specified';
                        }

                        if (statusText) {
                            statusText.textContent = payload.status ?
                                payload.status.charAt(0).toUpperCase() + payload.status.slice(1) :
                                'Not specified';
                        }

                        if (addressText) {
                            addressText.textContent = payload.address || 'Not specified';
                        }

                        exitEditMode();
                    })
                    .catch(() => {
                        alert('Server error while updating profile info.');
                    });
            });
        });

        let postModal;
        let commentsModal;

        function openPostModal(postId) {
            const modalEl = document.getElementById('postModal');
            if (!postModal && modalEl) {
                postModal = new bootstrap.Modal(modalEl);
            }

            fetch(`/posts/${postId}/preview`)
                .then(res => res.json())
                .then(data => {
                    const body = document.getElementById('postModalBody');
                    if (!body || !data.html) return;

                    body.innerHTML = data.html;

                    // Initialize media sliders inside the loaded post
                    if (typeof initSliders === 'function') {
                        initSliders();
                    }

                    const commentsEl = document.getElementById('commentsModal');
                    if (commentsEl) {
                        commentsModal = new bootstrap.Modal(commentsEl);
                    }

                    postModal && postModal.show();
                })
                .catch(err => console.error('Post preview failed:', err));
        }

        function openCommentsModal(postId) {
            if (!commentsModal) {
                const modalElem = document.getElementById('commentsModal');
                if (modalElem) {
                    commentsModal = new bootstrap.Modal(modalElem);
                }
            }

            if (!commentsModal) return;

            document.getElementById('modal-post-id').value = postId;
            loadModalComments(postId);
            commentsModal.show();
        }

        function loadModalComments(postId) {
            fetch(`/comments/${postId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    let html = '';
                    data.forEach(c => {
                        let avatar = c.user.image ?
                            `/assets/images/users/${c.user.image}` :
                            `/assets/images/avatar/07.jpg`;

                        html += `
                <li class="comment-item mb-3">
                    <div class="d-flex">
                        <div class="avatar avatar-xs me-2">
                            <img class="avatar-img rounded-circle" src="${avatar}">
                        </div>
                        <div class="bg-light p-3 rounded w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">${c.user.username}</h6>
                                <small>${timeAgo(c.created_at)}</small>
                            </div>
                            <p class="small mb-0">${c.comment}</p>
                        </div>
                    </div>
                </li>`;
                    });
                    const target = document.getElementById('modal-comments');
                    if (target) {
                        target.innerHTML = html || '<p class="text-center">No comments yet.</p>';
                    }
                })
                .catch(err => console.error('Fetch error:', err));
        }

        function submitModalComment(e) {
            e.preventDefault();

            const form = e.target;
            const input = form.querySelector('textarea');
            const postId = form.closest('.modal-content') ?
                document.getElementById('modal-post-id').value :
                form.getAttribute('data-post-id');

            if (!input.value.trim()) return;

            fetch('/comments', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        post_id: postId,
                        comment: input.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        input.value = '';
                        if (form.closest('.modal')) {
                            loadModalComments(postId);
                        } else {
                            location.reload();
                        }
                    } else {
                        alert(data.message || 'Error posting comment');
                    }
                })
                .catch(err => console.error('Submission error:', err));
        }

        function timeAgo(date) {
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            const intervals = {
                year: 31536000,
                month: 2592000,
                day: 86400,
                hour: 3600,
                minute: 60
            };
            for (let key in intervals) {
                const value = Math.floor(seconds / intervals[key]);
                if (value >= 1) return value + ' ' + key + (value > 1 ? 's' : '') + ' ago';
            }
            return 'just now';
        }

        function initSliders() {
            document.querySelectorAll('.insta-slider').forEach(slider => {
                // Skip if already initialized
                if (slider.dataset.initialized) return;
                slider.dataset.initialized = true;

                const track = slider.querySelector('.insta-track');
                const slides = slider.querySelectorAll('.insta-slide');
                const prev = slider.querySelector('.prev');
                const next = slider.querySelector('.next');
                let index = 0;

                function update() {
                    if (!track) return;
                    track.style.transform = `translateX(-${index * 100}%)`;
                }

                next?.addEventListener('click', () => {
                    if (slides.length === 0) return;
                    index = (index + 1) % slides.length;
                    update();
                });

                prev?.addEventListener('click', () => {
                    if (slides.length === 0) return;
                    index = (index - 1 + slides.length) % slides.length;
                    update();
                });

                // Touch support
                let startX = 0;
                slider.addEventListener('touchstart', e => startX = e.touches[0].clientX);
                slider.addEventListener('touchend', e => {
                    const endX = e.changedTouches[0].clientX;
                    if (startX - endX > 50) next?.click();
                    if (endX - startX > 50) prev?.click();
                });
            });
        }

        function toggleLike(postId) {
            fetch(`/like/${postId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const el = document.getElementById(`like-count-${postId}`);
                    if (el) {
                        el.innerText = data.count + ' like' + (data.count !== 1 ? 's' : '');
                    }
                })
                .catch(err => console.error('Like toggle failed:', err));
        }
    </script>


@endsection
