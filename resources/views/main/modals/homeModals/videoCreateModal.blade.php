<div class="modal fade" id="feedActionVideo" tabindex="-1" aria-labelledby="feedActionVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="feedActionVideoLabel">Add post video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->

            <!-- Modal feed body START -->
            <div class="modal-body">

                <form id="videoPostForm">

                    <div class="d-flex mb-3">
                        <textarea name="caption" class="form-control pe-4 fs-3 lh-1 border-0" rows="2"
                            placeholder="Share your thoughts..."></textarea>
                    </div>

                    <label class="form-label">Upload video</label>

                    <div id="videoDropzone" class="dropzone card shadow-none">
                        <div class="dz-message">
                            <i class="bi bi-camera-reels display-3"></i>
                            <p>Drag here or click to upload video.</p>
                        </div>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button type="submit" form="videoPostForm" class="btn btn-success">
                    Post
                </button>
            </div>
        </div>
    </div>
</div>
