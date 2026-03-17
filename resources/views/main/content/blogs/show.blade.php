@extends('main.body.master')

@section('title', $blog->title)

@section('main')
<div class="container">
    <div class="row g-4">
      <!-- Main content START -->
      <div class="col-lg-8 mx-auto">
        <div class="vstack gap-4">
          <!-- Blog single START -->
          <div class="card card-body" id="blog-show-{{ $blog->id }}">
            <img class="rounded" id="blog-show-image" src="{{ $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/post/16by9/big/03.jpg') }}" alt="">
            <div class="mt-4">
              <!-- Tag -->
              <span id="blog-show-category-wrap" style="{{ $blog->category ? '' : 'display:none;' }}">
                <a href="#" class="badge bg-danger bg-opacity-10 text-danger mb-2 fw-bold" id="blog-show-category">{{ $blog->category }}</a>
              </span>
              <!-- Title info -->
              <h1 class="mb-2 h2" id="blog-show-title">{{ $blog->title }}</h1>
              @if ($blog->user_id === auth()->id())
                <div class="mb-3">
                  <button type="button" class="btn btn-sm btn-light" onclick="openBlogEditModal({{ $blog->id }})">Edit</button>
                  <form method="POST" action="{{ route('blogs.destroy', $blog) }}" class="d-inline" onsubmit="deleteBlog(event, {{ $blog->id }})">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger-soft">Delete</button>
                  </form>
                </div>
              @endif
              <ul class="nav nav-stack gap-3 align-items-center">
                <li class="nav-item">
                  <div class="nav-link">
                    by <a href="{{ route('user.profile', $blog->user->username) }}" class="text-reset btn-link">{{ $blog->user->first_name }} {{ $blog->user->last_name }}</a>
                  </div>
                </li>
                <li class="nav-item">
                  <i class="bi bi-calendar-date pe-1"></i><span id="blog-show-date">{{ $blog->start_date ? \Carbon\Carbon::parse($blog->start_date)->format('M d, Y') : 'Date TBA' }}</span>
                </li>
                <li class="nav-item" id="blog-show-location-wrap" style="{{ $blog->location ? '' : 'display:none;' }}">
                    <i class="bi bi-geo-alt pe-1"></i><span id="blog-show-location">{{ $blog->location }}</span>
                </li>
              </ul>
              <!-- description -->
              <p class="mt-4" id="blog-show-description">{{ $blog->description }}</p>
            </div>
          </div>
          <!-- Card END -->
        </div>
      </div>
      <!-- Main content END -->
    </div>
  </div>

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

                            const titleEl = document.getElementById('blog-show-title');
                            if (titleEl) titleEl.textContent = blog.title;

                            const descEl = document.getElementById('blog-show-description');
                            if (descEl) descEl.textContent = blog.description || '';

                            const dateEl = document.getElementById('blog-show-date');
                            if (dateEl) dateEl.textContent = blog.start_date ? blog.start_date : 'Date TBA';

                            const locationWrap = document.getElementById('blog-show-location-wrap');
                            const locationEl = document.getElementById('blog-show-location');
                            if (locationWrap && locationEl) {
                                if (blog.location) {
                                    locationWrap.style.display = '';
                                    locationEl.textContent = blog.location;
                                } else {
                                    locationWrap.style.display = 'none';
                                    locationEl.textContent = '';
                                }
                            }

                            const categoryWrap = document.getElementById('blog-show-category-wrap');
                            const categoryEl = document.getElementById('blog-show-category');
                            if (categoryWrap && categoryEl) {
                                if (blog.category) {
                                    categoryWrap.style.display = '';
                                    categoryEl.textContent = blog.category;
                                } else {
                                    categoryWrap.style.display = 'none';
                                    categoryEl.textContent = '';
                                }
                            }

                            const imageEl = document.getElementById('blog-show-image');
                            if (imageEl && blog.image) imageEl.src = blog.image;

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

    window.deleteBlog = function(e, blogId) {
        if (e) e.preventDefault();
        if (!confirm('Delete this blog?')) return;

        fetch(`/blogs/${blogId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showToastFromResponse(data)
                    setTimeout(() => {
                        window.location.href = "{{ route('blogs.index') }}";
                    }, 400);
                }
            })
            .catch(() => {
                alert('Could not delete blog.');
            });
    };
  </script>
@endsection




