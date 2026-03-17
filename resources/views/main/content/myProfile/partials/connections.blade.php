<div class="card">
    <div class="card-header border-0 pb-0">
        <h5 class="card-title">Connections</h5>
    </div>
    <div class="card-body">
        @if(isset($followRequests) && $followRequests->count())
            <div class="mb-4">
                <h6 class="mb-3">Follow requests</h6>
                @foreach ($followRequests as $request)
                    @php $requester = $request->requester; @endphp
                    @if($requester)
                        <div class="d-md-flex align-items-center mb-3" data-follow-request-user-id="{{ $requester->id }}">
                            <div class="avatar me-3 mb-2 mb-md-0">
                                <a href="{{ route('user.profile', $requester->username) }}">
                                    <img class="avatar-img rounded-circle"
                                         src="{{ $requester->image ? asset('assets/images/users/' . $requester->image) : asset('assets/images/avatar/placeholder.jpg') }}"
                                         alt="">
                                </a>
                            </div>
                            <div class="w-100">
                                <h6 class="mb-0">
                                    <a href="{{ route('user.profile', $requester->username) }}">
                                        {{ $requester->first_name }} {{ $requester->last_name }}
                                    </a>
                                </h6>
                                <p class="small mb-0 text-muted">{{ $requester->username }}</p>
                            </div>
                            <div class="ms-md-auto d-flex">
                                <button class="btn btn-success-soft btn-sm me-2"
                                    onclick="acceptFollowRequest({{ $requester->id }}, this)">Accept</button>
                                <button class="btn btn-danger-soft btn-sm"
                                    onclick="declineFollowRequest({{ $requester->id }}, this)">Decline</button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <hr>
        @endif

        @forelse($followers as $follower)
            <div class="d-md-flex align-items-center mb-4" data-connection-user-id="{{ $follower->id }}">
                <div class="avatar me-3 mb-3 mb-md-0">
                    <a href="{{ route('user.profile', $follower->username) }}">
                        <img class="avatar-img rounded-circle" 
                             src="{{ $follower->image ? asset('assets/images/users/' . $follower->image) : asset('assets/images/avatar/placeholder.jpg') }}" 
                             alt="">
                    </a>
                </div>
                <div class="w-100">
                    <div class="d-sm-flex align-items-start">
                        <h6 class="mb-0">
                            <a href="{{ route('profile.index', $follower->username) }}">
                                {{ $follower->first_name }} {{ $follower->last_name }}
                            </a>
                        </h6>
                        <p class="small ms-sm-2 mb-0">{{ $follower->job_title ?? 'Community Member' }}</p>
                    </div>
                    <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
                        <li class="small">
                            {{-- Assuming you have a mutual count logic, otherwise show total followers --}}
                            <span data-followers-count data-user-id="{{ $follower->id }}">{{ $follower->followers()->count() }}</span> followers
                        </li>
                    </ul>
                </div>
                <div class="ms-md-auto d-flex">
                    <button class="btn btn-danger-soft btn-sm mb-0 me-2" data-remove-row="1"
                        onclick="removeFollower({{ $follower->id }}, this)"> 
                        Remove 
                    </button>
                    <a href="{{ route('messages.show', ['id' => $follower->id]) }}" class="btn btn-primary-soft btn-sm mb-0"> 
                        Message 
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <p class="text-muted">You don't have any connections yet.</p>
            </div>
        @endforelse
    </div>
</div>

