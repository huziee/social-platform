<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadStories();

        const fileInput = document.getElementById('storyInput');
        fileInput.addEventListener('change', function() {
            if (this.files.length === 0) return;
            const formData = new FormData();
            
            for(let i = 0; i < this.files.length; i++) { 
                formData.append('media[]', this.files[i]);
            }
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/stories/upload',{
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Good practice for Laravel
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    loadStories();
                    fileInput.value = '';
                }
            })
            .catch(err => console.error('upload error:', err));
        });
    });

    function loadStories() {
    const wrapper = document.getElementById('stories-wrapper');
    
    fetch('/get-stories')
    .then(res => res.json())
    .then(data => {
        // Clear the wrapper before re-initializing
        wrapper.innerHTML = ''; 

        // 1. Convert Laravel data to Zuck Format
        let timelineStories = [];

        Object.values(data).forEach(userStories => {
            const firstStory = userStories[0];
            const user = firstStory.user;

            timelineStories.push({
                id: `user-${user.id}`,
                photo: user.avatar || firstStory.media_path,
                name: user.username,
                link: "",
                lastUpdated: new Date(firstStory.created_at).getTime() / 1000,
                items: userStories.map(story => ({
                    id: `story-${story.id}`,
                    type: story.type === 'video' ? 'video' : 'photo',
                    length: story.type === 'video' ? 0 : 5, // 0 means auto-detect video length
                    src: story.media_path,
                    preview: story.type === 'video' ? '' : story.media_path,
                    time: new Date(story.created_at).getTime() / 1000
                }))
            });
        });

        // 2. Initialize Zuck
        // We target 'stories-wrapper' to inject the circles
        const stories = new Zuck(wrapper, {
            backNative: true,
            previousTap: true,
            skin: 'snapgram', // Your requested style
            autoFullScreen: false,
            avatars: true,
            list: false,
            cubeEffect: true,
            localStorage: true,
            stories: timelineStories
        });
    });
}

// Helper to handle the "time ago" string
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const seconds = Math.floor((new Date() - date) / 1000);
    if (seconds < 60) return 'Just now';
    if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
    return Math.floor(seconds / 3600) + 'h ago';
}

    function openViewer(stories) {
        const content = document.getElementById('storyContent');
        const first = stories[0];
        
        content.innerHTML = first.type === 'video' 
            ? `<video src="${first.media_path}" controls autoplay style="max-width:100%"></video>`
            : `<img src="${first.media_path}" style="max-width:100%">`;
            
        new bootstrap.Modal(document.getElementById('storyModal')).show();
    }
</script>