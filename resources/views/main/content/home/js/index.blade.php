<script>
    Dropzone.autoDiscover = false;

    let tempDeletedImages = [];
    let tempReplacedImages = {};
    let tempReplacedVideos = {};

    document.addEventListener("DOMContentLoaded", function() {
        initSliders();

        const myDropzone = new Dropzone("#postDropzone", {
            url: "{{ route('post.store') }}",
            paramName: "images[]",
            uploadMultiple: true,
            maxFiles: 10,
            acceptedFiles: "image/*",
            autoProcessQueue: false,
            addRemoveLinks: true,
        });

        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('caption', document.querySelector('[name="caption"]').value);

            myDropzone.files.forEach(file => {
                formData.append('images[]', file);
            });

            fetch("{{ route('post.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) return;

                    const feed = document.getElementById('postsFeed');
                    if (!feed) return;

                    feed.insertAdjacentHTML('afterbegin', data.html);

                    initSliders();

                    document.getElementById('postForm')?.reset();
                    myDropzone.removeAllFiles();

                    const modalEl = document.getElementById('feedActionPhoto');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(
                            modalEl);
                        modal.hide();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong.');
                });
        });

        // function toggleFollow(userId, btn) {
        //     const icon = btn.querySelector('i');
        //     const text = btn.querySelector('span');

        //     fetch(`/follow/${userId}`, {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //                 'Accept': 'application/json'
        //             }
        //         })
        //         .then(res => res.json())
        //         .then(data => {
        //             if (data.following) {
        //                 btn.classList.remove('btn-primary');
        //                 btn.classList.add('btn-secondary');

        //                 icon.classList.remove('bi-person-plus');
        //                 icon.classList.add('bi-person-check');

        //                 text.innerText = 'Following';
        //             } else {
        //                 btn.classList.remove('btn-secondary');
        //                 btn.classList.add('btn-primary');

        //                 icon.classList.remove('bi-person-check');
        //                 icon.classList.add('bi-person-plus');

        //                 text.innerText = 'Follow';
        //             }
        //         })
        //         .catch(() => {
        //             alert('Something went wrong. Try again.');
        //         });
        // }


        window.editPost = function(postId) {
            console.log(postId);

            tempDeletedImages = [];
            tempDeletedVideos = [];
            tempReplacedImages = {};

            fetch(`/posts/${postId}/edit`)
                .then(res => res.json())
                .then(data => {
                    console.log(data)

                    const post = data.post;

                    document.getElementById('edit_post_id').value = post.id;
                    document.getElementById('edit_caption').value = post.caption;

                    const imageSection = document.getElementById('editImageSection');
                    const videoSection = document.getElementById('editVideoSection');

                    const imageContainer = document.getElementById('editPostImage');
                    const videoContainer = document.getElementById('editPostVideo');

                    // 🔥 RESET EVERYTHING FIRST
                    imageSection.classList.add('d-none');
                    videoSection.classList.add('d-none');

                    imageContainer.innerHTML = '';
                    videoContainer.innerHTML = '';

                    // ===== IMAGES =====
                    if (post.images && post.images.length > 0) {

                        imageSection.classList.remove('d-none');

                        post.images.forEach(image => {
                            imageContainer.innerHTML += `
                        <div class="col-4" id="image-${image.id}">
                            <div class="card position-relative">
                                <img src="/${image.file_path}" class="img-fluid rounded">
                                <button type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                    onclick="deleteImage(event, ${image.id})">✕</button>

                                <button type="button"
                                    class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-1"
                                    onclick="triggerFile(${image.id})">✎</button>

                                <input type="file"
                                    class="d-none"
                                    id="file-${image.id}"
                                    onchange="replaceImage(${image.id}, this)">
                            </div>
                        </div>`;
                        });
                    }

                    // ===== VIDEOS =====
                    if (post.videos && post.videos.length > 0) {

                        videoSection.classList.remove('d-none');

                        post.videos.forEach(video => {
                            videoContainer.innerHTML += `
        <div class="col-6" id="video-${video.id}">
            <div class="card position-relative">

                <video controls class="w-100 rounded">
                    <source src="/${video.file_path}" type="video/mp4">
                </video>

                <!-- DELETE BUTTON -->
                <button type="button"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                    onclick="deleteVideo(event, ${video.id})">✕</button>

                <!-- ✏️ EDIT BUTTON -->
                <button type="button"
                    class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-1"
                    onclick="triggerVideoFile(${video.id})">✏️</button>

                <!-- HIDDEN FILE INPUT -->
                <input type="file"
                    accept="video/*"
                    class="d-none"
                    id="video-file-${video.id}"
                    onchange="replaceVideo(${video.id}, this)">
            </div>
        </div>`;
                        });
                    }

                    new bootstrap.Modal(
                        document.getElementById('modalEditPost')
                    ).show();
                })
                .catch(err => console.error(err));
        }


    })


    function toggleFollow(userId, element) {

        event.preventDefault(); // 🚫 stop # jump

        if (element.classList.contains('processing')) return;
        element.classList.add('processing');

        fetch(`/follow/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === 'success') {

                    const icon = element.querySelector('i');

                    if (data.following) {

                        // ===== FOLLOWED STATE =====

                        element.classList.remove('text-primary', 'btn-primary');
                        element.classList.add('text-secondary', 'btn-secondary');

                        icon.classList.remove(
                            'bi-person-plus',
                            'bi-plus-circle-fill'
                        );

                        icon.classList.add(
                            'bi-person-check-fill',
                            'bi-check-circle-fill'
                        );

                    } else {

                        // ===== UNFOLLOWED STATE =====

                        element.classList.remove('text-secondary', 'btn-secondary');
                        element.classList.add('text-primary', 'btn-primary');

                        icon.classList.remove(
                            'bi-person-check-fill',
                            'bi-check-circle-fill'
                        );

                        icon.classList.add(
                            'bi-person-plus',
                            'bi-plus-circle-fill'
                        );
                    }
                }
            })
            .catch(err => {
                console.error(err);
                alert('Something went wrong.');
            })
            .finally(() => {
                element.classList.remove('processing');
            });
    }

    function deletePost(postId) {
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
                        // Smooth UI removal
                        postEl.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        postEl.style.opacity = '0';
                        postEl.style.transform = 'scale(0.95)';

                        setTimeout(() => {
                            postEl.remove();

                            // Check if feed is now empty to show a "No posts" message
                            const feed = document.getElementById('postsFeed');
                            if (feed && feed.children.length === 0) {
                                feed.innerHTML = '<div class="text-center py-5">No posts to show.</div>';
                            }
                        }, 400);
                    }
                } else {
                    alert(data.message || 'Something went wrong.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Server error. Could not delete post.');
            });
    }

    // Delete an image (UI only, mark for deletion)
    function deleteImage(e, imageId) {
        e.preventDefault();
        tempDeletedImages.push(imageId);
        document.getElementById(`image-${imageId}`)?.remove();
    }

    // Trigger file picker for replace
    function triggerFile(imageId) {
        document.getElementById(`file-${imageId}`).click();
    }

    function triggerVideoFile(videoId) {
        document.getElementById(`video-file-${videoId}`).click();
    }

    // Replace image (UI only, mark for replace)
    function replaceImage(imageId, input) {
        if (!input.files.length) return;
        tempReplacedImages[imageId] = input.files[0];

        // Update UI preview
        let reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector(`#image-${imageId} img`).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }

    function replaceVideo(videoId, input) {

        if (!input.files.length) return;

        const file = input.files[0];

        // Store replaced video in temp object
        if (!window.tempReplacedVideos) {
            window.tempReplacedVideos = {};
        }

        tempReplacedVideos[videoId] = file;

        // Preview new video immediately
        const videoURL = URL.createObjectURL(file);

        document.querySelector(`#video-${videoId} video source`)
            .setAttribute('src', videoURL);

        document.querySelector(`#video-${videoId} video`).load();
    }

    function deleteVideo(e, videoId) {
        e.preventDefault();
        tempDeletedVideos = tempDeletedVideos || [];
        tempDeletedVideos.push(videoId);
        document.getElementById(`video-${videoId}`)?.remove();
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
                track.style.transform = `translateX(-${index * 100}%)`;
            }

            next?.addEventListener('click', () => {
                index = (index + 1) % slides.length;
                update();
            });

            prev?.addEventListener('click', () => {
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



    function updatePost() {
        let postId = document.getElementById('edit_post_id').value;
        let caption = document.getElementById('edit_caption').value;

        let formData = new FormData();
        formData.append('caption', caption);

        tempDeletedImages.forEach(id => formData.append('deleted_images[]', id));
        tempDeletedVideos.forEach(id => formData.append('deleted_videos[]', id));

        for (let id in tempReplacedImages) {
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
                if (data.success) {
                    // Update feed dynamically
                    const postCard = document.querySelector(`#post-${postId}`);
                    postCard.querySelector('.post-caption').innerText = caption;
                    const mediaContainer = postCard.querySelector(`#post-media-${postId}`);

                    if (!mediaContainer) return;

                    // Update Image Section
                    const cardBody = postCard.querySelector('.card-body');
                    // Select the container of the images (slider or single img)
                    let imageContainer = cardBody.querySelector('.insta-slider') ||
                        cardBody.querySelector('.img-fluid.rounded.w-100') ||
                        cardBody.querySelector('video.w-100.rounded') ||
                        cardBody.querySelector('.text-muted');

                    let newHtml = '';

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
                            <button class="insta-btn prev">‹</button>
                            <button class="insta-btn next">›</button>
                        </div>`;
                    } else if (media.length === 1) {
                        const item = media[0];
                        newHtml = item.type === 'image' ?
                            `<img src="${item.url}" class="img-fluid rounded w-100">` :
                            `<video controls class="w-100 rounded"><source src="${item.url}"></video>`;
                    } else {
                        newHtml = `<div class="text-muted text-center py-4">No media available</div>`;
                    }

                    // Update media container
                    mediaContainer.innerHTML = newHtml;

                    // Re-init slider
                    if (media.length > 1) {
                        const newSlider = mediaContainer.querySelector('.insta-slider');
                        if (newSlider) {
                            delete newSlider.dataset.initialized;
                            initSliders();
                        }
                    }

                    // Then hide modal if you want (optional)
                    bootstrap.Modal.getInstance(document.getElementById('modalEditPost')).hide();
                }
            })
            .catch(err => console.error('Update failed:', err));
    }
</script>
<script>
    // Use a more robust way to select the modal
    let commentsModal;
    document.addEventListener('DOMContentLoaded', () => {
        const modalElem = document.getElementById('commentsModal');
        if (modalElem) {
            commentsModal = new bootstrap.Modal(modalElem);
        }
    });

    function openCommentsModal(postId) {
        document.getElementById('modal-post-id').value = postId;
        loadModalComments(postId);
        commentsModal.show();
    }
    // Global toggle function for replies
    function toggleReplies(commentId) {
        const container = document.getElementById(`replies-container-${commentId}`);
        const btn = document.getElementById(`btn-replies-${commentId}`);

        if (container.classList.contains('d-none')) {
            container.classList.remove('d-none');
            btn.innerHTML = `<i class="bi bi-dash"></i> Hide replies`;
        } else {
            container.classList.add('d-none');
            btn.innerHTML = `<i class="bi bi-plus"></i> View ${container.children.length} replies`;
        }
    }

    function loadModalComments(postId) {
        const container = document.getElementById('modal-comments');
        container.innerHTML = '<div class="text-center"><div class="spinner-border spinner-border-sm"></div></div>';

        // No limit passed here so modal shows all
        fetch(`/comments/${postId}`)
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data.length === 0) {
                    html = '<p class="text-center text-muted">No comments yet.</p>';
                } else {
                    data.forEach(c => {
                        html += renderCommentHtml(c);
                    });
                }
                container.innerHTML = html;
            });
    }

    function renderCommentHtml(c) {
        let avatar = c.user.image ? `/assets/images/users/${c.user.image}` : `/assets/images/avatar/07.jpg`;
        let hasReplies = c.replies && c.replies.length > 0;

        // Process Replies HTML
        let repliesHtml = '';
        if (hasReplies) {
            c.replies.forEach(reply => {
                let rAvatar = reply.user.image ? `/assets/images/users/${reply.user.image}` :
                    `/assets/images/avatar/07.jpg`;
                repliesHtml += `
                <div class="d-flex mt-3 ms-4" id="comment-${reply.id}">
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="${rAvatar}">
                    </div>
                    <div class="bg-light p-2 rounded w-100">
                        <h6 class="mb-0 small fw-bold">${reply.user.username}</h6>
                        <p class="small mb-0">${reply.comment}</p>
                    </div>
                </div>`;
            });
        }

        return `
        <li class="comment-item mb-3" id="comment-${c.id}">
            <div class="d-flex">
                <div class="avatar avatar-xs me-2">
                    <img class="avatar-img rounded-circle" src="${avatar}">
                </div>
                <div class="w-100">
                    <div class="bg-light p-2 rounded">
                        <h6 class="mb-0 small fw-bold">${c.user.username}</h6>
                        <p class="small mb-0">${c.comment}</p>
                    </div>
                    <ul class="nav nav-divider py-1 small">
                        <li class="nav-item">
                            <a class="nav-link p-0 pe-2" href="javascript:void(0)" id="like-comment-${c.id}" onclick="likeComment(${c.id})">
                                <i class="bi ${c.is_liked ? 'bi-heart-fill text-danger' : 'bi-heart'}"></i> 
                                <span>${c.likes_count ?? 0} Like</span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link p-0 pe-2" href="javascript:void(0)" onclick="showReplyInput(${c.id})">Reply</a></li>
                        <li class="nav-item text-muted">${timeAgo(c.created_at)}</li>
                    </ul>

                    ${hasReplies ? `
                        <button class="btn btn-link btn-sm p-0 text-muted small mb-2" id="btn-replies-${c.id}" onclick="toggleReplies(${c.id})">
                            <i class="bi bi-plus"></i> View ${c.replies.length} replies
                        </button>
                    ` : ''}
                    
                    <div id="replies-container-${c.id}" class="d-none">${repliesHtml}</div>

                    <div class="reply-input-box mt-2 d-none" id="reply-box-${c.id}">
                        <form onsubmit="submitReply(event, ${c.post_id}, ${c.id})">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Write a reply...">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </li>`;
    }

    function likeComment(commentId) {
        fetch(`/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const link = document.querySelector(`#like-comment-${commentId}`);
                if (link) {
                    // Fix: ensure we use data.count as returned by your LikeController
                    link.querySelector('span').innerText = `${data.count ?? 0} Like`;
                    link.querySelector('i').className = data.status === 'liked' ? 'bi bi-heart-fill text-danger' :
                        'bi bi-heart';
                }
            })
            .catch(err => console.error("Like error:", err));
    }

    function submitModalComment(e) {
        e.preventDefault();

        const form = e.target;
        const input = form.querySelector('textarea');
        const postId = form.closest('.modal-content') ?
            document.getElementById('modal-post-id').value :
            form.getAttribute('data-post-id'); // For feed-level comments

        if (!input.value.trim()) return;

        fetch('/comments', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json' // Forces Laravel to return JSON errors
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
                    // Refresh logic
                    if (form.closest('.modal')) {
                        loadModalComments(postId);
                    } else {
                        location.reload(); // Or implement a dynamic refresh for the feed list
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

    // Toggle like (existing)
    function toggleLike(postId) {
        fetch(`/like/${postId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById(`like-count-${postId}`).innerText = data.count + ' like' + (data.count !==
                    1 ? 's' : '');
            });
    }

    Dropzone.autoDiscover = false;

    const videoDropzone = new Dropzone("#videoDropzone", {
        url: "{{ route('post.store') }}",
        paramName: "videos[]",
        uploadMultiple: true,
        autoProcessQueue: false,
        maxFiles: 2,
        acceptedFiles: "video/*",
        addRemoveLinks: true,
    });

    document.getElementById('videoPostForm')
        ?.addEventListener('submit', function(e) {

            e.preventDefault();

            let formData = new FormData();
            formData.append('caption',
                this.querySelector('[name="caption"]').value
            );

            videoDropzone.files.forEach(file => {
                formData.append('videos[]', file);
            });

            fetch("{{ route('post.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {

                    if (!data.success) return;

                    document.getElementById('postsFeed')
                        .insertAdjacentHTML('afterbegin', data.html);

                    videoDropzone.removeAllFiles();
                    this.reset();

                    bootstrap.Modal
                        .getInstance(document.getElementById('feedActionVideo'))
                        .hide();
                });
        });

    // Initialize the Multiple Media Dropzone
    const multipleDropzone = new Dropzone("#multiplePostDropzone", {
        url: "{{ route('post.store') }}",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 20,
        maxFiles: 20,
        acceptedFiles: "image/*,video/*",
        addRemoveLinks: true,
    });

    document.getElementById('multiplePostForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        // We append each file to a "media[]" array to keep them in order
        multipleDropzone.files.forEach((file, index) => {
            formData.append(`media[${index}]`, file);
        });

        fetch("{{ route('post.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Your existing logic to prepend the post to the feed
                    document.getElementById('postsFeed').insertAdjacentHTML('afterbegin', data.html);
                    multipleDropzone.removeAllFiles();
                    this.reset();
                    bootstrap.Modal.getInstance(document.getElementById('feedActionMultiple')).hide();
                    if (typeof initSliders === 'function') initSliders();
                }
            });
    });
    // 1. Show/Hide Reply Input
    function showReplyInput(commentId) {
        let box = document.getElementById(`reply-box-${commentId}`);
        box.classList.toggle('d-none');
    }

    function submitReply(event, postId, parentId) {
        event.preventDefault();
        let form = event.target;
        let input = form.querySelector('input');
        let commentText = input.value;

        if (!commentText.trim()) return;

        fetch("{{ route('comments.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    post_id: postId,
                    parent_id: parentId,
                    comment: commentText
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // 1. Clear the input field
                    input.value = '';

                    // 2. Hide the reply box
                    document.getElementById(`reply-box-${parentId}`).classList.add('d-none');

                    // 3. Find the container where replies live
                    const repliesContainer = document.getElementById(`replies-container-${parentId}`);

                    // 4. Ensure container is visible
                    repliesContainer.classList.remove('d-none');

                    // 5. Append the new reply HTML instantly
                    const newReplyHtml = renderSingleReplyHtml(data.comment);
                    repliesContainer.insertAdjacentHTML('beforeend', newReplyHtml);

                    // 6. Optional: Update the "View Replies" button text if it exists
                    const btn = document.getElementById(`btn-replies-${parentId}`);
                    if (btn) btn.innerHTML = `<i class="bi bi-dash"></i> Hide replies`;
                }
            })
            .catch(err => console.error('Reply error:', err));
    }

    function renderSingleReplyHtml(reply) {
        // Check if user object exists, otherwise use current auth user data if available
        let username = reply.user ? reply.user.username : 'You';
        let avatar = (reply.user && reply.user.image) ?
            `/assets/images/users/${reply.user.image}` :
            `/assets/images/avatar/07.jpg`;

        return `
        <div class="d-flex mb-2" id="comment-${reply.id}">
            <div class="avatar avatar-xs me-2">
                <img class="avatar-img rounded-circle" style="width:25px; height:25px;" src="${avatar}">
            </div>
            <div class="bg-light p-2 rounded w-100">
                <h6 class="mb-0 x-small fw-bold">${username}</h6>
                <p class="small mb-0">${reply.comment}</p>
            </div>
        </div>`;
    }

    // 3. Delete a Comment
    function deleteComment(commentId) {
        if (!confirm("Are you sure?")) return;

        fetch(`/comments/${commentId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`comment-${commentId}`).remove();
                }
            });
    }
</script>
