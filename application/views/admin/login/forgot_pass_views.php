<!doctype html>

<html lang="en" style='height:100%'>

<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eyebox HRMS Forgot Password</title>

    <!-- Google Font: Source Sans Pro -->

    <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/google-fonts/source-sans-pro/source-sans-pro.css'); ?>">

    <!-- Font Awesome -->

    <!--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">-->
    <!--<link rel="shortcut icon" href="<?=base_url()?>images/system/favicon.ico" type="image/x-icon">-->
    <!-- icheck bootstrap -->

    <!--<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">-->

    <!-- Theme style -->

    <!--<link rel="stylesheet" href="../../dist/css/adminlte.min.css">-->



    <?php $this->load->view('templates/css_link'); ?>
    <link rel="stylesheet" href="sweetalert2.min.css">
</head>

<body class="hold-transition login-page" style='height:100%;'>

    <div class="login-box">

        <div class="card card-outline card-success">

            <div class="card-header text-center">
                <?php /* Removed tbl_system_setup dependency - using default logo */ ?>
                <img class="logo_bandai" src="<?= base_url(); ?>assets_system/images/header_logo.png" alt="" width="240">

            </div>

            <div class="card-body">

                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                <form action="<?php echo base_url('panel_72c81/send_email'); ?>" id="login_form" method="POST" accept-charset="utf-8" autocomplete='off'>

                    <div class="input-group mb-3">

                        <!--<input type = "email" name = "user_email" class="form-control" placeholder="Email"  required>-->
                        <input type = "text" name = "user_name" class="form-control" placeholder="Username"  required>
                        <div class="input-group-append">

                            <div class="input-group-text">

                                <!--<span class="fas fa-envelope"></span>-->
                                <span class="fas fa-user"></span>
                                

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">

                            <button type = "submit" name = "btn_send" class="btn btn-success btn-block">Request new password</button>

                        </div>

                        <!-- /.col -->

                    </div>

                </form>

                <p class="mt-3 mb-1">

                    <a  href="<?=base_url();?>panel_72c81">Login</a>

                </p>

            </div>

            <!-- /.login-card-body -->

        </div>

    </div>

    <!-- /.login-box -->

    <!-- jQuery -->

   

    <!-- Bootstrap 4 -->

    <!--<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>-->

    <!-- AdminLTE App -->
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
   
    <script>
       <?php if( $this->session->flashdata('success')){ ?>
        Swal.fire(
          'Success!',
          "<?=$this->session->flashdata('success')?>",
          'success'
        )
        
    <?php } ?>
    </script>
    
    <script src="<?php echo base_url('assets_system/vendor/jquery/jquery-3.7.0.min.js'); ?>"></script>
    <script type="text/javascript"
        src="<?php echo base_url('assets_system/vendor/emailjs/email.min.js'); ?>">
    </script>
    <script>
        $(document).ready(function(){
            $('#login_form').on('submit',function(e){
            $.post($(this).attr('action'), $(this).serialize(), function(res) {
                let userEmail   = res['col_empl_emai'];
                let userId      = res['id'];
                let sessCode    = res['sess'];
                if(userEmail){
                    emailjs.init("XgD4wvsnmYlIx0lZr");    
                    var email_to=$('#to_email').val();
                  emailjs.send("service_j9l3w5q", "template_5vjja1d", {
                        to_email: userEmail,
                        subject: 'Password',
                        link:"<?=base_url('panel_72c81/user_new_password?')?>"+'user='+userId+'&sess='+sessCode
                        
                    }).then(function(response) {
                        $.post("<?=base_url('panel_72c81/add_session')?>",{empl_id:userId,code:sessCode},function(res){
                            console.log(res);
                        },'json')
                        Swal.fire(
                          'Success!',
                          "We have sent a link to the email address associated with this account",
                          'success'
                        )
                        // console.log(response)
                    }).catch((error)=>{
                        Swal.fire(
                          '',
                          "Somthing went wrong",
                          'error'
                        )
                    })
                    ;
                }
                else{
                    alert('no email found in this userId')
                }
          },'json');
              return false;
            })
        })
    </script>

</body>

</html>