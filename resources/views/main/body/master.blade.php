<!DOCTYPE html>
<html lang="en">

<head>
    <title>Social - Network, Community and Event Template</title>

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

    <script>
        window.__authUserId = {{ auth()->check() ? auth()->id() : 'null' }};
        window.__savePostUrlTemplate = "{{ route('posts.save', ['post' => '__POST_ID__']) }}";

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

        window.updateFollowButton = function(element, following) {
            if (!element) return;
            const icon = element.querySelector('i');

            if (element.classList.contains('text-primary') || element.classList.contains('text-secondary')) {
                element.classList.toggle('text-primary', !following);
                element.classList.toggle('text-secondary', following);
            }

            if (element.classList.contains('btn-primary') || element.classList.contains('btn-secondary')) {
                element.classList.toggle('btn-primary', !following);
                element.classList.toggle('btn-secondary', following);
            }

            if (icon) {
                if (icon.classList.contains('bi-plus-circle-fill') || icon.classList.contains('bi-check-circle-fill')) {
                    icon.classList.toggle('bi-plus-circle-fill', !following);
                    icon.classList.toggle('bi-check-circle-fill', following);
                }
                if (icon.classList.contains('bi-person-plus') || icon.classList.contains('bi-person-check-fill')) {
                    icon.classList.toggle('bi-person-plus', !following);
                    icon.classList.toggle('bi-person-check-fill', following);
                }
            }
        };

        window.updateSavedCount = function(count) {
            document.querySelectorAll('[data-saved-count]').forEach(el => {
                el.textContent = count;
            });
        };

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
    </script>

    @yield('script')

</body>


<!-- Mirrored from stackbros.in/social/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Dec 2025 14:43:03 GMT -->

</html>
