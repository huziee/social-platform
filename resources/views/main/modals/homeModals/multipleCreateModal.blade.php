<div class="modal fade" id="feedActionMultiple" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="multiplePostForm" class="w-100">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Add post photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div>
                            <textarea name="caption" class="form-control px-1 py-1 fs-4 lh-1 border-0" rows="2"
                                placeholder="Share your thoughts..."></textarea>
                        </div>
                        <div class="mt-3">
                            <div class="dropzone card shadow-none" id="multiplePostDropzone">
                                <div class="dz-message">
                                    <i class="bi bi-images display-3"></i>
                                    <p>Drag here or click to upload Multiple stuff</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger-soft" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success-soft">Post</button>
                    </div>

                </form>

            </div>
        </div>
    </div>