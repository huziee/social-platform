<script>
    Dropzone.autoDiscover = false;

    let tempDeletedImages = [];
    let tempReplacedImages = {};

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

            fetch(`/posts/${postId}/edit`)
                .then(res => res.json())
                .then(data => {

                    const post = data.post;

                    document.getElementById('edit_post_id').value = post.id;
                    document.getElementById('edit_caption').value = post.caption;

                    let container = document.getElementById('editPostImage');
                    container.innerHTML = '';

                    (post.images ?? []).forEach(image => {
                        container.innerHTML += `
                    <div class="col-4" id="image-${image.id}">
                        <div class="card position-relative">
                            <img src="${image.image.startsWith('http') ? image.image : '/' + image.image}"
                                 class="img-fluid rounded">

                            <button type="button"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                onclick="deleteImage(event, ${image.id})">✕</button>

                            <button type="button"
                                class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-1"
                                onclick="triggerFile(${image.id})">✎</button>

                            <input type="file" class="d-none"
                                id="file-${image.id}"
                                onchange="replaceImage(${image.id}, this)">
                        </div>
                    </div>`;
                    });

                    new bootstrap.Modal(
                        document.getElementById('modalEditPost')
                    ).show();
                })
                .catch(err => console.error(err));
        }


    })


    function toggleFollow(userId, element) {
    // Prevent multiple clicks while processing
    if (element.classList.contains('processing')) return;
    element.classList.add('processing');

    fetch(`/follow/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            // Update the UI instantly
            if (data.following) {
                element.innerText = 'Following';
                element.classList.replace('text-primary', 'text-secondary');
            } else {
                element.innerText = 'Follow';
                element.classList.replace('text-secondary', 'text-primary');
            }
        }
    })
    .catch(err => {
        console.error(err);
        alert('Something went wrong. Please try again.');
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

    function editPost(postId) {
        tempDeletedImages = [];
        tempReplacedImages = {};

        fetch(`/posts/${postId}/edit`)
            .then(res => res.json())
            .then(data => {
                const post = data.post;

                document.getElementById('edit_post_id').value = post.id;
                document.getElementById('edit_caption').value = post.caption;

                let container = document.getElementById('editPostImage');
                container.innerHTML = '';

                (post.images ?? []).forEach(image => {
                    container.innerHTML += `
                <div class="col-4" id="image-${image.id}">
                    <div class="card position-relative">
                        <img src="${image.image.startsWith('http') ? image.image : '/' + image.image}"
                             class="img-fluid rounded">

                        <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                            onclick="deleteImage(event, ${image.id})">✕</button>

                        <button type="button"
                            class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-1"
                            onclick="triggerFile(${image.id})">✎</button>

                        <input type="file" class="d-none"
                            id="file-${image.id}"
                            onchange="replaceImage(${image.id}, this)">
                    </div>
                </div>`;
                });

                new bootstrap.Modal(document.getElementById('modalEditPost')).show();
            });
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

    // Update post (apply all changes)
    function updatePost() {
        let postId = document.getElementById('edit_post_id').value;
        let caption = document.getElementById('edit_caption').value;

        let formData = new FormData();
        formData.append('caption', caption);

        tempDeletedImages.forEach(id => formData.append('deleted_images[]', id));
        for (let id in tempReplacedImages) {
            formData.append(`replaced_images[${id}]`, tempReplacedImages[id]);
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
                    const postCard = document.querySelector(`#post-${postId}`);

                    // Update Caption
                    postCard.querySelector('.post-caption').innerText = caption;

                    // Update Image Section
                    const cardBody = postCard.querySelector('.card-body');
                    // Select the container of the images (slider or single img)
                    let imageContainer = cardBody.querySelector('.insta-slider') ||
                        cardBody.querySelector('.img-fluid.rounded.w-100') ||
                        cardBody.querySelector('.text-muted');

                    let newHtml = '';
                    if (data.images.length > 1) {
                        newHtml = `
                    <div class="insta-slider">
                        <div class="insta-track">
                            ${data.images.map(img => `
                                <div class="insta-slide">
                                    <img src="${img.url}" data-image-id="${img.id}" alt="Post Image">
                                </div>
                            `).join('')}
                        </div>
                        <button class="insta-btn prev">‹</button>
                        <button class="insta-btn next">›</button>
                    </div>`;
                    } else if (data.images.length === 1) {
                        newHtml =
                            `<img class="img-fluid rounded w-100" src="${data.images[0].url}" data-image-id="${data.images[0].id}">`;
                    } else {
                        newHtml = `<div class="text-muted text-center py-4">No image available</div>`;
                    }

                    // Swap the old HTML for the new HTML
                    imageContainer.outerHTML = newHtml;

                    // Re-initialize slider logic if multiple images exist
                    if (data.images.length > 1) {
                        // Remove 'initialized' flag so initSliders() picks up the new DOM
                        const newSlider = cardBody.querySelector('.insta-slider');
                        delete newSlider.dataset.initialized;
                        initSliders();
                    }

                    // Close modal
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

function loadModalComments(postId) {
    fetch(`/comments/${postId}`)
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            let html = '';
            data.forEach(c => {
                let avatar = c.user.image 
                    ? `/assets/images/users/${c.user.image}` 
                    : `/assets/images/avatar/07.jpg`;

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
            document.getElementById('modal-comments').innerHTML = html || '<p class="text-center">No comments yet.</p>';
        })
        .catch(err => console.error('Fetch error:', err));
}

function submitModalComment(e) {
    e.preventDefault();
    
    const form = e.target;
    const input = form.querySelector('textarea');
    const postId = form.closest('.modal-content') 
                   ? document.getElementById('modal-post-id').value 
                   : form.getAttribute('data-post-id'); // For feed-level comments

    if (!input.value.trim()) return;

    fetch('/comments', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json' // Forces Laravel to return JSON errors
        },
        body: JSON.stringify({ post_id: postId, comment: input.value })
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
    const intervals = { year: 31536000, month: 2592000, day: 86400, hour: 3600, minute: 60 };
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
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById(`like-count-${postId}`).innerText = data.count + ' like' + (data.count !== 1 ? 's' : '');
    });
}

// document.addEventListener('DOMContentLoaded', () => {
//     @foreach($posts as $post)
//         loadComments({{ $post->id }});
//     @endforeach
// });

</script>

