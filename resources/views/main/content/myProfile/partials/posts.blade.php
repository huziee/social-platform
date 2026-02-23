<!-- Share feed START -->
<div class="card card-body">
    <div class="d-flex mb-3">
        <!-- Avatar -->
        <div class="avatar avatar-xs me-2">
            <a href="#">
                <img class="avatar-img rounded-circle"
                    src="{{ Auth::user()->image ? asset('assets/images/users/' . Auth::user()->image) : asset('assets/images/avatar/07.jpg') }}"
                    alt="">
            </a>
        </div>
        <!-- Post input -->
        <form class="w-100">
            <input class="form-control pe-4 border-0" placeholder="Share your thoughts..." data-bs-toggle="modal"
                data-bs-target="#modalCreateFeed">
        </form>
    </div>
</div>
<!-- Share feed END -->

<!-- User posts grid START -->
<div id="postsFeed" class="mt-3">
    @if ($posts->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                No posts to show yet.
            </div>
        </div>
    @else
        <div class="row g-2">
            @foreach ($posts as $post)
                @php
                    $thumb = $post->media->first();
                @endphp

                @if ($thumb)
                    <div class="col-4 col-md-3 col-lg-3">
                        <div class="profile-post-thumb rounded" onclick="openPostModal({{ $post->id }})">
                            @if ($thumb->type === 'image')
                                <img src="{{ asset($thumb->file_path) }}" alt="Post image">
                            @else
                                <video muted>
                                    <source src="{{ asset($thumb->file_path) }}">
                                </video>
                            @endif

                            <div class="profile-post-overlay">
                                <span>
                                    <i class="bi bi-heart-fill me-1"></i>
                                    {{ $post->likes->count() }}
                                </span>
                                <span>
                                    <i class="bi bi-chat-fill me-1"></i>
                                    {{ $post->comments->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
<!-- User posts grid END -->