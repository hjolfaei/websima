<?php

add_action('wp_ajax_send_request', 'hanlde_custom_ajax');
add_action('wp_ajax_nopriv_send_request', 'hanlde_custom_ajax');
function hanlde_custom_ajax()
{

    if (isset($_POST['request_nonce_field'])
        && wp_verify_nonce($_POST['request_nonce_field'], 'request_nonce_action')) {


        $titleValue = $_POST['title'];

        $categoryValue = $_POST['types'];

        $firstNameKey = "field_62c2a3aa65bc7";
        $firstNameValue = $_POST['first_name'];

        $lastNameKey = "field_62c2a53fba7d5";
        $lastNameValue = $_POST['last_name'];

        $mobileNumberKey = "field_62c2a554ba7d6";
        $mobileNumberValue = $_POST['mobile_number'];

        $emailKey = "field_62c2a781ba7d8";
        $emailValue = $_POST['email'];

        $nationalCodeKey = "field_62c2a76dba7d7";
        $nationalCodeValue = $_POST['national_code'];


        $dateKey = "field_62c2fe553a5c9";
        $convertedDate = new SDate();
        $dateValue = strtotime($convertedDate->convertDate($_POST['date']));


        $timeKey = "field_62c30a02caa27";
        $timeValue = $_POST['time'];

        $descriptionKey = "field_62c2a790ba7d9";
        $descriptionValue = $_POST['description'];


        $requestArgs = array(
            'post_title' => $titleValue,
            'post_status' => 'pending',
            'post_author' => 7,
            'tax_input' => array(
                'types' => $categoryValue
            ),
            'post_type' => 'requests',
        );


        //Validation
        //Because we insert acf data with update_field we most validate form from here
        $errors = array();

        if (empty($titleValue)) {
            $errors[] = "Title required.";
        }
        if (empty($categoryValue)) {
            $errors[] = "Type required.";
        }
        if (empty($firstNameValue)) {
            $errors[] = "Firstname required.";
        }
        if (empty($lastNameKey)) {
            $errors[] = "Lastname required.";
        }
        if (empty($mobileNumberValue)) {
            $errors[] = "Mobile number required.";
        }

        if (empty($emailValue) || !filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email field required/Wrong format.";
        }
        if (empty($nationalCodeValue)) {
            $errors[] = "National code required.";
        }

        if (empty($dateValue)) {
            $errors[] = "Date required.";
        }
        if (empty($timeValue)) {
            $errors[] = "Times required.";
        }

        if (sizeof($errors) == 0) {
            $requestId = wp_insert_post($requestArgs);
            update_field($firstNameKey, $lastNameValue, $requestId);
            update_field($lastNameKey, $firstNameValue, $requestId);
            update_field($mobileNumberKey, $mobileNumberValue, $requestId);
            update_field($emailKey, $emailValue, $requestId);
            update_field($nationalCodeKey, $nationalCodeValue, $requestId);
            update_field($timeKey, $timeValue, $requestId);
            update_field($dateKey, $dateValue, $requestId);
            update_field($descriptionKey, $descriptionValue, $requestId);


            //Tracking code creates from requestId
            $trackingCodeKey = "field_62c2f55f9075e";
            $trackingCodeValue = "WSB" . str_pad($requestId, 8, '0', STR_PAD_LEFT);;
            update_field($trackingCodeKey, $trackingCodeValue, $requestId);

            requestResponse(true, "Request with tracking code '$trackingCodeValue' Submitted.");
        }
        requestResponse(false, $errors);

    }

}

function requestResponse($success, $message)
{
    $response = [
        'success' => $success,
        'message' => $message
    ];
    echo json_encode($response);
    wp_die();
}

