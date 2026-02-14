<div class="d-flex gap-2 mb-n3">
    <div class="position-relative">
        <div class="card border border-2 border-dashed h-150px px-4 px-sm-5 shadow-none d-flex align-items-center justify-content-center text-center">
            <div>
                <input type="file" id="storyInput" hidden multiple accept="image/*,video/*">
                <a class="stretched-link btn btn-light rounded-circle icon-md" href="javascript:void(0)"
                    onclick="document.getElementById('storyInput').click();">
                    <i class="fa-solid fa-plus"></i>
                </a>
                <h6 class="mt-2 mb-0 small">Post Stories</h6>
            </div>
        </div>
    </div>

    <div id="stories-wrapper" class="storiesWrapper scroll-enable"></div>
</div>

<div id="zuck-modal" class="with-cube with-effects" tabindex="1" style="display: none;">
    <div id="zuck-modal-content"></div>
</div>