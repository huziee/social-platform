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
            margin: 15px 20px;
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
                            <h1 class="mb-0 h5">{{ Auth::user()->first_name }}  {{ Auth::user()->last_name }} 
                                 @if(Auth::user()->is_subscribed)
        <span class="ms-1 text-primary" title="Verified Member">
            <i class="bi bi-patch-check-fill text-success small"></i>
        </span>
    @endif
                            </h1>
                            
                            <p>{{ Auth::user()->username }}</p>
                        </div>
                        <!-- Button -->
                        <div class="d-flex mt-3 justify-content-center ms-sm-auto">
                            <button class="btn btn-sm btn-danger-soft me-2" type="button"> <i
                                                class="bi bi-file-earmark-pdf"></i></button>
                            <button class="btn btn-sm btn-primary-soft me-2" type="button"> <i
                                                class="bi bi-send-fill"></i></button>
                            {{-- <button class="btn btn-sm btn-success-soft me-2" type="button"> <i
                                                class="bi bi-lock fa-fw"></i></button> --}}
                        </div>
                    </div>
                    <!-- List profile -->
                    <ul class="list-inline mb-0 text-center text-sm-start mt-3 mt-sm-0">
                        <li class="list-inline-item"><i class="bi bi-card-text me-1 fs-6 me-2"></i>{{ Auth::user()->description }}</li>
                </div>
                <!-- Card body END -->
                <div class="card-footer mt-2 pt-2 pb-0">
                    <ul class="nav nav-bottom-line justify-content-center justify-content-md-start border-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#posts">Posts <span class="badge bg-success bg-opacity-10 text-success small">{{ Auth::user()->posts()->count() }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#connections">Followers <span class="badge bg-success bg-opacity-10 text-success small" data-followers-count data-user-id="{{ Auth::id() }}">{{ Auth::user()->followers()->count() }}</span> </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#saved">Saved <span class="badge bg-success bg-opacity-10 text-success small" data-saved-count>{{ isset($savedPosts) ? $savedPosts->count() : 0 }}</span></a>
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

            <div id="saved" class="profile-section d-none">
                @include('main.content.myProfile.partials.saved')
            </div>



        </div>
        <!-- Main content END -->

        <!-- Right sidebar START -->
        <div class="col-lg-4">

            @php
                $user = Auth::user();
                $followersList = isset($followers) ? $followers : collect();
                $photoMedia = isset($posts)
                    ? $posts->pluck('media')->flatten()->where('type', 'image')->take(5)
                    : collect();
                $friendsPreview = $followersList->take(4);
            @endphp

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
                            <p>{{ $user->description ?: 'No bio added yet. Tell people a bit about yourself.' }}</p>
                            <!-- Date time -->
                            <ul class="list-unstyled mt-3 mb-0">
                                <li class="mb-2"> <i class="bi bi-calendar-date fa-fw pe-1"></i> Born:
                                    <strong>
                                        {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F d, Y') : 'Not specified' }}
                                    </strong>
                                </li>
                                <li class="mb-2"> <i class="bi bi-heart fa-fw pe-1"></i> Status:
                                    <strong>{{ $user->status ? ucfirst($user->status) : 'Not specified' }}</strong>
                                </li>
                                <li> <i class="bi bi-envelope fa-fw pe-1"></i> Email:
                                    <strong>{{ $user->email }}</strong>
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
                            <div class="text-muted small">
                                No experience added yet.
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
                        <div class="card-header d-sm-flex justify-content-between border-0">
                            <h5 class="card-title">Photos</h5>
                            <a class="btn btn-primary-soft btn-sm" href="#!"> See all photo</a>
                        </div>
                        <!-- Card header END -->
                        <!-- Card body START -->
                        <div class="card-body position-relative pt-0">
                            <div class="row g-2">
                                @forelse ($photoMedia as $media)
                                    <div class="{{ $loop->index < 2 ? 'col-6' : 'col-4' }}">
                                        <a href="{{ asset($media->file_path) }}" data-gallery="image-popup" data-glightbox="">
                                            <img class="rounded img-fluid" src="{{ asset($media->file_path) }}" alt="Post photo">
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">
                                        No photos yet.
                                    </div>
                                @endforelse
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
                                    class="badge bg-danger bg-opacity-10 text-danger">{{ $followersList->count() }}</span></h5>
                            <a class="btn btn-primary-soft btn-sm" href="#!"> See all friends</a>
                        </div>
                        <!-- Card header END -->
                        <!-- Card body START -->
                        <div class="card-body position-relative pt-0">
                            <div class="row g-3">

                                @forelse ($friendsPreview as $friend)
                                    <div class="col-6">
                                        <!-- Friends item START -->
                                        <div class="card shadow-none text-center h-100">
                                            <!-- Card body -->
                                            <div class="card-body p-2 pb-0">
                                                <div class="avatar avatar-story avatar-xl">
                                                    <a href="{{ route('user.profile', $friend->username) }}">
                                                        <img class="avatar-img rounded-circle"
                                                            src="{{ $friend->image ? asset('assets/images/users/' . $friend->image) : asset('assets/images/avatar/placeholder.jpg') }}"
                                                            alt="">
                                                    </a>
                                                </div>
                                                <h6 class="card-title mb-1 mt-3">
                                                    <a href="{{ route('user.profile', $friend->username) }}">
                                                        {{ $friend->first_name }} {{ $friend->last_name }}
                                                    </a>
                                                </h6>
                                                <p class="mb-0 small lh-sm"><span data-followers-count data-user-id="{{ $friend->id }}">{{ $friend->followers()->count() }}</span> followers</p>
                                            </div>
                                            <!-- Card footer -->
                                            <div class="card-footer p-2 border-0">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Send message"> <i
                                                        class="bi bi-chat-left-text"></i> </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Remove friend"
                                                    onclick="toggleFollow({{ $friend->id }}, this)"> <i
                                                        class="bi bi-person-x"></i> </button>
                                            </div>
                                        </div>
                                        <!-- Friends item END -->
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">
                                        No friends yet.
                                    </div>
                                @endforelse

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

    @include('main.modals.homeModals.postEditModal')

@endsection
@section('script')

    <script>
        let tempDeletedImages = [];
        let tempDeletedVideos = [];
        let tempReplacedImages = {};
        let tempReplacedVideos = {};

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

        window.editPost = function(postId) {
            tempDeletedImages = [];
            tempDeletedVideos = [];
            tempReplacedImages = {};
            tempReplacedVideos = {};

            fetch(`/posts/${postId}/edit`)
                .then(res => res.json())
                .then(data => {
                    const post = data.post;

                    const postIdInput = document.getElementById('edit_post_id');
                    const captionInput = document.getElementById('edit_caption');
                    const imageSection = document.getElementById('editImageSection');
                    const videoSection = document.getElementById('editVideoSection');
                    const imageContainer = document.getElementById('editPostImage');
                    const videoContainer = document.getElementById('editPostVideo');

                    if (!postIdInput || !captionInput || !imageSection || !videoSection || !imageContainer ||
                        !videoContainer) {
                        return;
                    }

                    postIdInput.value = post.id;
                    captionInput.value = post.caption || '';

                    imageSection.classList.add('d-none');
                    videoSection.classList.add('d-none');
                    imageContainer.innerHTML = '';
                    videoContainer.innerHTML = '';

                    if (post.images && post.images.length > 0) {
                        imageSection.classList.remove('d-none');
                        post.images.forEach(image => {
                            imageContainer.innerHTML += `
                        <div class="col-4" id="image-${image.id}">
                            <div class="card position-relative">
                                <img src="/${image.file_path}" class="img-fluid rounded">
                                <button type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                    onclick="deleteImage(event, ${image.id})">x</button>

                                <button type="button"
                                    class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-1"
                                    onclick="triggerFile(${image.id})">edit</button>

                                <input type="file"
                                    class="d-none"
                                    id="file-${image.id}"
                                    onchange="replaceImage(${image.id}, this)">
                            </div>
                        </div>`;
                        });
                    }

                    if (post.videos && post.videos.length > 0) {
                        videoSection.classList.remove('d-none');
                        post.videos.forEach(video => {
                            videoContainer.innerHTML += `
                        <div class="col-6" id="video-${video.id}">
                            <div class="card position-relative">
                                <video controls class="w-100 rounded">
                                    <source src="/${video.file_path}" type="video/mp4">
                                </video>
                                <button type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                    onclick="deleteVideo(event, ${video.id})">x</button>
                                <button type="button"
                                    class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-1"
                                    onclick="triggerVideoFile(${video.id})">edit</button>
                                <input type="file"
                                    accept="video/*"
                                    class="d-none"
                                    id="video-file-${video.id}"
                                    onchange="replaceVideo(${video.id}, this)">
                            </div>
                        </div>`;
                        });
                    }

                    const modal = document.getElementById('modalEditPost');
                    if (modal) {
                        new bootstrap.Modal(modal).show();
                    }
                })
                .catch(err => console.error(err));
        };

        window.deletePost = function(postId) {
            if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) return;

            fetch(`/posts/${postId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const postEl = document.getElementById(`post-${postId}`);
                        if (postEl) {
                            postEl.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                            postEl.style.opacity = '0';
                            postEl.style.transform = 'scale(0.95)';
                            setTimeout(() => postEl.remove(), 400);
                        }
                    } else {
                        alert(data.message || 'Something went wrong.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Server error. Could not delete post.');
                });
        };

        window.updatePost = function() {
            const postId = document.getElementById('edit_post_id')?.value;
            const caption = document.getElementById('edit_caption')?.value || '';
            if (!postId) return;

            const formData = new FormData();
            formData.append('caption', caption);

            tempDeletedImages.forEach(id => formData.append('deleted_images[]', id));
            tempDeletedVideos.forEach(id => formData.append('deleted_videos[]', id));

            for (const id in tempReplacedImages) {
                formData.append(`replaced_images[${id}]`, tempReplacedImages[id]);
            }
            for (const id in tempReplacedVideos) {
                formData.append(`replaced_videos[${id}]`, tempReplacedVideos[id]);
            }

            fetch(`/posts/${postId}/update-modal`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) return;

                    const postCard = document.querySelector(`#post-${postId}`);
                    if (!postCard) return;

                    const captionEl = postCard.querySelector('.post-caption');
                    if (captionEl) captionEl.innerText = caption;

                    const mediaContainer = postCard.querySelector(`#post-media-${postId}`);
                    if (!mediaContainer) return;

                    const media = [
                        ...(data.images || []).map(i => ({
                            type: 'image',
                            url: i.url
                        })),
                        ...(data.videos || []).map(v => ({
                            type: 'video',
                            url: v.url
                        }))
                    ];

                    let newHtml = '';
                    if (media.length > 1) {
                        newHtml = `<div class="insta-slider">
                            <div class="insta-track">
                                ${media.map(item => `
                                    <div class="insta-slide">
                                        ${item.type === 'image'
                                            ? `<img src="${item.url}" class="w-100 rounded">`
                                            : `<video controls class="w-100 rounded"><source src="${item.url}"></video>`}
                                    </div>`).join('')}
                            </div>
                            <button class="insta-btn prev">&lt;</button>
                            <button class="insta-btn next">&gt;</button>
                        </div>`;
                    } else if (media.length === 1) {
                        const item = media[0];
                        newHtml = item.type === 'image' ?
                            `<img src="${item.url}" class="img-fluid rounded w-100">` :
                            `<video controls class="w-100 rounded"><source src="${item.url}"></video>`;
                    } else {
                        newHtml = `<div class="text-muted text-center py-4">No media available</div>`;
                    }

                    mediaContainer.innerHTML = newHtml;
                    if (media.length > 1) {
                        const newSlider = mediaContainer.querySelector('.insta-slider');
                        if (newSlider) {
                            delete newSlider.dataset.initialized;
                            initSliders();
                        }
                    }

                    bootstrap.Modal.getInstance(document.getElementById('modalEditPost'))?.hide();
                })
                .catch(err => console.error('Update failed:', err));
        };

        window.deleteImage = function(e, imageId) {
            e.preventDefault();
            tempDeletedImages.push(imageId);
            document.getElementById(`image-${imageId}`)?.remove();
        };

        window.triggerFile = function(imageId) {
            document.getElementById(`file-${imageId}`)?.click();
        };

        window.replaceImage = function(imageId, input) {
            if (!input.files.length) return;
            tempReplacedImages[imageId] = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector(`#image-${imageId} img`);
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        };

        window.deleteVideo = function(e, videoId) {
            e.preventDefault();
            tempDeletedVideos.push(videoId);
            document.getElementById(`video-${videoId}`)?.remove();
        };

        window.triggerVideoFile = function(videoId) {
            document.getElementById(`video-file-${videoId}`)?.click();
        };

        window.replaceVideo = function(videoId, input) {
            if (!input.files.length) return;
            const file = input.files[0];
            tempReplacedVideos[videoId] = file;

            const videoURL = URL.createObjectURL(file);
            const source = document.querySelector(`#video-${videoId} video source`);
            const video = document.querySelector(`#video-${videoId} video`);
            if (source && video) {
                source.setAttribute('src', videoURL);
                video.load();
            }
        };

        window.toggleFollow = function(userId, btn) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch(`/follow/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') return;

                    if (window.updateFollowButton) {
                        window.updateFollowButton(btn, data.following);
                    }
                    if (window.updateFollowCounts) {
                        window.updateFollowCounts(data);
                    }

                    if (btn && btn.classList.contains('btn-danger-soft') && !data.following) {
                        const row = btn.closest('.d-md-flex');
                        if (row) {
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                    }
                })
                .catch(err => console.error('Follow toggle failed:', err));
        };

        let postModal;
let commentsModal;

window.openPostModal = function(postId) {
    const modalEl = document.getElementById('postModal');
    const body = document.getElementById('postModalBody');

    if (!modalEl) return;

    if (!postModal) {
        postModal = new bootstrap.Modal(modalEl);
    }

    if (body) {
        body.innerHTML = '<div class="p-4 text-center">Loading post...</div>';
    }

    postModal.show();

    fetch(`/posts/${postId}/preview`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        })
        .then(data => {
            if (!body) return;

            body.innerHTML = data.html || '<div class="p-4 text-center">Post preview not available.</div>';

            if (typeof initSliders === 'function') {
                initSliders();
            }

            const commentsEl = document.getElementById('commentsModal');
            if (commentsEl) {
                commentsModal = new bootstrap.Modal(commentsEl);
            }
        })
        .catch(err => {
            if (body) {
                body.innerHTML = '<div class="alert alert-danger m-3">Error loading post details.</div>';
            }
            console.error('Post preview failed:', err);
        });
}
    </script>
@endsection
