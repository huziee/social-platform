<!DOCTYPE html>
<html lang="en">

<head>
    <title>Social - Network, Community and Blog Template</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="StackBros">
    <meta name="description" content="Bootstrap 5 based Social Media Network and Community Theme">

    <meta name="csrf-token" content="{{ csrf_token() }}">

	<script src="{{ asset('assets/js/customtheme.js') }}"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/OverlayScrollbars-master/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/tiny-slider/dist/tiny-slider.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/glightbox-master/dist/css/glightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/dropzone/dist/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/flatpickr/dist/flatpickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/plyr/plyr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/zuck.js/dist/zuck.min.css') }}">
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    @yield('style')


</head>


<body>

    <!-- =======================
Header START -->
    @include('main.body.header')
    <!-- =======================
Header END -->

    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- Container START -->
        <div class="container">
            @yield('main')
        </div>
        <!-- Container END -->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->

    <div id="appNotice" class="app-flash" role="alert" aria-live="polite" aria-atomic="true"></div>
    @if (session('toast'))
        <div class="app-flash app-flash-static alert alert-{{ session('toast.type', 'info') }} alert-dismissible fade show" role="alert">
            <div class="app-flash-inner">
                <div class="app-flash-icon">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div class="app-flash-body">
                    <div class="app-flash-title">{{ session('toast.title', 'Update') }}</div>
                    <div class="app-flash-msg">{{ session('toast.message') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- JS libraries, plugins and custom scripts -->

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Vendors -->
    <script src="{{ asset('assets/vendor/tiny-slider/dist/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/vendor/OverlayScrollbars-master/js/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox-master/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/plyr/plyr.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/zuck.js/dist/zuck.min.js') }}"></script>
    <script src="{{ asset('assets/js/zuck-stories.js') }}"></script>

    <!-- Theme Functions -->
    <script src="{{ asset('assets/js/functions.js') }}"></script>

    <style>
        .app-flash {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1080;
            width: min(560px, 92vw);
            padding: 0;
            border: 0;
            background: transparent;
            box-shadow: none;
        }
        .app-flash-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(15,23,42,0.96), rgba(30,41,59,0.96));
            color: #e2e8f0;
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.35);
        }
        .app-flash-title {
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.2px;
        }
        .app-flash-msg {
            font-size: 12px;
            color: #cbd5f5;
        }
        .app-flash-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, 0.08);
            color: #38bdf8;
        }
        .app-flash.alert-success .app-flash-icon { color: #22c55e; }
        .app-flash.alert-warning .app-flash-icon { color: #f59e0b; }
        .app-flash.alert-danger .app-flash-icon { color: #ef4444; }
        .app-flash .btn-close {
            filter: invert(1);
            opacity: 0.7;
        }
        .app-flash .btn-close:hover { opacity: 1; }
    </style>

    <script>
        window.__authUserId = {{ auth()->check() ? auth()->id() : 'null' }};
        window.__authUsername = {!! auth()->check() ? json_encode(auth()->user()->username) : 'null' !!};
        window.__savePostUrlTemplate = "{{ route('posts.save', ['post' => '__POST_ID__']) }}";
        window.__userSearchUrl = "{{ route('users.search') }}";

        window.updateFollowCounts = function(payload) {
            if (!payload) return;
            const targetId = payload.target_id;
            const authId = payload.auth_id || window.__authUserId;

            if (targetId && typeof payload.target_followers_count !== 'undefined') {
                document.querySelectorAll(`[data-followers-count][data-user-id="${targetId}"]`)
                    .forEach(el => el.textContent = payload.target_followers_count);
            }

            if (authId && typeof payload.auth_followers_count !== 'undefined') {
                document.querySelectorAll(`[data-followers-count][data-user-id="${authId}"]`)
                    .forEach(el => el.textContent = payload.auth_followers_count);
            }

            if (authId && typeof payload.auth_following_count !== 'undefined') {
                document.querySelectorAll(`[data-following-count][data-user-id="${authId}"]`)
                    .forEach(el => el.textContent = payload.auth_following_count);
            }
        };

        window.updateFollowButton = function(element, following, requested = false) {
            if (!element) return;
            const icon = element.querySelector('i');
            const isRequested = !!requested;
            const activeState = !!following || isRequested;

            if (element.classList.contains('text-primary') || element.classList.contains('text-secondary')) {
                element.classList.toggle('text-primary', !activeState);
                element.classList.toggle('text-secondary', activeState);
            }

            if (element.classList.contains('btn-primary') || element.classList.contains('btn-secondary')) {
                element.classList.toggle('btn-primary', !activeState);
                element.classList.toggle('btn-secondary', activeState);
            }

            if (icon) {
                if (icon.classList.contains('bi-plus-circle-fill') || icon.classList.contains('bi-check-circle-fill') || icon.classList.contains('bi-hourglass-split')) {
                    icon.classList.toggle('bi-plus-circle-fill', !activeState);
                    icon.classList.toggle('bi-check-circle-fill', activeState && !isRequested);
                    icon.classList.toggle('bi-hourglass-split', isRequested);
                }
                if (icon.classList.contains('bi-person-plus') || icon.classList.contains('bi-person-check-fill') || icon.classList.contains('bi-hourglass-split')) {
                    icon.classList.toggle('bi-person-plus', !activeState);
                    icon.classList.toggle('bi-person-check-fill', activeState && !isRequested);
                    icon.classList.toggle('bi-hourglass-split', isRequested);
                }
            }

            if (!icon) {
                element.textContent = isRequested ? 'Requested' : (following ? 'Following' : 'Follow');
            }
        };

        window.updateSavedCount = function(count) {
            document.querySelectorAll('[data-saved-count]').forEach(el => {
                el.textContent = count;
            });
        };

        (function() {
            const input = document.getElementById('headerSearchInput');
            const results = document.getElementById('headerSearchResults');
            const form = document.getElementById('headerSearchForm');
            if (!input || !results || !form) return;

            let timer;

            function hideResults() {
                results.style.display = 'none';
                results.innerHTML = '';
            }

            function showResults(html) {
                results.innerHTML = html;
                results.style.display = 'block';
            }

            function renderUsers(users) {
                if (!users.length) {
                    showResults('<div class="header-search-empty">No results found.</div>');
                    return;
                }
                const html = users.map(u => `
                    <a class="header-search-item" href="${u.profile_url}">
                        <img class="header-search-avatar" src="${u.image}" alt="">
                        <div>
                            <div class="header-search-name">${u.name || u.username}</div>
                            <div class="header-search-username">@${u.username}</div>
                        </div>
                    </a>
                `).join('');
                showResults(html);
            }

            function fetchUsers(query) {
                fetch(`${window.__userSearchUrl}?q=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        renderUsers(data.users || []);
                    })
                    .catch(() => hideResults());
            }

            input.addEventListener('input', () => {
                const query = input.value.trim();
                clearTimeout(timer);
                if (query.length < 2) {
                    hideResults();
                    return;
                }
                timer = setTimeout(() => fetchUsers(query), 300);
            });

            form.addEventListener('submit', (e) => {
                e.preventDefault();
            });

            document.addEventListener('click', (e) => {
                if (!form.contains(e.target)) hideResults();
            });
        })();

        window.toggleSavePost = function(postId, element) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) return;

            const saveUrl = window.__savePostUrlTemplate.replace('__POST_ID__', postId);
            fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') return;

                    if (typeof data.saved_count !== 'undefined') {
                        window.updateSavedCount(data.saved_count);
                    }

                    if (!element) return;
                    const icon = element.querySelector('i');
                    const text = element.querySelector('.js-save-text');
                    const isSaved = !!data.saved;

                    if (icon) {
                        icon.classList.toggle('bi-bookmark', !isSaved);
                        icon.classList.toggle('bi-bookmark-check-fill', isSaved);
                    }

                    if (text) {
                        text.textContent = isSaved ? 'Unsave post' : 'Save post';
                    }
                })
                .catch(() => {
                    // Silent fail
                });
        };

        document.addEventListener('DOMContentLoaded', () => {
            const flash = document.querySelector('.app-flash-static.alert');
            if (flash) {
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(flash);
                    alert.close();
                }, 3500);
            }
        });

        let __toastTimer;
        window.showAppToast = function(type, title, message) {
            const container = document.getElementById('appNotice');
            if (!container) return;
            if (__toastTimer) {
                clearTimeout(__toastTimer);
                __toastTimer = null;
            }
            const iconMap = {
                success: 'bi-check-circle-fill',
                warning: 'bi-exclamation-triangle-fill',
                danger: 'bi-x-circle-fill',
                info: 'bi-info-circle-fill'
            };
            const iconClass = iconMap[type] || iconMap.info;
            container.classList.remove('show');
            container.innerHTML = '';
            container.className = `app-flash alert alert-${type || 'info'} alert-dismissible fade show`;
            container.innerHTML = `
                <div class="app-flash-inner">
                    <div class="app-flash-icon"><i class="bi ${iconClass}"></i></div>
                    <div class="app-flash-body">
                        <div class="app-flash-title">${title || 'Update'}</div>
                        <div class="app-flash-msg">${message || ''}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            __toastTimer = setTimeout(() => {
                if (window.bootstrap && bootstrap.Alert) {
                    const alert = bootstrap.Alert.getOrCreateInstance(container);
                    alert.close();
                } else {
                    container.className = 'app-flash';
                    container.innerHTML = '';
                }
                __toastTimer = null;
            }, 3500);
        };

        window.showToastFromResponse = function(data) {
            if (window.showAppToast && data && data.toast) {
                window.showAppToast(data.toast.type, data.toast.title, data.toast.message);
            }
        };
    </script>

    @yield('script')

</body>


<!-- Mirrored from stackbros.in/social/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Dec 2025 14:43:03 GMT -->

</html>
