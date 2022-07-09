<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Print <?php the_title(); ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    </head>
<body>
<div class="container">
    <div class="row">
    <div class="col  mt-5">

<?php

while (have_posts()) :
    the_post();
    $convertedDate = new SDate();
    $dateValue = $convertedDate->jdate('Y-m-d', get_field('request_date'), '', 'en');
    $dateValue = $convertedDate->persianToLatinNumber($dateValue);
    ?>

    <h3>
        <?php the_title(); ?>
    </h3>

    <table class="table table-bordered">

        <tbody>
        <tr>
            <th>First Name</th>
            <td><?php the_field('request_first_name'); ?></td>

        </tr>
        <tr>
            <th>Last Name</th>
            <td><?php the_field('request_last_name'); ?></td>
        </tr>
        <tr>
            <th>Mobile Number</th>
            <td><?php the_field('request_mobile_number'); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php the_field('request_email'); ?></td>
        </tr>
        <tr>
            <th>National Code</th>
            <td><?php the_field('request_national_code'); ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?php echo $dateValue ?></td>
        </tr>
        <tr>
            <th>Time</th>
            <td><?php the_field('request_time'); ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?php the_field('request_description'); ?></td>
        </tr>
        <tr>
            <th>Tracking Code</th>
            <td><?php the_field('request_tracking_code'); ?></td>
        </tr>
        </tbody>
    </table>


    <button onclick="window.print();" class="noPrint">
        Print
    </button>

    </div>
    </div>
    </div>
    </body>
    </html>


<?php
endwhile; // End of the loop.
