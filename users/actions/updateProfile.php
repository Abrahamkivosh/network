<?php

function updateProfile($dbSocket, $user, $firstname, $lastname, $email, $workphone, $mobilephone, $company, $city, $state)
{
    $errors = array();
    // validate user input
    $firstname = $dbSocket->escapeSimple($firstname);
    $lastname = $dbSocket->escapeSimple($lastname);
    $email = $dbSocket->escapeSimple($email);
    $workphone = $dbSocket->escapeSimple($workphone);
    $mobilephone = $dbSocket->escapeSimple($mobilephone);
    $company = $dbSocket->escapeSimple($company);
    $city = $dbSocket->escapeSimple($city);
    $state = $dbSocket->escapeSimple($state);

    if (empty($firstname)) {
        $errors['firstname'] = "Please enter a valid first name";
    }
    if (empty($lastname)) {
        $errors['lastname'] = "Please enter a valid last name";
    }
    if (empty($workphone)) {
        $errors['workphone'] = "Please enter a valid phone number";
    }
    if (empty($mobilephone)) {
        $errors['mobilephone'] = "Please enter a valid phone number";
    }
    if (empty($company)) {
        $errors['company'] = "Please enter a valid company or home or street name";
    }
    if (empty($city)) {
        $errors['city'] = "Please enter a valid location name";
    }
    if (empty($state)) {
        $errors['state'] = "Please enter a valid County name";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@/", $email)) {
        $errors['email'] = "Please enter a valid email";
    }

    if (count($errors) == 0) {
        $updateUserInfo = $user->updateUserInfo($firstname, $lastname, $email, $workphone, $mobilephone, $company, $city, $state);
        $contactperson = $firstname . " " . $lastname;
        $updateUserBillInfo = $user->updateUserBillInfo($contactperson, $company, $email, $workphone, $company, $city, $state);
        if ($updateUserInfo == true && $updateUserBillInfo == true) {


            // return json response
            $response = array(
                "status" => true,
                "message" => "Profile Updated Successfully",
                "data" => []
            );
        } else {

            // return json response
            $response = array(
                "status" => false,
                "message" => "Profile Update Failed",
                "data" => $errors
            );
        }
    } else {

        // return json response
        $response = array(
            "status" => false,
            "message" => "Profile Update Failed",
            "data" =>  $errors
        );
    }

    return  $response;
}

/**
 * Update User Password
 * 
 */

function updatePassword($dbSocket, $user, $currentpassword, $newpassword, $confirmpassword)
{
    $errors = array();
    // validate user input
    $currentpassword = $dbSocket->escapeSimple($currentpassword);
    $newpassword = $dbSocket->escapeSimple($newpassword);
    $confirmpassword = $dbSocket->escapeSimple($confirmpassword);

    if (empty($currentpassword)) {
        $errors['currentpassword'] = "Please enter a valid current password";
    }
    if (empty($newpassword) && empty($confirmpassword)) {
        return true;
    }
  
    if ($newpassword !== $confirmpassword) {
        $errors['confirmpassword'] = "Confirm password does not match new password";
    }

    if (count($errors) == 0) {
        $updateUserPassword = $user->updateUserPassword($currentpassword, $newpassword);
        if ($updateUserPassword == true) {
            $response = array(
                "status" => true,
                "message" => "Password Updated Successfully",
                "data" => []
            );
        } else {
            $response = array(
                "status" => false,
                "message" => "Password Update Failed",
                "data" => $errors
            );
        }
    } else {
        $response = array(
            "status" => false,
            "message" => "Password Update Failed",
            "data" => $errors
        );
    }

    return $response;
}


// combine both functions
function updateProfileAndPassword($dbSocket, $user, $firstname, $lastname, $email, $workphone, $mobilephone, $company, $city, $state, $currentpassword, $newpassword, $confirmpassword)
{
   $response_updateProfile = updateProfile($dbSocket, $user, $firstname, $lastname, $email, $workphone, $mobilephone, $company, $city, $state);
   return json_encode($response_updateProfile);

    $response_updatePassword = updatePassword($dbSocket, $user, $currentpassword, $newpassword, $confirmpassword);
    if ($response_updateProfile['status'] == true && $response_updatePassword['status'] == true) {
        $response = array(
            "status" => true,
            "message" => "Profile or Password Updated Successfully",
            "data" => array(
                "firstname" => $response_updateProfile['data']['firstname'],
                "lastname" => $response_updateProfile['data']['lastname'],
                "email" => $response_updateProfile['data']['email'],
                "workphone" => $response_updateProfile['data']['workphone'],
                "mobilephone" => $response_updateProfile['data']['mobilephone'],
                "company" => $response_updateProfile['data']['company'],
                "city" => $response_updateProfile['data']['city'],
                "state" => $response_updateProfile['data']['state'],
            )
        );
    } else {
        $errors = array_merge($response_updateProfile['data'], $response_updatePassword['data']);
        $response = array(
            "status" => false,
            "message" => "Profile or Password Update Failed",
            "data" => $errors
        );
    }

    return $response;
}

// Path: user_v2/actions/updateProfile.php