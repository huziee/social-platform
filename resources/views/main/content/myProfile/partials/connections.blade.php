<div class="card">
    <div class="card-header border-0 pb-0">
        <h5 class="card-title">Connections</h5>
    </div>
    <div class="card-body">
        @forelse($followers as $follower)
            <div class="d-md-flex align-items-center mb-4">
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
                            {{ $follower->followers()->count() }} followers
                        </li>
                    </ul>
                </div>
                <div class="ms-md-auto d-flex">
                    <button class="btn btn-danger-soft btn-sm mb-0 me-2" onclick="toggleFollow({{ $follower->id }}, this)"> 
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

@section('script') 
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>
  $(document).ready(function() {
    // Check if a specific section was passed from the controller
    const activeSection = "{{ $section ?? 'about' }}";
    showSection(activeSection);

    $('.nav-link').on('click', function(e) {
        // Get the ID from href (e.g., #connections)
        const targetId = $(this).attr('href').substring(1);
        
        if (['about', 'posts', 'connections'].includes(targetId)) {
            e.preventDefault();
            showSection(targetId);
            
            // Update URL hash without refreshing
            window.location.hash = targetId;
        }
    });

    function showSection(sectionId) {
    // 1. Hide all sections
    $('.profile-section').addClass('d-none');
    
    // 2. Show the specific section
    $('#' + sectionId).removeClass('d-none');
    
    // 3. Handle Navigation styling
    $('.nav-link').removeClass('active');
    // This finds the link by the hash in the href
    $(`.nav-link[href="#${sectionId}"]`).addClass('active');
    
    // 4. Handle "Connections" data load if necessary
    if (sectionId === 'connections') {
        console.log("Connections tab active");
    }
}

function toggleFollow(userId, btn) {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: `/follow/${userId}`,
        method: 'POST',
        data: {
            _token: csrfToken
        },
        success: function(response) {
            // If we are on our own "Connections" page, we usually want to remove the row
            $(btn).closest('.d-md-flex').fadeOut(300, function() {
                $(this).remove();
                
                // Optional: Update the badge count in the tab
                let badge = $('.nav-link[href="#connections"] .badge');
                let currentCount = parseInt(badge.text());
                badge.text(currentCount - 1);
            });
        },
        error: function(err) {
            console.error("Follow toggle failed", err);
        }
    });
}
});
</script>

@endsection