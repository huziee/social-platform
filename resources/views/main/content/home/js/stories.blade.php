<script>
    // Keep a global reference to the Zuck instance
    let zuckInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        loadStories();

        const fileInput = document.getElementById('storyInput');
        fileInput.addEventListener('change', function() {
            if (this.files.length === 0) return;

            const formData = new FormData();
            for (let i = 0; i < this.files.length; i++) {
                formData.append('media[]', this.files[i]);
            }
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/stories/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Refresh stories without a full page reload
                        loadStories();
                        fileInput.value = '';
                    }
                })
                .catch(err => console.error('Upload error:', err));
        });
    });



    function loadStories() {

        // fetch('/get-stories')
        // .then((response) => response.json())
        // .then(res => {
        //     console.log(res)
        // })
        const wrapper = document.getElementById('stories-wrapper');

        fetch('/get-stories')
            .then(res => res.json())
            .then(data => {
                // 1. DATA MAPPING (Same as before)
                let timelineStories = Object.values(data).map(userStories => {
                    const firstStory = userStories[0];
                    const user = firstStory.user;
                    return {
                        id: `user-${user.id}`,
                        photo: user.avatar || firstStory.media_path,
                        name: user.username,
                        link: "",
                        lastUpdated: Math.floor(new Date(firstStory.created_at).getTime() / 1000),
                        items: userStories.map(story => ({
                            id: `story-${story.id}`,
                            type: story.type === 'video' ? 'video' : 'photo',
                            length: story.type === 'video' ? 0 : 5,
                            src: story.media_path,
                            preview: story.media_path,
                            link: story.user_id === {{ auth()->id() }} ?
                                `#delete-${story.id}` :
                                "",
                            linkText: story.user_id === {{ auth()->id() }} ?
                                "🗑" :
                                "",
                            time: Math.floor(new Date(story.created_at).getTime() / 1000),
                            seen: false
                        }))
                    };
                });

                // 2. STUBBORN CLEANUP
                // Zuck adds a modal container to the <body>. We must remove it or the second click fails.
                const oldModal = document.getElementById('zuck-modal');
                if (oldModal) {
                    oldModal.remove();
                }

                // Clear the wrapper UI
                wrapper.innerHTML = '';

                // 3. INITIALIZE
                // We create a fresh instance every time
                zuckInstance = new Zuck(wrapper, {
                    backNative: false,
                    previousTap: true,
                    skin: 'snapgram',
                    autoFullScreen: false,
                    avatars: true,
                    list: false,
                    cubeEffect: true,
                    openEffect: true,
                    avatars: true, // shows user photo instead of last story item preview
                    localStorage: true,
                    stories: timelineStories
                });
            })
            .catch(err => console.error('Load error:', err));
    }

    document.addEventListener('click', function(e) {

        const link = e.target.closest('a');

        if (link && link.getAttribute('href')?.startsWith('#delete-')) {

            e.preventDefault(); // 🚫 stop blank page

            const id = link.getAttribute('href').replace('#delete-', '');

            if (!confirm('Delete this story?')) return;

            fetch(`/delete-stories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {

                        // Close story viewer
                        const modal = document.getElementById('zuck-modal');
                        if (modal) modal.style.display = 'none';

                        loadStories(); // refresh stories
                    }
                })
                .catch(err => console.error(err));
        }

    });
    document.addEventListener('click', function (e) {

    const avatar = e.target.closest('.open-user-story');

    if (!avatar) return;

    e.preventDefault();

    const userId = avatar.dataset.userId;

    if (!zuckInstance) return;

    const storyId = `user-${userId}`;

    // 🔥 Find story element rendered by Zuck
    const storyEl = document.querySelector(
        `#stories-wrapper [data-id="${storyId}"]`
    );

    if (storyEl) {
        storyEl.click(); // ✅ triggers Zuck's internal handler
    } else {
        console.warn('Story not found:', storyId);
    }

});
</script>
