@extends('main.body.master')

@section('title', 'My Profile')

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
                            <h1 class="mb-0 h5">Sam Lanson <i class="bi bi-patch-check-fill text-success small"></i></h1>
                            <p>250 connections</p>
                        </div>
                        <!-- Button -->
                        <div class="d-flex mt-3 justify-content-center ms-sm-auto">
                            <button class="btn btn-danger-soft me-2" type="button"> <i class="bi bi-pencil-fill pe-1"></i>
                                Edit profile </button>
                            <div class="dropdown">
                                <!-- Card share action menu -->
                                <button class="icon-md btn btn-light" type="button" id="profileAction2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <!-- Card share action dropdown menu -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileAction2">
                                    <li><a class="dropdown-item" href="#"> <i
                                                class="bi bi-bookmark fa-fw pe-2"></i>Share profile in a message</a></li>
                                    <li><a class="dropdown-item" href="#"> <i
                                                class="bi bi-file-earmark-pdf fa-fw pe-2"></i>Save your profile to PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-lock fa-fw pe-2"></i>Lock
                                            profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#"> <i
                                                class="bi bi-gear fa-fw pe-2"></i>Profile settings</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- List profile -->
                    <ul class="list-inline mb-0 text-center text-sm-start mt-3 mt-sm-0">
                        <li class="list-inline-item"><i class="bi bi-briefcase me-1"></i> Lead Developer</li>
                        <li class="list-inline-item"><i class="bi bi-geo-alt me-1"></i> New Hampshire</li>
                        <li class="list-inline-item"><i class="bi bi-calendar2-plus me-1"></i> Joined on Nov 26, 2019</li>
                    </ul>
                </div>
                <!-- Card body END -->

                <div class="card-footer mt-3 pt-2 pb-0">
                    <ul class="nav nav-bottom-line justify-content-center justify-content-md-start border-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#posts">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#connections">Connections</a>
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
document.addEventListener('DOMContentLoaded', function () {

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
});
</script>


@endsection
