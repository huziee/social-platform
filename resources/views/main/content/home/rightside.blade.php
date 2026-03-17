<div class="col-lg-3">
    <div class="row g-4">
        <!-- Card follow START -->
        <div class="col-sm-6 col-lg-12">
            <div class="card">
                <!-- Card header START -->
                <div class="card-header pb-0 border-0">
                    <h5 class="card-title mb-0">Who to follow</h5>
                </div>
                <!-- Card header END -->
                <!-- Card body START -->
                <div class="card-body">
                    <!-- Connection item START -->
                    @foreach ($user as $us)
                        @if (auth()->id() !== $us->id)
                            <div class="hstack gap-2 mb-3">
                                <!-- Avatar -->
                                <div class="avatar">
                                    <a href="#">
                                        <img class="avatar-img rounded-circle"
                                            src="{{ $us->image ? asset('assets/images/users/' . $us->image) : asset('assets/images/07.jpg') }}"
                                            alt="">
                                    </a>
                                </div>

                                <!-- Name -->
                                <div class="overflow-hidden">
                                    <a class="h6 mb-0" href="#!">{{ $us->first_name }} {{ $us->last_name }}</a>
                                    <p class="mb-0 small text-truncate">{{ $us->username }}</p>
                                </div>

                                @php
                                    $isRequested = auth()->check() ? auth()->user()->hasPendingFollowRequest($us->id) : false;
                                @endphp
                                <button
                                    class="btn btn-primary-soft rounded-circle icon-md ms-auto
                                    {{ auth()->user()->isFollowing($us->id) || $isRequested ? 'btn-secondary' : 'btn-primary' }}"
                                    onclick="toggleFollow({{ $us->id }}, this)">

                                    <i class="ff-btn bi {{ auth()->user()->isFollowing($us->id) ? 'bi-person-check-fill' : ($isRequested ? 'bi-hourglass-split' : 'bi-person-plus') }}"></i>

                                </button>
                            </div>
                        @endif
                    @endforeach

                    <!-- View more button -->
                    <div class="d-grid mt-3">
                        <a class="btn btn-sm btn-primary-soft" href="#!">View more</a>
                    </div>
                </div>
                <!-- Card body END -->
            </div>
        </div>
        <!-- Card follow END -->

        <!-- Card Blogs START -->
        <div class="col-sm-6 col-lg-12">
            <div class="card">
                <!-- Card header START -->
                <div class="card-header pb-0 border-0">
                    <h5 class="card-title mb-0">Blogs</h5>
                </div>
                <!-- Card header END -->
                <!-- Card body START -->
                <div class="card-body">
                    <div id="homeBlogsList">
                        @if (!empty($blogs) && $blogs->count())
                            @foreach ($blogs as $blog)
                                <div class="d-flex gap-2 mb-3">
                                    <img class="rounded" style="width: 52px; height: 52px; object-fit: cover;"
                                        src="{{ $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/post/16by9/big/03.jpg') }}"
                                        alt="">
                                    <div class="w-100">
                                        <h6 class="mb-0">
                                            <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
                                        </h6>
                                        <small>
                                            {{ $blog->start_date ? \Carbon\Carbon::parse($blog->start_date)->format('M d, Y') : 'Date TBA' }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-muted small">No blogs yet.</div>
                        @endif
                    </div>
                    <a href="{{ route('blogs.index') }}" class="btn btn-link btn-sm text-secondary d-flex align-items-center">
                        View all blogs
                    </a>
                </div>
                <!-- Card body END -->
            </div>
        </div>
        <!-- Card Blogs END -->
    </div>
</div>
