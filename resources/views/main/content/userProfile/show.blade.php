@extends('main.body.master')

@section('title', $user->username . "'s Profile")

@section('style')
    <style>
        /* Professional Grid Layout */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .grid-item {
            aspect-ratio: 1 / 1;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border-radius: 8px;
        }

        .grid-item img,
        .grid-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
        }

        .grid-item:hover .grid-overlay {
            opacity: 1;
        }

        .grid-item:hover img {
            transform: scale(1.05);
        }

        /* Tab Styling */
        .nav-tabs-custom .nav-link {
            border: none;
            color: #67748e;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--bs-primary);
            background: none;
            border-bottom: 3px solid var(--bs-primary);
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        #postDetailModal {
            z-index: 1050 !important;
        }

        /* Make sure the grid images are clickable pointers */
        .grid-item {
            cursor: pointer;
            z-index: 1;
        }

        /* Slider Container inside Modal */
        .insta-slider {
            position: relative;
            width: 100%;
            overflow: hidden;
            background: #000;
            border-radius: 8px;
        }

        .insta-track {
            display: flex;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }

        .insta-slide {
            min-width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .insta-slide img,
        .insta-slide video {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }

        /* Instagram-Style Arrow Buttons */
        .insta-slider .prev,
        .insta-slider .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            background: rgb(87 87 87 / 80%);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: opacity 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .insta-slider .prev {
            left: 10px;
        }

        .insta-slider .next {
            right: 10px;
        }

        .insta-slider .prev:hover,
        .insta-slider .next:hover {
            background: rgba(255, 255, 255, 1);
        }

        /* Arrow Icons (Using Bootstrap Icons) */
        /* .insta-slider .prev::after { content: '\F284'; font-family: "bootstrap-icons"; font-weight: bold; color: #000; font-size: 14px; } */
        /* .insta-slider .next::after { content: '\F285'; font-family: "bootstrap-icons"; font-weight: bold; color: #000; font-size: 14px; } */

        /* Hide arrows if only one slide exists */
        .insta-slider[data-slides="1"] .prev,
        .insta-slider[data-slides="1"] .next {
            display: none;
        }
    </style>
@endsection

@section('main')
    <div class="container">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-sm-flex align-items-center">
                    <div class="avatar avatar-xxl">
                        <img class="avatar-img rounded-circle border border-3 border-primary"
                            src="{{ $user->image ? asset('assets/images/users/' . $user->image) : asset('assets/images/avatar/07.jpg') }}">
                    </div>
                    <div class="ms-sm-4 mt-3 mt-sm-0">
                        <h1 class="h4 mb-1">{{ $user->first_name }} {{ $user->last_name }} <i
                                class="bi bi-patch-check-fill text-info"></i></h1>
                        <ul class="list-inline mb-2 small fw-bold">
                            <li class="list-inline-item">@ {{ $user->username }}</li>
                        </ul>
                        <div class="d-flex gap-2">
                            @php $isFollowing = auth()->user()->isFollowing($user->id); @endphp
                            <button class="btn btn-sm {{ $isFollowing ? 'btn-secondary' : 'btn-primary' }} px-4"
                                onclick="toggleFollow({{ $user->id }}, this)">
                                {{ $isFollowing ? 'Following' : 'Follow' }}
                            </button>
                            <a href="{{ route('home.chat') }}" class="btn btn-sm btn-outline-primary px-3"><i
                                    class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                    <div class="ms-sm-auto d-flex gap-4 text-center mt-3 mt-sm-0">
                        <div>
                            <h6 class="mb-0">{{ $posts->count() }}</h6><small>Posts</small>
                        </div>
                        <div>
                            <h6 class="mb-0" id="follower-count">{{ $user->followers()->count() }}</h6>
                            <small>Followers</small>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $user->following()->count() }}</h6><small>Following</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer p-0 bg-transparent border-top">
                <ul class="nav nav-tabs-custom justify-content-center" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-posts">POSTS</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-about">ABOUT</a></li>
                </ul>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-posts">
                <div class="profile-grid">
                    @forelse ($posts as $post)
                        <div class="grid-item" onclick="openPostModal({{ $post->id }})">
                            @php $media = $post->media->first(); @endphp
                            @if ($media && $media->type == 'video')
                                <video src="{{ asset($media->file_path) }}"></video>
                            @else
                                <img
                                    src="{{ $media ? asset($media->file_path) : asset('assets/images/post/placeholder.jpg') }}">
                            @endif
                            <div class="grid-overlay">
                                <span class="me-3"><i class="bi bi-heart-fill"></i> {{ $post->likes->count() }}</span>
                                <span><i class="bi bi-chat-fill"></i> {{ $post->comments->count() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-camera h1 text-muted"></i>
                            <p class="text-muted">No posts yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="tab-about">

                <div class="card">
                    <!-- Card header START -->
                    <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Profile Info</h5>
                    </div>
                    <!-- Card header END -->
                    <!-- Card body START -->
                    <div class="card-body">
                            <div class="rounded border px-3 py-2 mb-3">
                                <h6 class="mb-2">Overview</h6>
                                <p class="mb-0" id="aboutDescriptionText">
                                    {{ $user->description ?: 'No bio added yet. Tell people a bit about yourself.' }}
                                </p>
                                <textarea class="form-control d-none mt-2" id="aboutDescriptionInput" name="description" rows="3"
                                    placeholder="Tell people a bit about yourself...">{{ $user->description }}</textarea>
                            </div>

                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <!-- Birthday START -->
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-calendar-date fa-fw me-2"></i>
                                                Born:
                                                <strong id="aboutDobText">
                                                    {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F d, Y') : 'Not specified' }}
                                                </strong>
                                            </p>
                                            <input type="date" class="form-control d-none" id="aboutDobInput"
                                                name="date_of_birth" value="{{ $user->date_of_birth }}">
                                        </div>
                                    </div>
                                    <!-- Birthday END -->
                                </div>

                                <div class="col-sm-6">
                                    <!-- Phone START -->
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-telephone fa-fw me-2"></i>
                                                Phone:
                                                <strong
                                                    id="aboutPhoneText">{{ $user->phone_number ?: 'Not provided' }}</strong>
                                            </p>
                                            <input type="text" class="form-control d-none" id="aboutPhoneInput"
                                                name="phone_number" value="{{ $user->phone_number }}">
                                        </div>
                                    </div>
                                    <!-- Phone END -->
                                </div>

                                <div class="col-sm-6">
                                    <!-- First name START -->
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-person fa-fw me-2"></i>
                                                First name:
                                                <strong id="aboutFirstNameText">{{ $user->first_name }}</strong>
                                            </p>
                                            <input type="text" class="form-control d-none" id="aboutFirstNameInput"
                                                name="first_name" placeholder="First name"
                                                value="{{ $user->first_name }}">
                                        </div>
                                    </div>
                                    <!-- First name END -->
                                </div>

                                <div class="col-sm-6">
                                    <!-- Last name START -->
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-person fa-fw me-2"></i>
                                                Last name:
                                                <strong id="aboutLastNameText">{{ $user->last_name }}</strong>
                                            </p>
                                            <input type="text" class="form-control d-none" id="aboutLastNameInput"
                                                name="last_name" placeholder="Last name" value="{{ $user->last_name }}">
                                        </div>
                                    </div>
                                    <!-- Last name END -->
                                </div>

                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-briefcase fa-fw me-2"></i>
                                                Role:
                                                <strong id="aboutRoleText">{{ $user->role ?: 'Not specified' }}</strong>
                                            </p>
                                            <input type="text" class="form-control d-none" id="aboutRoleInput"
                                                name="role" value="{{ $user->role }}" placeholder="Your role">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-heart fa-fw me-2"></i>
                                                Status:
                                                <strong id="aboutStatusText">
                                                    {{ $user->status ? ucfirst($user->status) : 'Not specified' }}
                                                </strong>
                                            </p>

                                            <select class="form-control d-none" id="aboutStatusInput" name="status">
                                                <option value="">Select status</option>
                                                <option value="single" {{ $user->status == 'single' ? 'selected' : '' }}>
                                                    Single</option>
                                                <option value="married"
                                                    {{ $user->status == 'married' ? 'selected' : '' }}>Married</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- Email START -->
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-envelope fa-fw me-2"></i>
                                                Email:
                                                <strong id="aboutEmailText">{{ $user->email }}</strong>
                                            </p>
                                            <input type="email" class="form-control d-none" id="aboutEmailInput"
                                                name="email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <!-- Email END -->
                                </div>

                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <div class="w-100">
                                            <p class="mb-1">
                                                <i class="bi bi-geo-alt fa-fw me-2"></i>
                                                Address:
                                                <strong
                                                    id="aboutAddressText">{{ $user->address ?: 'Not specified' }}</strong>
                                            </p>

                                            <textarea class="form-control d-none" id="aboutAddressInput" name="address" rows="2"
                                                placeholder="Your address">{{ $user->address }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <!-- Joined on START -->
                                    <div class="d-flex align-items-center rounded border px-3 py-2">
                                        <p class="mb-0">
                                            <i class="bi bi-clock-history fa-fw me-2"></i>
                                            Joined on:
                                            <strong>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'Not available' }}</strong>
                                        </p>
                                    </div>
                                    <!-- Joined on END -->
                                </div>
                            </div>
                    </div>
                    <!-- Card body END -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="postDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" id="modalBodyContent">
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            // Set up CSRF for AJAX (Good practice for Laravel)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function openPostModal(postId) {
            var modalEl = document.getElementById('postDetailModal');
            var $modalBody = $('#modalBodyContent');
            var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);

            // Initial loading state
            $modalBody.html(
                '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>');
            modalInstance.show();

            // Fetch JSON from your preview route
            $.get('/posts/' + postId + '/preview', function(response) {
                // Inject the HTML from your controller
                $modalBody.html(response.html);

                // RE-INITIALIZE SLIDER: This makes the arrows work on the new content
                initSliders();

            }).fail(function() {
                $modalBody.html('<div class="alert alert-danger m-3">Error loading post details.</div>');
            });
        }

        function initSliders() {
            document.querySelectorAll('.insta-slider').forEach(slider => {
                // This 'dataset.initialized' check you have is perfect! 
                // It prevents double-binding events.
                if (slider.dataset.initialized) return;
                slider.dataset.initialized = true;

                const track = slider.querySelector('.insta-track');
                const slides = slider.querySelectorAll('.insta-slide');
                const prev = slider.querySelector('.prev');
                const next = slider.querySelector('.next');

                if (!track || slides.length <= 1) return; // Don't slide if only 1 image

                let index = 0;
                const update = () => {
                    track.style.transform = `translateX(-${index * 100}%)`;
                };

                next?.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent modal from glitching
                    index = (index + 1) % slides.length;
                    update();
                });

                prev?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    index = (index - 1 + slides.length) % slides.length;
                    update();
                });

                // ... rest of your touch support code ...
            });
        }

        // Run on page load for the grid/feed
        $(document).ready(function() {
            initSliders();
        });

        /**
         * Toggle Follow using Fetch API
         */
        function toggleFollow(userId, btn) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const followerCountEl = document.getElementById('follower-count');

            fetch(`/follow/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update Button Style
                    if (data.following) {
                        btn.innerText = 'Following';
                        btn.classList.replace('btn-primary', 'btn-secondary');
                    } else {
                        btn.innerText = 'Follow';
                        btn.classList.replace('btn-secondary', 'btn-primary');
                    }

                    // Update the count number dynamically
                    if (data.follower_count !== undefined) {
                        followerCountEl.innerText = data.follower_count;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
