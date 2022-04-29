<?php
session_start();
include 'src/common/db_conn.php';
// include 'common/common.php';
// $password = 'M@trix@9090';
// echo hash('sha256', $password.$salt);
if($_REQUEST['type'] == 'logout'){
    session_destroy();
    header('Location: '.$login_url);
}

if($_REQUEST['delete_record']){
    $table_name = $_REQUEST['delete_record'];
    $id = $_REQUEST['id'];
    $sql = "UPDATE ".$table_name." SET status = 0 WHERE id = '$id'";
    if($conn->query($sql)){
        echo "success";die;
    }else{
        echo "error";die;
    }
}

if($_REQUEST['type'] == 'delete_entry'){
    $table_name = $_REQUEST['table_name'];
    $id = $_REQUEST['id'];
    $sql = "UPDATE ".$table_name." SET status = '0' WHERE id = '$id'";
    if($conn->query($sql)){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
        header('Location: /');
    }
}

if($_REQUEST['type'] == 'update_invoice_status'){
    $receipt_id = $_REQUEST['r_id'];
    $status = $_REQUEST['status'];
    $sql = "UPDATE rentre_invoice SET status = '$status' WHERE receipt_id = '$receipt_id'";
    if($conn->query($sql)){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
        header('Location: /');
    }
}

if($_REQUEST['type'] == 'update_signature'){
    $user_id = $_SESSION['id'];
    $signature = $_REQUEST['signature'];
    $sql = "UPDATE rentre_user_details SET signature = '$signature' WHERE user_id = '$user_id'";
    if($conn->query($sql)){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;die;
        header('Location: /');
    }
}

if($_REQUEST['type'] == 'save_receipt'){
    try {
      $user_id = $_SESSION['id'];
      $r_id = $_REQUEST['r_id'];
      $property_id = $_REQUEST['property_id'];
      $tenant_id = $_REQUEST['tenant_id'];
      $total_amount = $_REQUEST['total_amount'];
      $rent = $_REQUEST['rent'];
      $rent_duration = $_REQUEST['rent_duration'];
      $no_of_days = $_REQUEST['no_of_days'];
      $elec_amount = $_REQUEST['elec_amount'];
      $elec_units = $_REQUEST['elec_units'];
      $elec_cost_p_u = $_REQUEST['elec_cost_p_u'];
      $water_amount = $_REQUEST['water_amount'];
      $extra_amount = $_REQUEST['extra_amount'];
      $extra_comment = $_REQUEST['extra_comment'];
      $deduct_amount = $_REQUEST['deduct_amount'];
      $deduct_comment = $_REQUEST['deduct_comment'];
      $bank_details = json_encode($_REQUEST['bank_details']);
      $upi_code = $_REQUEST['upi_code'];

      $bd = json_encode($bank_details);
      $sql_i = "INSERT INTO rentre_invoice (receipt_id, user_id, property_id, tenant_id, total_amount, rent, rent_duration, no_of_days, elec_amount, elec_units, elec_cost_p_u, water_amount, extra_amount, extra_comment, deduct_amount, deduct_comment, bank_details, upi_code) VALUES
      ('$r_id', '$user_id', '$property_id', '$tenant_id', '$total_amount', '$rent', '$rent_duration', '$no_of_days', '$elec_amount', '$elec_units', '$elec_cost_p_u', '$water_amount', '$extra_amount', '$extra_comment', '$deduct_amount', '$deduct_comment', '$bank_details', '$upi_code');";
        if ($conn->query($sql_i) === TRUE) {
            header('Location: /preview_invoice.php?r_id='.substr($r_id, 2));
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;die;
            header('Location: /invoice.php?r_id='.$r_id.'&error=2');
        }
    } catch (\Exception $e) {
      header('Location: /profile.php?error=3');
    }
}

