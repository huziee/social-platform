<style>
    /* Post thumbnail container */
.profile-post-thumb {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;   /* Perfect square */
    overflow: hidden;
    border-radius: 10px;
    background: #111;
    cursor: pointer;
}

/* Image & video fill the box */
.profile-post-thumb img,
.profile-post-thumb video {
    width: 100%;
    height: 100%;
    object-fit: cover;   /* Crop to fill (IMPORTANT) */
    display: block;
}

/* Overlay styling */
.profile-post-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    color: #fff;
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    font-weight: 600;
    transition: opacity 0.2s ease;
}

.profile-post-thumb:hover .profile-post-overlay {
    opacity: 1;
}
</style>
<!-- Share feed START -->
<div class="card card-body">
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
</div>


