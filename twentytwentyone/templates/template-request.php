<?php
/**
 * Template Name: Request
 */

//get_header();

/* Start the Loop */
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Request Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet"
              href="<?php echo get_template_directory_uri() ?>/assets/css/bootstrap-datepicker.min.css"/>

    </head>
    <body>

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-6 m-auto">




                <h3>
                    Requests
                </h3>
                <div class="">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Send Request Form
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop"  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="request-form">
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                               placeholder="First Name">
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="mobile_number" id="mobile_number"
                                               placeholder="Mobile Number">
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                    </div>

                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="national_code" id="national_code"
                                               placeholder="National Code">
                                    </div>

                                    <label for="title">Category</label>
                                    <select class="form-control mb-2" name="types" id="types">
                                        <?php
                                        $args = array(
                                            'taxonomy' => 'types',
                                            'hide_empty' => 0,
                                            'orderby' => 'name',
                                            'order' => 'ASC'
                                        );
                                        $types = get_categories($args);
                                        foreach ($types as $type):
                                            print_r($type);
                                            ?>
                                            <option value="<?php echo $type->term_id ?>"><?php echo $type->name; ?></option>
                                        <?php endforeach; ?>

                                    </select>

                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="date" id="date" placeholder="Date">
                                    </div>


                                    <?php
                                    $field = get_field_object('field_62c30a02caa27');
                                    $times = $field['choices'];
                                    ?>
                                    <label for="title">Time</label>
                                    <select class="form-control mb-2" name="time" id="time">
                                        <?php
                                        foreach ($times as $timeKey => $timeValue):
                                            ?>
                                            <option value="<?php echo $timeKey ?>"><?php echo $timeValue; ?></option>
                                        <?php endforeach ?>
                                    </select>

                                    <label for="title">Description</label>
                                    <div class="form-group mb-2">
                                     <textarea class="form-control" name="description" id="description" cols="30"
                                  rows="10"></textarea>
                                    </div>
                                    <div id="response" class="my-2"></div>

                                    <button type="submit" id="sendRequestBtn" onclick="" class="btn btn-primary mt-2">Submit</button>

                                    <?php wp_nonce_field('request_nonce_action', 'request_nonce_field'); ?>


                                </form>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="<?php echo get_template_directory_uri() ?>/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo get_template_directory_uri() ?>/assets/js/bootstrap-datepicker.fa.min.js"></script>
    <script>

        //Date Picker
        $(document).ready(function () {
            $("#date").datepicker({
                dateFormat: "yy/m/d"
            });
        });


        //Send Request
        jQuery(document).ready(function () {
            jQuery("#sendRequestBtn").click(function (e) {
                var formdata = jQuery("#request-form").serialize();
                formdata += "&action=send_request";
                e.preventDefault();
                nonce = jQuery(this).attr("request_nonce_action");
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: "<?php echo admin_url('admin-ajax.php')?>",
                    data: formdata,
                    success: function (response) {
                        jQuery("#response").html('');
                        console.log(response.success);
                        if (response.success == true) {
                            jQuery("#response").attr('class', 'text-success');
                            jQuery("#response").html(response.message);
                        } else {
                            $(response.message).each(function (index, value) {
                                jQuery("#response").attr('class', 'text-danger');
                                jQuery("#response").append(value + "<br />");
                            });
                        }
                    }
                });
            });
        });


    </script>

    </body>
    </html>


<?php
//get_footer();
