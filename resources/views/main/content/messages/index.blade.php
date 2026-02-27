@extends('main.body.master')

@section('title', 'Messages')


@section('style')
    <style>
        .chat-conversation-content {
            height: 400px;
            /* Or 60vh */
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
    </style>
@endsection
@section('main')
    <div class="container">
        <div class="row gx-0">
            <!-- Sidebar START -->
            <div class="col-lg-4 col-xxl-3" id="chatTabs" role="tablist">

                <!-- Divider -->
                <div class="d-flex align-items-center mb-4 d-lg-none">
                    <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="btn btn-primary"><i class="fa-solid fa-sliders-h"></i></span>
                        <span class="h6 mb-0 fw-bold d-lg-none ms-2">Chats</span>
                    </button>
                </div>
                <!-- Advanced filter responsive toggler END -->
                <div class="card card-body border-end-0 border-bottom-0 rounded-bottom-0">
                    <div class=" d-flex justify-content-between align-items-center">
                        <h1 class="h5 mb-0">Active chats <span class="badge bg-success bg-opacity-10 text-success">6</span>
                        </h1>
                        <!-- Chat new create message item START -->
                        <div class="dropend position-relative">
                            <div class="nav">
                                <a class="icon-md rounded-circle btn btn-sm btn-primary-soft nav-link toast-btn"
                                    data-target="chatToast" href="#"> <i class="bi bi-pencil-square"></i> </a>
                            </div>
                        </div>
                        <!-- Chat new create message item END -->
                    </div>
                </div>

                <nav class="navbar navbar-light navbar-expand-lg mx-0">
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                        <!-- Offcanvas header -->
                        <div class="offcanvas-header">
                            <button type="button" class="btn-close text-reset ms-auto"
                                data-bs-dismiss="offcanvas"></button>
                        </div>

                        <!-- Offcanvas body -->
                        <div class="offcanvas-body p-0">
                            <div class="card card-chat-list rounded-end-lg-0 card-body border-end-lg-0 rounded-top-0">

                                <!-- Search chat START -->
                                <form class="position-relative">
                                    <input class="form-control py-2" type="search" placeholder="Search for chats"
                                        aria-label="Search">
                                    <button
                                        class="btn bg-transparent text-secondary px-2 py-0 position-absolute top-50 end-0 translate-middle-y"
                                        type="submit">
                                        <i class="bi bi-search fs-5"></i>
                                    </button>
                                </form>
                                <!-- Search chat END -->
                                <!-- Chat list tab START -->
                                <div class="mt-4 h-100">
                                    <div class="chat-tab-list custom-scrollbar">
                                        <ul class="nav flex-column nav-pills nav-pills-soft">
                                            @foreach ($users as $user)
                                                <li>
                                                    <a href="{{ route('messages.show', $user->id) }}"
                                                        class="nav-link text-start
                                                          {{ isset($selectedUser) && $selectedUser->id == $user->id ? 'active bg-primary text-white' : '' }}
                                                          {{ $user->unread_count > 0 ? 'bg-warning bg-opacity-25 fw-bold' : '' }}">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar me-2">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="{{ asset('assets/images/users/' . $user->image) ?? asset('assets/images/avatar/07.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                            <div class="flex-grow-1 d-block">
                                                                <h6 class="mb-0 mt-1">
                                                                    {{ $user->first_name }} {{ $user->last_name }}

                                                                    @if ($user->unread_count > 0)
                                                                        <span class="badge bg-danger ms-2">
                                                                            {{ $user->unread_count }}
                                                                        </span>
                                                                    @endif
                                                                </h6>
                                                                <p class="text-muted my-1">{{ $user->username }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- Chat list tab END -->
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- Sidebar START -->

            <!-- Chat conversation START -->
            <div class="col-lg-8 col-xxl-9">
                <div class="card card-chat rounded-start-lg-0 border-start-lg-0">
                    <div class="card-body h-100">
                        <div class="tab-content py-0 mb-0 h-100" id="chatTabsContent">
                            <!-- Conversation item START -->
                            <div class="fade tab-pane show active h-100" id="chat-1" role="tabpanel"
                                aria-labelledby="chat-1-tab">
                                <!-- Top avatar and status START -->
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex mb-2 mb-sm-0">
                                        <div class="d-block flex-grow-1">
                                            @if (isset($selectedUser))
                                                <div class="d-flex mb-2 mb-sm-0">
                                                    <div class="flex-shrink-0 avatar me-2">
                                                        <img class="avatar-img rounded-circle"
                                                            src="{{ asset('assets/images/users/' . $selectedUser->image) ?? asset('assets/images/avatar/07.jpg') }}">
                                                        {{-- {{ $user->image ? asset('assets/images/users/' . $user->image) : asset('assets/images/avatar/07.jpg') }} --}}
                                                    </div>
                                                    <div class="d-block flex-grow-1">
                                                        <h6 class="mb-0 mt-1">{{ $selectedUser->name }}</h6>
                                                        <div class="small text-success">
                                                            <i class="fa-solid fa-circle me-1"></i> Online
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-muted">Select a chat</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <!-- Call button -->
                                        <a href="#!" class="icon-md rounded-circle btn btn-primary-soft me-2 px-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Audio call"><i
                                                class="bi bi-telephone-fill"></i></a>
                                        <a href="#!" class="icon-md rounded-circle btn btn-primary-soft me-2 px-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Video call"><i
                                                class="bi bi-camera-video-fill"></i></a>
                                        <!-- Card action START -->
                                        <div class="dropdown">
                                            <a class="icon-md rounded-circle btn btn-primary-soft me-2 px-2" href="#"
                                                id="chatcoversationDropdown" role="button" data-bs-toggle="dropdown"
                                                data-bs-auto-close="outside" aria-expanded="false"><i
                                                    class="bi bi-three-dots-vertical"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="chatcoversationDropdown">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-check-lg me-2 fw-icon"></i>Mark as read</a></li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-mic-mute me-2 fw-icon"></i>Mute conversation</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-person-check me-2 fw-icon"></i>View profile</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-trash me-2 fw-icon"></i>Delete chat</a></li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-archive me-2 fw-icon"></i>Archive chat</a></li>
                                            </ul>
                                        </div>
                                        <!-- Card action END -->
                                    </div>
                                </div>
                                <!-- Top avatar and status END -->
                                <hr>
                                <!-- Chat conversation START -->
                                <div class="chat-conversation-content" id="chatBox">
                                    @if (isset($selectedUser))
                                        @foreach ($messages as $msg)
                                            @if ($msg->sender_id == auth()->id())
                                                {{-- MY MESSAGE --}}
                                                <div class="d-flex justify-content-end mb-2">
                                                    <div class="bg-primary text-white p-2 px-3 rounded-3">
                                                        {{ $msg->body }}
                                                        <div class="small text-end text-white-50">
                                                            {{ $msg->created_at->format('h:i A') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- OTHER USER MESSAGE --}}
                                                <div class="d-flex mb-2">
                                                    <div class="bg-light p-2 px-3 rounded-3">
                                                        {{ $msg->body }}
                                                        <div class="small text-muted">
                                                            {{ $msg->created_at->format('h:i A') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="text-center mt-5">Select a user to start chatting</div>
                                    @endif
                                </div>
                                <!-- Chat conversation END -->
                            </div>
                            <!-- Conversation item END -->
                            <!-- Conversation item START -->
                            <div class="fade tab-pane h-100" id="chat-2" role="tabpanel"
                                aria-labelledby="chat-2-tab">
                                <!-- Top avatar and status START -->
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex mb-2 mb-sm-0">
                                        <div class="flex-shrink-0 avatar me-2">
                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg"
                                                alt="">
                                        </div>
                                        <div class="d-block flex-grow-1">
                                            <h6 class="mb-0 mt-1">Carolyn Ortiz</h6>
                                            <div class="small text-secondary"><i
                                                    class="fa-solid fa-circle text-danger me-1"></i>Last active 2 days
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <!-- Call button -->
                                        <a href="#!" class="icon-md rounded-circle btn btn-primary-soft me-2 px-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Audio call"><i
                                                class="bi bi-telephone-fill"></i></a>
                                        <a href="#!" class="icon-md rounded-circle btn btn-primary-soft me-2 px-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Video call"><i
                                                class="bi bi-camera-video-fill"></i></a>
                                        <!-- Card action START -->
                                        <div class="dropdown">
                                            <a class="icon-md rounded-circle btn btn-primary-soft me-2 px-2"
                                                href="#" id="chatcoversationDropdown2" role="button"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="chatcoversationDropdown2">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-check-lg me-2 fw-icon"></i>Mark as read</a></li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-mic-mute me-2 fw-icon"></i>Mute conversation</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-person-check me-2 fw-icon"></i>View profile</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-trash me-2 fw-icon"></i>Delete chat</a></li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-archive me-2 fw-icon"></i>Archive chat</a></li>
                                            </ul>
                                        </div>
                                        <!-- Card action END -->
                                    </div>
                                </div>
                                <!-- Top avatar and status END -->
                                <hr>
                                <!-- Chat conversation START -->
                                <div class="chat-conversation-content overflow-auto custom-scrollbar">
                                    <!-- Chat time -->
                                    <div class="text-center small my-2">Jul 16, 2022, 06:15 am</div>
                                    <!-- Chat message left -->
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0 avatar avatar-xs me-2">
                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg"
                                                alt="">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="w-100">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Night signs
                                                        creeping yielding green Seasons.</div>
                                                    <div class="small my-2">6:15 AM</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat message right -->
                                    <div class="d-flex justify-content-end text-end mb-1">
                                        <div class="w-100">
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="bg-primary text-white p-2 px-3 rounded-2">Creeping earth under
                                                    was You're without which image.</div>
                                                <div class="d-flex my-2">
                                                    <div class="small text-secondary">6:20 AM</div>
                                                    <div class="small ms-2"><i
                                                            class="fa-solid fa-check-double text-info"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat message left -->
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0 avatar avatar-xs me-2">
                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg"
                                                alt="">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="w-100">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Thank you for
                                                        prompt response</div>
                                                    <div class="small my-2">12:16 PM</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat message left -->
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0 avatar avatar-xs me-2">
                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg"
                                                alt="">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="w-100">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Won't that fish
                                                        him whose won't also. </div>
                                                    <div class="small my-2">3:22 PM</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat message right -->
                                    <div class="d-flex justify-content-end text-end mb-1">
                                        <div class="w-100">
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="bg-primary text-white p-2 px-3 rounded-2">Moving living second
                                                    beast Over fish place beast.</div>
                                                <div class="d-flex my-2">
                                                    <div class="small text-secondary">5:35 PM</div>
                                                    <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat time -->
                                    <div class="text-center small my-2">2 New Messages</div>
                                    <!-- Chat message left -->
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0 avatar avatar-xs me-2">
                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg"
                                                alt="">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="w-100">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="bg-light text-secondary p-2 px-3 rounded-2">Thing they're
                                                        fruit together forth day.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat message left -->
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0 avatar avatar-xs me-2">
                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg"
                                                alt="">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="w-100">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="bg-light text-secondary p-2 px-3 rounded-2">
                                                        Fly replenish third to said void life night yielding for heaven give
                                                        blessed spirit.</div>
                                                    <div class="small my-2">9:30 PM</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Chat conversation END -->
                            </div>
                            <!-- Conversation item END -->
                        </div>
                    </div>
                    <div class="card-footer">
                        @if (isset($selectedUser))
                            <form id="chatForm">
                                @csrf
                                <div class="d-sm-flex align-items-end">
                                    <textarea id="messageInput" name="body" class="form-control mb-sm-0 mb-3" placeholder="Type a message"
                                        rows="1"></textarea>
                                    <button type="submit" class="btn btn-primary ms-2">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center text-muted">Select a user to start chatting</div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Chat conversation END -->
        </div> <!-- Row END -->
        <!-- =======================
                Chat END -->

    </div>

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Use $(document).on to ensure the event stays attached even if DOM changes
        $(document).on('submit', '#chatForm', function(e) {
            e.preventDefault();
            console.log("Form submitted!"); // Debugging line

            let message = $('#messageInput').val().trim();
            let receiverId = "{{ $selectedUser->id ?? '' }}";

            if (!message || !receiverId) {
                console.error("Missing message or receiver ID");
                return;
            }

            $.ajax({
                url: "{{ route('messages.send') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    receiver_id: receiverId,
                    body: message
                },
                success: function(response) {
                    let newMsg = `
                <div class="d-flex justify-content-end mb-2">
                    <div class="bg-primary text-white p-2 px-3 rounded-3">
                        ${response.body}
                        <div class="small text-end text-white-50">Just now</div>
                    </div>
                </div>`;

                    $('#chatBox').append(newMsg);
                    $('#messageInput').val('');
                    let chatBox = $('#chatBox');
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Error: " + xhr.status + " - " + xhr.statusText);
                }
            });
        });
    </script>
@endsection
