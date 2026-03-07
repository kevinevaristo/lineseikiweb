<?php $this->load->view('templates/css_link'); ?>
<style>
    .image {
        display: flex;
        flex-direction: column;
    }

    .image p {
        margin-left: 8px;
        font-size: 12px;
    }
</style>

<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">General Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>
            
            <div class="row justify-content-center">
                <div class="card col-xl-8 col-lg-4 col-md-6 col-12 ml-2">
                    <form action="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="form-group" style="margin-bottom: 40px">
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Company Name</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="update_comp_name" id="update_comp_name" value="">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3">
                                    <label for="">Login Form Logo</label>
                                </div>

                                <div class="col-9">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="update_login_logo" name="update_login_logo" multiple="" accept=".jpg, .jpeg, .png" onchange="updateFileName(this)">
                                            <label class="custom-file-label" id="preview_login_logo" for="update_login_logo">Choose file
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-1 image">
                                        <img style="width:160px; object-fit:contain" src="wala pa">
                                        <p>Will be used in login form</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 float-right">
                                <button class="btn w-100 btn-primary btn-block " id="update_btn" type="submit">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>
<script>
    function updateFileName(input) {
        var fileName    = input.files[0].name;
        var label       = document.getElementById("preview_login_logo");
        label.innerHTML = fileName;
    }
</script>