@extends('main.body.master')

@section('title', 'Blogs')

@section('main')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Blogs</h5>
                    <button type="button" class="btn btn-primary-soft btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateBlog">Create Blog</button>
                </div>
                <div class="card-body">
                    <div id="myBlogsList">
                        @forelse ($userBlogs as $blog)
                            <div class="d-flex align-items-start mb-4" id="blog-{{ $blog->id }}"
                                data-blog-title="{{ $blog->title }}">
                                <img class="rounded me-3 blog-thumb" style="width: 120px; height: 80px; object-fit: cover;"
                                    src="{{ $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/post/16by9/big/03.jpg') }}"
                                    alt="">
                                <div class="w-100">
                                    <h6 class="mb-1">
                                        <a href="{{ route('blogs.show', $blog) }}" data-blog-title-text="{{ $blog->id }}">{{ $blog->title }}</a>
                                    </h6>
                                    <div class="small text-muted mb-2" data-blog-meta="{{ $blog->id }}">
                                        <i class="bi bi-calendar-date pe-1"></i>
                                        <span data-blog-date="{{ $blog->id }}">
                                            {{ $blog->start_date ? \Carbon\Carbon::parse($blog->start_date)->format('M d, Y') : 'Date TBA' }}
                                        </span>
                                        @if ($blog->location)
                                            <span class="ms-2" data-blog-location="{{ $blog->id }}"><i class="bi bi-geo-alt pe-1"></i>{{ $blog->location }}</span>
                                        @else
                                            <span class="ms-2" data-blog-location="{{ $blog->id }}" style="display:none;"></span>
                                        @endif
                                    </div>
                                    <p class="mb-0 text-muted" data-blog-description="{{ $blog->id }}">{{ \Illuminate\Support\Str::limit($blog->description, 120) }}</p>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-light" onclick="openBlogEditModal({{ $blog->id }})">Edit</button>
                                        <form method="POST" action="{{ route('blogs.destroy', $blog) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-soft">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5" id="myBlogsEmpty">No blogs yet.</div>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        {{ $userBlogs->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header pb-0 border-0">
                    <h5 class="card-title mb-0">All Blogs</h5>
                </div>
                <div class="card-body" id="allBlogsList">
                    @forelse ($allBlogs as $blog)
                        <div class="d-flex gap-2 mb-3">
                            <img class="rounded" style="width: 52px; height: 52px; object-fit: cover;"
                                src="{{ $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/post/16by9/big/03.jpg') }}"
                                alt="">
                            <div class="w-100">
                                <h6 class="mb-0">
                                    <a href="{{ route('blogs.show', $blog) }}" data-blog-title-text="{{ $blog->id }}">{{ $blog->title }}</a>
                                </h6>
                                <small class="text-muted" data-blog-date="{{ $blog->id }}">
                                    {{ $blog->start_date ? \Carbon\Carbon::parse($blog->start_date)->format('M d, Y') : 'Date TBA' }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small" id="allBlogsEmpty">No blogs yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('main.modals.homeModals.blogCreateModal')
    @include('main.modals.homeModals.blogEditModal')
@endsection

@section('script')
    <script>
        function showToastFromResponse(data) {
            if (window.showAppToast && data && data.toast) {
                window.showAppToast(data.toast.type, data.toast.title, data.toast.message);
            }
        }

document.addEventListener('DOMContentLoaded', function() {
            const createForm = document.getElementById('blogCreateForm');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(createForm);
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
                                const blog = data.blog;
                                const myList = document.getElementById('myBlogsList');
                                const myEmpty = document.getElementById('myBlogsEmpty');
                                if (myEmpty) myEmpty.remove();

                                if (myList) {
                                    const itemHtml = `
                                        <div class="d-flex align-items-start mb-4" id="blog-${blog.id}">
                                            <img class="rounded me-3 blog-thumb" style="width: 120px; height: 80px; object-fit: cover;"
                                                src="${blog.image}" alt="">
                                            <div class="w-100">
                                                <h6 class="mb-1">
                                                    <a href="${blog.url}" data-blog-title-text="${blog.id}">${blog.title}</a>
                                                </h6>
                                                <div class="small text-muted mb-2" data-blog-meta="${blog.id}">
                                                    <i class="bi bi-calendar-date pe-1"></i>
                                                    <span data-blog-date="${blog.id}">${blog.start_date || 'Date TBA'}</span>
                                                    <span class="ms-2" data-blog-location="${blog.id}" style="${blog.location ? '' : 'display:none;'}">
                                                        ${blog.location ? `<i class="bi bi-geo-alt pe-1"></i>${blog.location}` : ''}
                                                    </span>
                                                </div>
                                                <p class="mb-0 text-muted" data-blog-description="${blog.id}">${blog.description ? blog.description.substring(0, 120) : ''}</p>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-light" onclick="openBlogEditModal(${blog.id})">Edit</button>
                                                    <form method="POST" action="/blogs/${blog.id}" class="d-inline">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-sm btn-danger-soft">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    myList.insertAdjacentHTML('afterbegin', itemHtml);
                                }

                                const allList = document.getElementById('allBlogsList');
                                const allEmpty = document.getElementById('allBlogsEmpty');
                                if (allEmpty) allEmpty.remove();
                                if (allList) {
                                    const allHtml = `
                                        <div class="d-flex gap-2 mb-3">
                                            <img class="rounded" style="width: 52px; height: 52px; object-fit: cover;" src="${blog.image}" alt="">
                                            <div class="w-100">
                                                <h6 class="mb-0"><a href="${blog.url}" data-blog-title-text="${blog.id}">${blog.title}</a></h6>
                                                <small class="text-muted" data-blog-date="${blog.id}">${blog.start_date || 'Date TBA'}</small>
                                            </div>
                                        </div>
                                    `;
                                    allList.insertAdjacentHTML('afterbegin', allHtml);
                                }

                                createForm.reset();
                                const modalEl = document.getElementById('modalCreateBlog');
                                if (modalEl) {
                                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    modal.hide();
                                }
                                showToastFromResponse(data)
                            }
                        } else {
                            alert('Could not create blog.');
                        }
                    };

                    xhr.send(formData);
                });
            }

            const editForm = document.getElementById('blogEditForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const blogId = document.getElementById('edit_blog_id').value;
                    if (!blogId) return;

                    const formData = new FormData(editForm);
                    formData.append('_method', 'PUT');

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', `/blogs/${blogId}`, true);
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
                                const blog = data.blog;
                                const titleEls = document.querySelectorAll(`[data-blog-title-text="${blogId}"]`);
                                titleEls.forEach(el => el.textContent = blog.title);

                                const descEl = document.querySelector(`[data-blog-description="${blogId}"]`);
                                if (descEl) {
                                    descEl.textContent = blog.description ? blog.description.substring(0, 120) : '';
                                }

                                const dateEls = document.querySelectorAll(`[data-blog-date="${blogId}"]`);
                                dateEls.forEach(el => el.textContent = blog.start_date ? blog.start_date : 'Date TBA');

                                const locationEl = document.querySelector(`[data-blog-location="${blogId}"]`);
                                if (locationEl) {
                                    if (blog.location) {
                                        locationEl.style.display = '';
                                        locationEl.innerHTML = `<i class="bi bi-geo-alt pe-1"></i>${blog.location}`;
                                    } else {
                                        locationEl.style.display = 'none';
                                        locationEl.textContent = '';
                                    }
                                }

                                const card = document.getElementById(`blog-${blogId}`);
                                if (card) {
                                    const thumb = card.querySelector('.blog-thumb');
                                    if (thumb && blog.image) thumb.src = blog.image;
                                }

                                const modalEl = document.getElementById('modalEditBlog');
                                if (modalEl) {
                                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    modal.hide();
                                }
                                showToastFromResponse(data)
                            }
                        } else {
                            alert('Could not update blog.');
                        }
                    };

                    xhr.send(formData);
                });
            }
        });

        window.openBlogEditModal = function(blogId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `/blogs/${blogId}/edit`, true);
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
                        document.getElementById('edit_blog_id').value = data.blog.id;
                        document.getElementById('edit_blog_title').value = data.blog.title || '';
                        document.getElementById('edit_blog_category').value = data.blog.category || '';
                        document.getElementById('edit_blog_description').value = data.blog.description || '';
                        document.getElementById('edit_blog_location').value = data.blog.location || '';
                        document.getElementById('edit_blog_start_date').value = data.blog.start_date || '';
                        document.getElementById('edit_blog_end_date').value = data.blog.end_date || '';

                        const modalEl = document.getElementById('modalEditBlog');
                        if (modalEl) {
                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            modal.show();
                        }
                    }
                } else {
                    alert('Could not load blog.');
                }
            };

            xhr.send();
        };
    </script>
@endsection


