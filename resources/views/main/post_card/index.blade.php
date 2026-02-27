<div class="card mb-3" id="post-{{ $post->id }}">
    <div class="card-header border-0 pb-0">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-story me-2">
    <a href="javascript:void(0)" 
       class="open-user-story"
       data-user-id="{{ $post->user->id }}">
                        <img class="avatar-img rounded-circle"
                            src="{{ $post->user->image ? asset('assets/images/users/' . $post->user->image) : asset('assets/images/avatar/07.jpg') }}"
                            alt="{{ $post->user->username }}">
                    </a>
                </div>
                <div>
                    <div class="nav nav-divider">
                        <h6 class="nav-item card-title mb-0">
    @if(auth()->id() === $post->user_id)
        {{-- Link to own profile --}}
        <a href="{{ route('profile.index') }}">{{ $post->user->username }}</a>
    @else
        {{-- Link to public profile of others --}}
        <a href="{{ route('user.profile', $post->user->username) }}">{{ $post->user->username }}</a>
    @endif
</h6>
                        <span class="nav-item small">{{ $post->created_at->diffForHumans() }}</span>
                        @if (auth()->check() && auth()->id() !== $post->user_id)
                            <span class="nav-item small ms-2">
                                @php $isFollowing = auth()->user()->isFollowing($post->user_id); @endphp
                                <a href="#" onclick="toggleFollow({{ $post->user_id }}, this)"
                                    class="fw-bold {{ $isFollowing ? 'text-secondary' : 'text-primary' }}"
                                    style="text-decoration: none;">
                                    <i
                                        class="bi {{ $isFollowing ? 'bi-check-circle-fill' : 'bi-plus-circle-fill' }}"></i>
                                    {{-- {{ $isFollowing ? 'Following' : 'Follow' }} --}}
                                </a>
                            </span>
                        @endif
                    </div>
                    <p class="mb-0 small">{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                </div>
            </div>
            <div class="dropdown">
                <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </a>
                <!-- Card feed action dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                    @if (auth()->check() && auth()->id() === $post->user_id)
                        <li>
                            <a class="dropdown-item" href="#" onclick="editPost({{ $post->id }})">
                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit post
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="javascript:void(0)"
                                onclick="deletePost({{ $post->id }})">
                                <i class="bi bi-x-circle fa-fw pe-2"></i>Delete post
                            </a>
                        </li>
                    @endif

                    <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                    </li>


                </ul>
            </div>
        </div>

    </div>
    <div class="card-body">
        <p class="post-caption">{{ $post->caption }}</p>

        <div id="post-media-{{ $post->id }}">
            @php
                $media = $post->media;
            @endphp

            @if ($media->count() > 1)

                <!-- MULTIPLE MEDIA SLIDER -->
                <div class="insta-slider">
                    <div class="insta-track">

                        @foreach ($media as $item)
                            <div class="insta-slide">

                                @if ($item->type === 'image')
                                    <img src="{{ asset($item->file_path) }}" class="w-100 rounded">
                                @else
                                    <video controls class="w-100 rounded">
                                        <source src="{{ asset($item->file_path) }}">
                                    </video>
                                @endif

                            </div>
                        @endforeach

                    </div>

                    <button class="insta-btn prev">‹</button>
                    <button class="insta-btn next">›</button>
                </div>
            @elseif ($media->count() === 1)
                <!-- SINGLE MEDIA -->
                @php $item = $media->first();
                 @endphp
                
                @if ($item->type === 'image')
                    <img src="{{ asset($item->file_path) }}" class="img-fluid rounded w-100">
                @else
                    <video controls class="w-100 rounded">
                        <source src="{{ asset($item->file_path) }}">
                    </video>
                @endif
            @else
                <!-- NO MEDIA -->
                <div class="text-muted text-center py-4">
                    No media available
                </div>

            @endif
        </div>
            <ul class="nav nav-stack py-3 small">
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="toggleLike({{ $post->id }})"
                        class="nav-link {{ $post->isLikedByAuth() ? 'text-danger' : '' }}">
                        <i class="bi bi-heart-fill"></i>
                        <span id="like-count-{{ $post->id }}">
                            {{ $post->likes->count() }} Like
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!" onclick="openCommentsModal({{ $post->id }})"> <i
                            class="bi bi-chat-fill pe-1"></i> Comments ({{ $post->comments->count() }} )</a>
                </li>
                <!-- Card share action START -->
                <li class="nav-item dropdown ms-sm-auto">
                    <a class="nav-link mb-0" href="#" id="cardShareAction" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-reply-fill flip-horizontal ps-1"></i>Share (3)
                    </a>
                    <!-- Card share action dropdown menu -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction">
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Send via
                                Direct Message</a></li>
                        <li><a class="dropdown-item" href="#"> <i
                                    class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                            </a></li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                post</a></li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share post
                                via
                                …</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-pencil-square fa-fw pe-2"></i>Share
                                to
                                News Feed</a></li>
                    </ul>
                </li>
                <!-- Card share action END -->
            </ul>
            <!-- Feed react END -->

            <!-- Add comment -->
            <div class="d-flex mb-3">
                <div class="avatar avatar-xs me-2">
                    <img class="avatar-img rounded-circle"
                        src="{{ auth()->user()->image ? asset('assets/images/users/' . auth()->user()->image) : asset('assets/images/avatar/07.jpg') }}">
                </div>
                <form class="w-100 position-relative" onsubmit="submitModalComment(event)"
                    data-post-id="{{ $post->id }}">
                    <textarea class="form-control pe-5 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                    <button type="submit"
                        class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent px-3">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>

            <!-- Comment wrap START -->
            <ul class="comment-wrap list-unstyled">

                @foreach ($post->comments->where('parent_id', null)->take(3) as $comment)
<li class="comment-item mb-3" id="comment-{{ $comment->id }}">
    <div class="d-flex">
        <div class="avatar avatar-xs me-2">
            <img class="avatar-img rounded-circle" src="{{ $comment->user->image ? asset('assets/images/users/'.$comment->user->image) : asset('assets/images/avatar/07.jpg') }}">
        </div>
        <div class="w-100">
            <div class="bg-light p-2 rounded">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-0 small fw-bold">{{ $comment->user->username }}</h6>
                    <div class="dropdown">
                        <i class="bi bi-three-dots cursor-pointer" data-bs-toggle="dropdown"></i>
                        <ul class="dropdown-menu">
                            @if(auth()->id() == $comment->user_id)
                                <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteComment({{ $comment->id }})">Delete</a></li>
                            @endif
                            <li><a class="dropdown-item" href="#">Report</a></li>
                        </ul>
                    </div>
                </div>
                <p class="small mb-0">{{ $comment->comment }}</p>
            </div>
            
            <ul class="nav nav-divider py-1 small">
    <li class="nav-item">
        <a class="nav-link p-0 pe-2" href="javascript:void(0)" onclick="likeComment({{ $comment->id }})" id="like-comment-{{ $comment->id }}">
            <i class="bi {{ $comment->isLikedByAuth() ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i> 
            <span>{{ $comment->likes_count ?? 0 }} Like</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link p-0 pe-2" href="javascript:void(0)" onclick="showReplyInput({{ $comment->id }})">Reply</a>
    </li>
    <li class="nav-item text-secondary">{{ $comment->created_at->diffForHumans() }}</li>
</ul>

            <div class="ms-4 mt-2 ps-3">
    @if($comment->replies->count() > 0)
        <button class="btn btn-link btn-sm text-secondary p-0 mb-2 small" 
                onclick="toggleReplies({{ $comment->id }})" 
                id="btn-replies-{{ $comment->id }}">
            <i class="bi bi-plus"></i> View {{ $comment->replies->count() }} replies
        </button>
    @endif

    <div class="reply-container d-none" id="replies-container-{{ $comment->id }}">
        @foreach($comment->replies as $reply)
            <div class="d-flex mb-2" id="comment-{{ $reply->id }}">
                <div class="avatar avatar-xs me-2">
                    <img class="avatar-img rounded-circle" style="width:25px; height:25px;" 
                         src="{{ $reply->user->image ? asset('assets/images/users/'.$reply->user->image) : asset('assets/images/avatar/07.jpg') }}">
                </div>
                <div class="bg-light p-2 rounded w-100">
                    <h6 class="mb-0 x-small fw-bold">{{ $reply->user->username }}</h6>
                    <p class="small mb-0">{{ $reply->comment }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="reply-input-box mt-2 d-none" id="reply-box-{{ $comment->id }}">
        <form onsubmit="submitReply(event, {{ $post->id }}, {{ $comment->id }})">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Write a reply...">
                <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i></button>
            </div>
        </form>
    </div>
</div>
        </div>
    </div>
</li>
@endforeach

                @if ($post->comments->count() > 3)
                    <div class="card-footer border-0 py-0">
                        <!-- Load more comments -->
                        <a onclick="openCommentsModal({{ $post->id }})" href="#!" role="button"
                            class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center"
                            data-bs-toggle="button" aria-pressed="true">
                            <div class="spinner-dots me-2">
                                <span class="spinner-dot"></span>
                                <span class="spinner-dot"></span>
                                <span class="spinner-dot"></span>
                            </div>
                            Load more comments
                        </a>
                    </div>
                @endif

            </ul>
            <!-- Comment wrap END -->
        </div>

    </div>

    <!-- Modal for viewing all comments -->
    <div class="modal fade" id="commentsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul id="modal-comments" class="list-unstyled">
                        <!-- Comments will be loaded here dynamically -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="modal-post-id">
                    <div class="d-flex w-100">
                        <div class="avatar avatar-xs me-2">
                            <img class="avatar-img rounded-circle"
                                src="{{ auth()->user()->image ? asset('assets/images/users/' . auth()->user()->image) : asset('assets/images/avatar/07.jpg') }}">
                        </div>
                        <form class="w-100 position-relative" onsubmit="submitModalComment(event)">
                            <textarea class="form-control pe-5" id="modal-comment-input" placeholder="Add a comment..." rows="1"></textarea>
                            <button type="submit"
                                class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent px-3">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
