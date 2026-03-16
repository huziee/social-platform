<style>
    .profile-saved-thumb {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        border-radius: 10px;
        background: #111;
        cursor: pointer;
    }

    .profile-saved-thumb img,
    .profile-saved-thumb video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-saved-overlay {
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

    .profile-saved-thumb:hover .profile-saved-overlay {
        opacity: 1;
    }
</style>

<div class="card card-body">
    <div id="savedFeed" class="mt-3">
        @if (empty($savedPosts) || $savedPosts->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    No saved posts yet.
                </div>
            </div>
        @else
            <div class="row g-2">
                @foreach ($savedPosts as $post)
                    @php
                        $thumb = $post->media->first();
                    @endphp

                    @if ($thumb)
                        <div class="col-4 col-md-3 col-lg-3">
                            <div class="profile-saved-thumb rounded" onclick="openPostModal({{ $post->id }})">
                                @if ($thumb->type === 'image')
                                    <img src="{{ asset($thumb->file_path) }}" alt="Saved post image">
                                @else
                                    <video muted>
                                        <source src="{{ asset($thumb->file_path) }}">
                                    </video>
                                @endif

                                <div class="profile-saved-overlay">
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
</div>