if($_REQUEST['type'] == 'update_profile'){
    try {
      $user_id = $_SESSION['id'];
      $name = $_REQUEST['full_name'];
      $pan_no = $_REQUEST['pan_no'];
      $bank_details->bank_name = $_REQUEST['bank_name'];
      $bank_details->account_no = $_REQUEST['account_no'];
      $bank_details->beneficiary_name = $_REQUEST['beneficiary_name'];
      $bank_details->ifsc_code = $_REQUEST['ifsc_code'];
      $bank_details->upi_id = $_REQUEST['upi_id'];
      $bd = json_encode($bank_details);
      $sql_i = "UPDATE rentre_user_details SET name='$name', bank_details = '$bd', pan_no = '$pan_no' WHERE user_id= '$user_id'";
        if ($conn->query($sql_i) === TRUE) {
            header('Location: /profile.php');
        } else {
            header('Location: /profile.php?error=2');
        }
    } catch (\Exception $e) {
      header('Location: /profile.php?error=3');
    }
}

if($_REQUEST['type'] == 'add_tenant'){
    try {
      $user_id = $_SESSION['id'];
      $property_id = $_REQUEST['property_id'];
      $name = $_REQUEST['tenant_name'];
      $portion = $_REQUEST['tenant_portion'];
      $aadhar_no = $_REQUEST['aadhar'];
      $amount = $_REQUEST['amount'];
      $start_date = $_REQUEST['start_date'];
      $sql_i = "INSERT INTO rentre_tenants (user_id, property_id, portion, name, aadhar_no, amount, start_date) VALUES
      ('$user_id', '$property_id', '$portion', '$name', '$aadhar_no', '$amount', '$start_date');";
        if ($conn->query($sql_i) === TRUE) {
            header('Location: /');
        } else {
            header('Location: /add_tenant.php?p_id='.$property_id.'&error=2');
        }
    } catch (\Exception $e) {
      header('Location: /add_tenant.php?p_id='.$property_id.'&error=3');
    }
}

if($_REQUEST['type'] == 'update_tenant'){
    try {

        
      $user_id = $_SESSION['id'];
      $property_id = $_REQUEST['property_id'];
      $tenant_id = $_REQUEST['tenant_id'];
      $name = $_REQUEST['tenant_name'];
      $portion = $_REQUEST['tenant_portion'];
      $aadhar_no = $_REQUEST['aadhar'];
      $amount = $_REQUEST['amount'];
      $start_date = $_REQUEST['start_date'];
      $sql_i = "UPDATE rentre_tenants SET portion='$portion', name = '$name', aadhar_no = '$aadhar_no', amount = '$amount', start_date='$start_date' WHERE user_id= '$user_id' AND id = '$tenant_id'";
        if ($conn->query($sql_i) === TRUE) {
            header('Location: /tenants.php');
        } else {
            header('Location: /add_tenant.php?p_id='.$property_id.'&error=2');
        }
    } catch (\Exception $e) {
      header('Location: /add_tenant.php?p_id='.$property_id.'&error=3');
    }
}

if($_REQUEST['type'] == 'add_property'){
    try {
      echo "<pre>";
      $user_id = $_SESSION['id'];
      $property_name = $_REQUEST['property_name'];
      $address_1 = $_REQUEST['address_1'];
      $address_2 = $_REQUEST['address_2'];
      $city_name = $_REQUEST['city'];
      $state_id = $_REQUEST['state'];
      $sql_i = "INSERT INTO rentre_property (user_id, name, address_1, address_2, city_name, state_id) VALUES
      ('$user_id', '$property_name', '$address_1', '$address_2', '$city_name', '$state_id');";
        if ($conn->query($sql_i) === TRUE) {
            header('Location: /');
        } else {
            header('Location: /add_property.php?error=2');
        }
    } catch (\Exception $e) {
      header('Location: /add_property.php?error=3');
    }
}

