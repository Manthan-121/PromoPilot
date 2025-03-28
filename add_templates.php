<?php
include_once("./includes/config.php");
include(__DIR__ . "/includes/auth.php");
include(__DIR__ . "/includes/header.php");
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="pt-4 pr-4 pl-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Create Templates</h4>
            </div>
            <div class="card-body">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                    <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric">
                            <option>Tech</option>
                            <option>News</option>
                            <option>Political</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                    <div class="col-sm-12 col-md-7">
                        <textarea class="summernote"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Publish</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "./includes/footer.php";
?>