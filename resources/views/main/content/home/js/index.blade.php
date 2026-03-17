<script>
    Dropzone.autoDiscover = false;

    let tempDeletedImages = [];
    let tempReplacedImages = {};
    let tempReplacedVideos = {};

    function showToastFromResponse(data) {
        if (window.showAppToast && data && data.toast) {
            window.showAppToast(data.toast.type, data.toast.title, data.toast.message);
        }
    }

    function fetchJson(url, options = {}) {
        const opts = Object.assign({
            credentials: 'same-origin'
        }, options);
        opts.headers = Object.assign({
            'Accept': 'application/json'
        }, options.headers || {});

        return fetch(url, opts).then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const contentType = res.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) throw new Error('Invalid JSON response');
            return res.json();
        });
    }

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

            fetchJson("{{ route('post.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                })
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
                    showToastFromResponse(data);
                })
                .catch(err => {
                    console.error(err);
                    alert('Could not create post. Please refresh and try again.');
                });
        });

        const blogForm = document.getElementById('blogCreateForm');
        if (blogForm) {
            blogForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(blogForm);
                const xhr = new XMLHttpRequest();

                xhr.open('POST', "{{ route('blogs.store') }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState !== 4) return;

                    if (xhr.status === 200) {
                        let data;
                        try {
                            data = JSON.parse(xhr.responseText);
                        } catch (err) {
                            console.error(err);
                            return;
                        }

                        if (data.status === 'success' && data.blog) {
                            const list = document.getElementById('homeBlogsList');
                            if (list) {
                                const dateText = data.blog.start_date ? data.blog.start_date : 'Date TBA';
                                const itemHtml = `
                                    <div class="d-flex gap-2 mb-3">
                                        <img class="rounded" style="width: 52px; height: 52px; object-fit: cover;"
                                            src="${data.blog.image}" alt="">
                                        <div class="w-100">
                                            <h6 class="mb-0">
                                                <a href="${data.blog.url}">${data.blog.title}</a>
                                            </h6>
                                            <small>${dateText}</small>
                                        </div>
                                    </div>
                                `;

                                if (list.querySelector('.text-muted')) {
                                    list.innerHTML = '';
                                }
                                list.insertAdjacentHTML('afterbegin', itemHtml);

                                while (list.children.length > 5) {
                                    list.removeChild(list.lastElementChild);
                                }
                            }

                            blogForm.reset();
                            const modalEl = document.getElementById('modalCreateBlog');
                            if (modalEl) {
                                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                modal.hide();
                            }
                            showToastFromResponse(data);
                        }
                    } else {
                        alert('Could not create blog.');
                    }
                };

                xhr.send(formData);
            });
        }

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

    document.addEventListener("DOMContentLoaded", function() {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (!loadMoreBtn) return;

        loadMoreBtn.addEventListener('click', function() {
            const nextPage = loadMoreBtn.getAttribute('data-next-page');
            if (!nextPage) return;

            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'Loading...';

            fetch(nextPage, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const feed = document.getElementById('postsFeed');
                    if (feed && data.html) {
                        feed.insertAdjacentHTML('beforeend', data.html);
                        initSliders();
                    }

                    if (data.next_page_url) {
                        loadMoreBtn.setAttribute('data-next-page', data.next_page_url);
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Load more';
                    } else {
                        const wrap = document.getElementById('loadMoreWrap');
                        if (wrap) wrap.remove();
                    }
                })
                .catch(err => {
                    console.error(err);
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'Load more';
                });
        });
    });


    function toggleFollow(userId, element) {

        event.preventDefault(); // stop # jump

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
                    if (window.updateFollowButton) {
                        window.updateFollowButton(element, data.following, data.requested);
                    }
                    if (window.updateFollowCounts) {
                        window.updateFollowCounts(data);
                    }
                    showToastFromResponse(data);
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
                    showToastFromResponse(data);
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
                                <i class="bi ${c.is_liked ? 'bi-heart-fill text-danger' : 'bi-heart'} like-icon"></i> 
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
                    const icon = link.querySelector('i');
                    link.querySelector('span').innerText = `${data.count ?? 0} Like`;
                    if (icon) {
                        icon.className = data.status === 'liked' ? 'bi bi-heart-fill text-danger like-icon' : 'bi bi-heart like-icon';
                        icon.classList.remove('like-bounce');
                        void icon.offsetWidth;
                        icon.classList.add('like-bounce');
                    }
                }
                showToastFromResponse(data);
            })
            .catch(err => console.error("Like error:", err));
    }

    function submitModalComment(e) {
        e.preventDefault();

        const form = e.target;
        const input = form.querySelector('textarea');
        const inModal = !!form.closest('.modal-content');
        const postId = inModal ?
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

                    if (inModal) {
                        const container = document.getElementById('modal-comments');
                        if (container) {
                            const comment = data.comment;
                            comment.replies = comment.replies || [];
                            const html = renderCommentHtml(comment);
                            container.insertAdjacentHTML('afterbegin', html);
                        }
                    } else {
                        const list = document.getElementById(`comment-list-${postId}`);
                        if (list) {
                            const html = renderInlineCommentHtml(data.comment);
                            list.insertAdjacentHTML('afterbegin', html);
                            const inserted = list.firstElementChild;
                            if (inserted) inserted.classList.add('comment-flash');
                        }
                    }

                    updateCommentCount(postId, 1);
                    showToastFromResponse(data);
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
        const btn = document.getElementById(`post-like-btn-${postId}`);
        const countEl = document.getElementById(`like-count-${postId}`);
        if (!btn || !countEl) return;
        if (btn.classList.contains('processing')) return;

        btn.classList.add('processing');

        fetch(`/like/${postId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                const icon = btn.querySelector('i');
                const isLiked = data.status === 'liked';

                btn.dataset.liked = isLiked ? '1' : '0';
                btn.classList.toggle('text-danger', isLiked);

                if (icon) {
                    icon.className = isLiked ? 'bi bi-heart-fill text-danger like-icon' : 'bi bi-heart like-icon';
                    icon.classList.remove('like-bounce');
                    void icon.offsetWidth;
                    icon.classList.add('like-bounce');
                }

                countEl.innerText = data.count + ' like' + (data.count !== 1 ? 's' : '');
                showToastFromResponse(data);
            })
            .catch(err => console.error('Like error:', err))
            .finally(() => {
                btn.classList.remove('processing');
            });
    }

    function updateCommentCount(postId, delta) {
        const countEl = document.getElementById(`comment-count-${postId}`);
        if (!countEl) return;
        const current = parseInt(countEl.textContent, 10) || 0;
        countEl.textContent = Math.max(current + delta, 0);
    }

    function renderInlineCommentHtml(comment) {
        const avatar = comment.user && comment.user.image ?
            `/assets/images/users/${comment.user.image}` :
            `/assets/images/avatar/07.jpg`;
        return `
            <li class="comment-item mb-3" id="comment-${comment.id}">
                <div class="d-flex">
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="${avatar}">
                    </div>
                    <div class="w-100">
                        <div class="bg-light p-2 rounded">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 small fw-bold">${comment.user.username}</h6>
                                <div class="dropdown">
                                    <i class="bi bi-three-dots cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)"
                                                onclick="deleteComment(${comment.id})">Delete</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="small mb-0">${comment.comment}</p>
                        </div>
                        <ul class="nav nav-divider py-1 small">
                            <li class="nav-item">
                                <a class="nav-link p-0 pe-2" href="javascript:void(0)" onclick="likeComment(${comment.id})" id="like-comment-${comment.id}">
                                    <i class="bi bi-heart like-icon"></i>
                                    <span>0 Like</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-0 pe-2" href="javascript:void(0)" onclick="showReplyInput(${comment.id})">Reply</a>
                            </li>
                            <li class="nav-item text-secondary">just now</li>
                        </ul>
                    </div>
                </div>
            </li>
        `;
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

            fetchJson("{{ route('post.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                })
                .then(data => {

                    if (!data.success) return;

                    document.getElementById('postsFeed')
                        .insertAdjacentHTML('afterbegin', data.html);

                    videoDropzone.removeAllFiles();
                    this.reset();

                    bootstrap.Modal
                        .getInstance(document.getElementById('feedActionVideo'))
                        .hide();
                    showToastFromResponse(data);
                })
                .catch(err => {
                    console.error(err);
                    alert('Could not create post. Please refresh and try again.');
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

        fetchJson("{{ route('post.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(data => {
                if (data.success) {
                    // Your existing logic to prepend the post to the feed
                    document.getElementById('postsFeed').insertAdjacentHTML('afterbegin', data.html);
                    multipleDropzone.removeAllFiles();
                    this.reset();
                    bootstrap.Modal.getInstance(document.getElementById('feedActionMultiple')).hide();
                    if (typeof initSliders === 'function') initSliders();
                    showToastFromResponse(data);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Could not create post. Please refresh and try again.');
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
                    showToastFromResponse(data);
                }
            });
    }
</script>


