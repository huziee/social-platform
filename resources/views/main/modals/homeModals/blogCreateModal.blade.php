<div class="modal fade" id="modalCreateBlog" tabindex="-1" aria-labelledby="modalLabelCreateBlog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal feed header START -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelCreateBlog">Create blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal feed header END -->
                <!-- Modal feed body START -->
                <div class="modal-body">
                    <!-- Form START -->
                    <form class="row g-4" id="blogCreateForm" enctype="multipart/form-data">
                        <!-- Title -->
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Blog title" required>
                        </div>
                        <!-- Category -->
                        <div class="col-12">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" placeholder="Lifestyle">
                        </div>
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2"
                                placeholder="Ex: topics, schedule, etc."></textarea>
                        </div>
                        <!-- Dates -->
                        <div class="col-sm-6">
                            <label class="form-label">Start date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">End date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                        <!-- Location -->
                        <div class="col-12">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Logansport, IN 46947">
                        </div>
                        <!-- Image -->
                        <div class="col-12">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </form>
                    <!-- Form END -->
                </div>
                <!-- Modal feed body END -->
                <!-- Modal footer -->
                <!-- Button -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal">
                        Cancel</button>
                    <button type="submit" form="blogCreateForm" class="btn btn-success-soft">Create now</button>
                </div>
            </div>
        </div>
    </div>
