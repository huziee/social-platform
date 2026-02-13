<!-- Modal Edit Post -->
    <div class="modal fade" id="modalEditPost" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editPostForm">
                    <input type="hidden" id="edit_post_id">

                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <input type="text" id="edit_caption" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Images</label>

                        <div class="row g-3" id="editPostImage">
                            <!-- images injected here -->
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger-soft" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success-soft" onclick="updatePost()">Update</button>
            </div>

        </div>
    </div>
</div>