if($_REQUEST['type'] == 'forgot'){
    $username = $_REQUEST['username'];
    $return_url = strtok($_SERVER["HTTP_REFERER"], '?');
    if($username){
        $sql = "SELECT * FROM app_admin WHERE username = '$username'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        if($user && $user['id'] ){
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $email = $user['email'];
            $new_password = substr(str_shuffle($chars),0,8);
            $html = 'Your new password is = '.$new_password;
            $new_hash_password = $hash_password = hash('sha256', $new_password.$salt);
            $sql_c_p = "UPDATE app_admin SET password = '$new_hash_password' WHERE username = '$username'";
            $from = "care@matrixgmr.com";
            $headers = 'From: '.$from;
            if($conn->query($sql_c_p)){
                mail($email, "Password for Matrix", $html, $headers);
                header('Location: '.$return_url.'?success=1');
            }else{
                header('Location: '.$return_url.'?error=1');
            }
        }else{
            header('Location: '.$return_url.'?error=3');
        }
    }
    else{
        header('Location: '.$return_url.'?error=2');
    }
}

if($_REQUEST['type'] == 'register'){
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $re_password = $_REQUEST['re-password'];
    $sql = "SELECT * FROM rentre_user WHERE email = '$email'";
    $result = $conn->query($sql);
    $user_exist = $result->fetch_assoc();
    if (!$user_exist){
        $hash_password = hash('sha256', $password.$salt);
        $sql_i = "INSERT INTO rentre_user (username, email, password, create_time)
            VALUES ('$username', '$email', '$hash_password', NOW());";
            if ($conn->query($sql_i) === TRUE) {
                $user_id = $conn->insert_id;
                $_SESSION["id"] = $user_id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["name"] = $name;
                $sql_u_d = "INSERT INTO rentre_user_details (user_id) VALUES ('$user_id');";
                if($conn->query($sql_u_d) === TRUE){
                    header('Location: /');
                }
            } else {
                header('Location: /login.php');
            }
    }else{
        header('Location: /login.php');
    }
}

if($_REQUEST['type'] == 'check_login'){
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $hash_password = hash('sha256', $password.$salt);
    $sql = "SELECT * FROM rentre_user WHERE email = '$email' and password = '$hash_password'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    session_start();
    if($user && $user['id']){
        $_SESSION['login_error'] = false;
        $_SESSION["id"] = $user['id'];
        $_SESSION["username"] = $user['username'];
        $_SESSION["name"] = $user['name'];
        $_SESSION["email"] = $user['email'];
        header('Location: /');
    }
    else{
        $_SESSION['login_error'] = true;
        header('Location: '.$login_url);
    }
}

if($_REQUEST['type'] == 'change_pass'){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $new_password = $_REQUEST['new_password'];
    $hash_password = hash('sha256', $password.$salt);
    $sql = "SELECT * FROM app_admin WHERE username = '$username' and password = '$hash_password'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    session_start();
    if($user && $user['id']){
        $new_hash_password = $hash_password = hash('sha256', $new_password.$salt);
        $sql_c_p = "UPDATE app_admin SET password = '$new_hash_password' WHERE username = '$username'";
        $result = $conn->query($sql_c_p);
        header('Location: '.$_SERVER['HTTP_REFERER'].'?success=1');
    }
    else{
        $_SESSION['login_error'] = true;
        header('Location: '.$_SERVER['HTTP_REFERER'].'?error=1');
    }
}


