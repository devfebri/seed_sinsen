<?php
function set_header_response($http_headers)
{
    # set header untuk info ratelimit
    foreach ($http_headers as $hk => $hv) :
        header($hk . ':' . $hv);
    endforeach;
}

function validate_datetime($datetime, $format = "Y-m-d H:i:s")
{
    return (DateTime::createFromFormat($format, $datetime) !== false);
}

// function validate_datetime($datetime)
// {
//   $date = str_replace('/', '-', $datetime);
//   $date  = date('Y-m-d', strtotime($date));
//   return $date;
// }


function validasi($filter = null)
{
    header('Content-Type:application/json');
    $CI = &get_instance();

    $res = array(
        'status' => 0,
        'message' => array('err_msg' => 'Invalid Credential'),
        'data' => NULL
    );
    $header_api_key ='';
    $secret_key ='';
    $id_dealer = '';
    $fromTime = '';
    $toTime = '';
    
    # Ambil request header yang dikirimkan oleh client
    $header_api_key = isset($_SERVER['HTTP_COBA']) ? $_SERVER['HTTP_COBA'] : NULL;
    $secret_key = isset($_SERVER['HTTP_SECRET_KEY']) ? $_SERVER['HTTP_SECRET_KEY'] : NULL;
    $id_dealer = isset($_SERVER['HTTP_DEALER']) ? $_SERVER['HTTP_DEALER'] : NULL;
    $fromTime = isset($_SERVER['HTTP_FROMTIME']) ? $_SERVER['HTTP_FROMTIME'] : NULL;
    $toTime = isset($_SERVER['HTTP_TOTIME']) ? $_SERVER['HTTP_TOTIME'] : NULL;
    # Verifikasi API Key
    if($header_api_key === "" && $id_dealer == "" && $secret_key == $secret_key){
      $query = $CI->db->query("SELECT secret_key, id_dealer FROM ms_api_power_bi WHERE secret_key = '$secret_key' AND active = 1");
      if ($query->num_rows() > 0) {
          $credential = $query->row();

          $list_dealer ='';
          foreach($query->result() as $credential){
            $list_dealer .= "'". $credential->id_dealer. "',";
          }
          $list_dealer = rtrim($list_dealer, ",");
          
      }
    }elseif($header_api_key === $header_api_key && $id_dealer === $id_dealer && $secret_key === ""){
      $query = $CI->db->query("SELECT secret_key, id_dealer FROM ms_api_power_bi WHERE api_key = '$header_api_key' AND id_dealer IN ($id_dealer) AND active = 1");
      if ($query->num_rows() > 0) {
          $credential = $query->row();

          $list_dealer ='';
          foreach($query->result() as $credential){
            $list_dealer .= "'". $credential->id_dealer. "',";
          }
          $list_dealer = rtrim($list_dealer, ",");
          
      }
    }

    if(($header_api_key === "" && $id_dealer == "" && $secret_key == $secret_key) ||
    ($header_api_key === $header_api_key && $id_dealer === $id_dealer && $secret_key === ""))
    {

        $validation_flag = true;
        $validation_msg = '';

        if(empty($fromTime)){
            $validation_flag = false;
            $validation_msg = 'Filter waktu mulai harus diisi.';
        }elseif(!validate_datetime($fromTime)) {
            $validation_flag = false;
            $validation_msg = 'Format waktu mulai salah.';
        }

        if(empty($toTime)){
            $validation_flag = false;
            $validation_msg = 'Filter waktu selesai harus diisi.';
        }elseif(!validate_datetime($toTime)) {
            $validation_flag = false;
            $validation_msg = 'Format waktu selesai salah.';
        }
        // send_json($fromTime);die;
        if($validation_flag){
            $res = array(
                'status'         => 1,
                'message'        => array('success_msg' => 'Success Valid API Key'),
                'id_dealer'      => $list_dealer,
                'post' => compact('fromTime', 'toTime'),
                'data'           => null
            );
            // send_json($_SERVER['HTTP_FROMTIME']);die;
            // send_json($post_array);die;
        }else {
            $res = array(
                'status' => 0,
                'message' => array('err_msg' => $validation_msg),
                'data' => null
            );
        }
    }

    $res['activity'] = [
        'endpoint'           => isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : $_SERVER['REQUEST_URI'],
        'ip_address'         => get_client_ip(),
        'api_key'            => $header_api_key == NULL ? 0 : $header_api_key,
        'request_time'       => $_SERVER['REQUEST_TIME'],
        'http_response_code' => $_SERVER['REDIRECT_STATUS'],
        'status'             => $res['status'],
        'message'            => $res['status'] == 0 ? $res['message']['err_msg'] : NULL
    ];
    return $res;
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function response_time()
{
    return microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
}
?>

