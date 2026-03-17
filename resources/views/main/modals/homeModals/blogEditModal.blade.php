<div class="modal fade" id="modalEditBlog" tabindex="-1" aria-labelledby="modalLabelEditBlog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelEditBlog">Edit blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-4" id="blogEditForm" enctype="multipart/form-data">
                    <input type="hidden" name="blog_id" id="edit_blog_id">
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="edit_blog_title" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" id="edit_blog_category" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_blog_description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Start date</label>
                        <input type="date" name="start_date" id="edit_blog_start_date" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">End date</label>
                        <input type="date" name="end_date" id="edit_blog_end_date" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" id="edit_blog_location" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="blogEditForm" class="btn btn-success-soft">Save changes</button>
            </div>
        </div>
    </div>
</div>