// add_update project in db
if($_REQUEST['type'] == 'assign_project'){
    $update = false;
    if($_REQUEST['id']){
        $id = $_REQUEST['id'];
        $update = true;
    }
    $group_id = $_REQUEST['group_id'];
    $vendor_id = $_REQUEST['vendor_id'];
    $cost = $_REQUEST['cost'];
    $property = array();
    $property['completed'] = $_REQUEST['project_completed_link'];
    $property['quota_full'] = $_REQUEST['project_quota_full_link'];
    $property['terminated'] = $_REQUEST['project_terminated_link'];
    $links = serialize($property);

    $sql_group = "SELECT * FROM app_group WHERE id = '$group_id'";
    $result = $conn->query($sql_group);
    $group = $result->fetch_assoc();
    $project_id = $group['group_id'];
    $group_name = $group['group_name'];

    $sql = "SELECT * FROM app_project WHERE project_id = '$project_id' and name = '$group_name'";
    $result = $conn->query($sql);
    while($project = $result->fetch_assoc()){
        $p_id = $project['id'];
        $sql = "INSERT INTO app_project_vendor_assign (project_id, client_project_id, vendor_id, cost, links, create_time)
            VALUES ('$p_id', '$project_id', '$vendor_id', '$cost', '$links', NOW());";
            if ($conn->query($sql) === TRUE) {
                continue;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    $conn->close();
    header('Location: project_a.php');
    // $project = $result->fetch_assoc();

    // $sql = "SELECT * FROM app_project WHERE id = $project_id";
    // $result = $conn->query($sql);
    // $project = $result->fetch_assoc();
    // $client_project_id = $project['project_id'];

    // if(!$update){

    //     $sql = "INSERT INTO app_project_vendor_assign (project_id, client_project_id, vendor_id, cost, links, create_time)
    //         VALUES ('$project_id', '$client_project_id', '$vendor_id', '$cost', '$links', NOW());";
    // }
    // else{
    //     $sql = "UPDATE app_project_vendor_assign set project_id = '$project_id', client_project_id = '$client_project_id', vendor_id = '$vendor_id', cost = '$cost', links = '$links', create_time = NOW() WHERE id = $id";
    // }
    // if ($conn->query($sql) === TRUE) {
    //     header('Location: project_a.php');
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
    $conn->close();

}

// add_update project in db
if($_REQUEST['type'] == 'project'){
    $update = false;
    if($_REQUEST['id']){
        $group_id = $_REQUEST['id'];
        $update = true;
    }
    $group_name = $_REQUEST['project_name'];
    $client_id = $_REQUEST['project_client_id'];
    $project_id = $_REQUEST['project_id'];
    $link = $_REQUEST['project_link'];
    $target = $_REQUEST['project_target'] ? $_REQUEST['project_target'] : 0;
    $cost = $_REQUEST['project_cost'];
    $quota_detail = $_REQUEST['quota_detail'];
    $start_date = $_REQUEST['project_start_date'];
    $end_date = $_REQUEST['project_end_date'];
    $status = $_REQUEST['status'] ? 1 : 0;
    $ip_check = $_REQUEST['ip_check'] ? 1 : 0;
    $link_id_arr = $_REQUEST['link_id'];
    $link_region_arr = $_REQUEST['link_region'];
    $link_link_arr = $_REQUEST['link_link'];
    // echo "<pre>";
    // print_r($_REQUEST);die;
    if($link_id_arr){
        $j = 0;
        while ($link_id_arr[$j])
        {
            $id = $link_id_arr[$j];
            $link_region = $link_region_arr[$j];
            $link = $link_link_arr[$j];
            $sql_update = "UPDATE app_project set name = '$group_name', client_id = '$client_id', link_region = '$link_region', link = '$link', target = '$target', cost = '$cost', status = '$status', ip_check= '$ip_check', quota_detail = '$quota_detail', start_date = '$start_date', end_date = '$end_date', create_time = NOW(), project_id = '$project_id' WHERE id = $id";
            $conn->query($sql_update);
            $j++;
        }
    }
    while ($link_link_arr[$j])
    {
        $link_region = $link_region_arr[$j];
        $link = $link_link_arr[$j];
        $sql_new_project = "INSERT INTO app_project (name, client_id, link_region, link, target, cost, status, ip_check, quota_detail, start_date, end_date, create_time, project_id)
        VALUES ('$group_name', '$client_id', '$link_region', '$link', '$target', '$cost', '$status', '$ip_check', '$quota_detail',  '$start_date', '$end_date', NOW(), '$project_id');";
        $conn->query($sql_new_project);
        $j++;
    }
    if(!$update){
        $sql = "INSERT INTO app_group (group_name, group_id, status, create_time)
            VALUES ('$group_name', '$project_id', '$status', NOW());";
    }
    else{
        $sql = "UPDATE app_group set group_name = '$group_name', group_id = '$project_id', status= '$status', create_time = NOW() WHERE id = $group_id";
    }
    $conn->query($sql);
    $conn->close();
    header('Location: project.php');
    // if(!$update){
    //     $sql = "INSERT INTO app_project (name, client_id, link, target, cost, status, ip_check, quota_detail, start_date, end_date, create_time, project_id)
    //         VALUES ('$name', '$client_id', '$link', '$target', '$cost', '$status', '$ip_check', '$quota_detail',  '$start_date', '$end_date', NOW(), '$project_id');";
    // }
    // else{
    //     $sql = "UPDATE app_project set name = '$name', client_id = '$client_id', link = '$link', target = '$target', cost = '$cost', status = '$status', ip_check= '$ip_check', quota_detail = '$quota_detail', start_date = '$start_date', end_date = '$end_date', create_time = NOW(), project_id = '$project_id' WHERE id = $id";
    // }
    // if ($conn->query($sql) === TRUE) {
    //     header('Location: project.php');
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
    // $conn->close();

}


// add_update client in db
if($_REQUEST['type'] == 'client'){
    $update = false;
    if($_REQUEST['client_id']){
        $client_id = $_REQUEST['client_id'];
        $update = true;
    }
    $name = $_REQUEST['client_name'];
    $mobile = $_REQUEST['client_mobile'];
    $email = $_REQUEST['client_email'];
    $property = array();
    $property['country'] = $_REQUEST['client_country'];
    $property['address'] = $_REQUEST['client_address'];
    $property['zip_code'] = $_REQUEST['client_zip_code'];
    $property['company_name'] = $_REQUEST['client_c_n'];
    $property['company_website'] = $_REQUEST['client_c_w'];
    $encoded_property = serialize($property);
    if(!$update){
        $sql = "INSERT INTO app_client (name, mobile_no, email, property, create_time)
            VALUES ('$name', '$mobile', '$email', '$encoded_property', NOW());";
    }
    else{
        $sql = "UPDATE app_client set name = '$name', mobile_no = '$mobile', email = '$email', property = '$encoded_property', create_time = NOW() WHERE id = $client_id";
    }
    if ($conn->query($sql) === TRUE) {
        header('Location: client.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

// add_update vendor in db
if($_REQUEST['type'] == 'vendor'){
    $update = false;
    if($_REQUEST['id']){
        $vendor_id = $_REQUEST['id'];
        $update = true;
    }
    $name = $_REQUEST['vendor_name'];
    $mobile = $_REQUEST['vendor_mobile'];
    $email = $_REQUEST['vendor_email'];
    $property = array();
    $property['country'] = $_REQUEST['vendor_country'];
    $property['address'] = $_REQUEST['vendor_address'];
    $property['zip_code'] = $_REQUEST['vendor_zip_code'];
    $property['company_name'] = $_REQUEST['vendor_c_n'];
    $property['company_website'] = $_REQUEST['vendor_c_w'];
    $property['company_email'] = $_REQUEST['vendor_c_email'];
    $property['mail_for_finance'] = $_REQUEST['mail_for_finance'];
    $encoded_property = serialize($property);
    if(!$update){
        $sql = "INSERT INTO app_vendor (name, mobile_no, email, property, create_time)
            VALUES ('$name', '$mobile', '$email', '$encoded_property', NOW());";
    }
    else{
        $sql = "UPDATE app_vendor set name = '$name', mobile_no = '$mobile', email = '$email', property = '$encoded_property', create_time = NOW() WHERE id = $vendor_id";
    }
    if ($conn->query($sql) === TRUE) {
        header('Location: vendor.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}


?>
