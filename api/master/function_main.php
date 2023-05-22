<?php

date_default_timezone_set("Asia/Bangkok");
require_once('../../include/php/connect.php');
// require_once('../../include/php/time.php');
$keyAPI = 'TiwPatipanSHfQ0QrwqlRdXpwzTxvEGd7QbiADFsxEIKzsVSYgMx30YroyvBNRd5CqUbPSjvPZM6gTaRzhdKsoY8TpYgy477C7Vxoe6PdTqoOhtPJSdn19PAk4';
if(!isset($_SESSION)){ session_start();}
ob_start();

function checkTextSQL2($data){
  $data = str_replace("'","",$data);
  $data = str_replace("?","",$data);
  $data = str_replace("=","",$data);
  $data = str_replace("%","",$data);
  return $data;
}
function TransactionId($len){
      $chars = "0123456789";
      $ret_char = "";
      $num = strlen($chars);
      for($i = 0; $i < $len; $i++) {
          $ret_char.= $chars[rand()%$num];
          $ret_char.="";
      }
      $ret_char=time()."".$ret_char;
      return $ret_char;
}
function new_token($len){
  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  $ret_char = "";
  $num = strlen($chars);
  for($i = 0; $i < $len; $i++) {
      $ret_char.= $chars[rand()%$num];
      $ret_char.="";
  }
  return $ret_char;
}
function new_token_uppercase($len){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $ret_char = "";
    $num = strlen($chars);
    for($i = 0; $i < $len; $i++) {
        $ret_char.= $chars[rand()%$num];
        $ret_char.="";
    }
    return $ret_char;
  }
function new_otp($len){
  $chars = "123456789";
  $ret_char = "";
  $num = strlen($chars);
  for($i = 0; $i < $len; $i++) {
      $ret_char.= $chars[rand()%$num];
      $ret_char.="";
  }
  return $ret_char;
}
function sensorNumber($number,$numDigit){
  $numcut = $numDigit-4;
  $x = "";
  for($i=1;$i<=$numcut;$i++){
    $x=$x."x";
  }
  $number=$x.substr($number,  $numcut, $numDigit-1);
  return $number;
}
// function ConvertTimeToArray($time){
//   $timeArray = array('dateOld'=>$time,'date'=>thai_date_short_v5($time),'time'=>time_tableTime($time),'full'=>thai_date_short_v4($time),'short'=>time_tableDate($time));
//   return $timeArray;
// }


function getDataSQLv1($type,$tablename,$condition){
    global $db;
    $DataArray = array();
    if($type==1){
      $getdata = $db->prepare(''.$tablename.'');
      $getdata->execute($condition);
      while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
        array_push($DataArray,$dataSelect);
      }
    }
    return $DataArray;
  }
  function getDataSQLBT($type,$tablename,$condition){
    global $db2016;
    $DataArray = array();
    if($type==1){
      $getdata = $db2016->prepare(''.$tablename.'');
      $getdata->execute($condition);
      while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
        array_push($DataArray,$dataSelect);
      }
    }
    return $DataArray;
  }
  function getDataSQLHR($type,$tablename,$condition){
    global $dbHR;
    $DataArray = array();
    if($type==1){
      $getdata = $dbHR->prepare(''.$tablename.'');
      $getdata->execute($condition);
      while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
        array_push($DataArray,$dataSelect);
      }
    }
    return $DataArray;
  }
  function updateSQL($tablename,$dataupdate,$whereColumn,$condition){
    global $db;
    $update = $db->prepare("UPDATE  $tablename SET $dataupdate WHERE $whereColumn");
    $update->execute($condition);
    return true;
  }
  function insertSQL($table,$insertColumn,$condition){
    global $db;
    $countColimn = explode(",",$insertColumn);
    $value = '';
    for($i=0;$i<count($countColimn);$i++){
        $i>0?  $value.=',' :  null;
        $value.='?';
    }

    $save = $db->prepare("INSERT INTO $table ($insertColumn) VALUES ($value)");
    $save->execute($condition);
    return $save;
  }

  function countColumn($tableDB,$condition){
    global $db;
    $check = $db->prepare("SELECT COUNT(*) FROM $tableDB");
    $check->execute($condition);
    $num = $check->fetchColumn();
    return  $num;
  }

  function setDataReturn($code,$data){
    if(count($data)>0){
      $datareturn = array('status'=>200,'msg'=>'you don\'t currently have permission to access this data','data'=>$data);
    }else{
      $datareturn = array('status'=>$code!=0?$code:403,'msg'=>'you don\'t currently have permission to access this data','data'=>$data);
    }
    return $datareturn;
  }

  function encrypt($key, $payload) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
  }
  
  function decrypt($key, $data) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
  }


  function sendmailToEmp($from,$arrTo,$subject,$bodyHtml){
    $test = array($from,$arrTo,$subject,$bodyHtml);
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); 
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->SMTPAuth = true; 
    $mail->SMTPKeepAlive = true;
    $mail->Username = "survey@bt-midland.com";
    $mail->Password = "bTmidland@Survey1485##";
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    foreach($arrTo AS $to){
        $mail->AddAddress($to['mail'],$to['name']);
    }
    // ใส่ Email ที่ต้องการให้ reply กลับ ที่นี่ 
    $mail->AddReplyTo('survey@bt-midland.com','Admin');

    $mail->setFrom('survey@bt-midland.com',$from);
    $mail->WordWrap = 50; 
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $bodyHtml;
    // $mail->Body = "<div>Hello</div>";

    if($mail->Send()){
      $data=true;
    }else{
      $data=false;
    }
    // $mail = array($from,$arrTo,$arrCC,$arrFile,$subject,$bodyHtml);
    return $data;
}


function callAPISendMail($dataG){
  $curl = curl_init('https://report.bt-midland.com/api/private_test/service');
  curl_setopt($curl, CURLOPT_URL, 'https://report.bt-midland.com/api/private_test/service');
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $headers = array(
    "Content-Type: application/json",
    'Authorization: Bearer zv1KtOE81TdO2bY13Cu2eRN0sKMFLClOnsxcFLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG000000DSzO'
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data = array( "type"=>"sendEmail_V2",
    "data"=>$dataG,
    "key" =>"zv1KtOE81TdO2bY13Cu2eRN0sKMFLClOnsxcFLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG000000DSzO"
  );
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $resp = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($resp);
  return $response;
}


function createFormEmailRequestWFH(){
  return '<body style="background-color: #ffffff;">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
          <td align="center" bgcolor="#f1f1f1">

              <table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" width="100%"
                  style="max-width: 600px;">
                  <tr>
                      <td align="center" valign="top" style="padding: 36px 0px 30px 0px;font-size:14px">
                          <img src="https://survey.btm.co.th/include/img/logo_bt_midland.png" width="80px"><br>
                      </td>
                  </tr>
                  <tr>
                      <td align="left" valign="top" style="font-size:14px;padding:0px 40px">
                          <p style=""><b>เรียนคุณ ปฏิภาณ อินธิบาล</b><br><br>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                              กระผม Patipan Inthibal แผนก Business Control ตำแหน่ง Programmer มีความประสงค์ต้องการ
                              WFH(Work Form Home)ในวันที่ 17/05/2023 <br>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                              สามารถอนุมัติหรือไม่อนุมัติได้ตามปุ่มด้านล่าง
                          </p>
                      </td>
                  </tr>
                  <tr>
                      <td align="center" valign="top" style="font-size:14px;padding:0px 40px;display:block">
                          <table>
                              <tr>
                                  <td style="text-align:center">
                                      <a href="https://survey.btm.co.th/Token/Token" style="text-decoration:none">
                                          <p
                                              style="width: 200px;background:#22c55e;color:#ffffff;font-size:17px;font-weight:bold;line-height:120%;Margin:0;text-decoration:none;text-transform:none;padding:10px;margin:18px 0px;border-radius:10px">
                                              อนุมัติทั้งหมด
                                          </p>
                                      </a>
                                  </td>
                                  <td style="text-align:center">
                                      <a href="https://survey.btm.co.th/Token/Token" style="text-decoration:none">
                                          <p
                                              style="width: 200px;background:#ec2028;color:#ffffff;font-size:17px;font-weight:bold;line-height:120%;Margin:0;text-decoration:none;text-transform:none;padding:10px;margin:18px 0px;border-radius:10px">
                                              ไม่อนุมัติทั้งหมด
                                          </p>
                                      </a>
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="2" style="text-align:center">
                                      หรือ
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="2" style="text-align:center">

                                      <a href="https://survey.btm.co.th/Token/Token" style="text-decoration:none">
                                          <p style="width: 100%;background: #d1d1d1;color: #ffffff;font-size: 15px;font-weight: bold;line-height: 110%;text-decoration: none;text-transform: none;padding: 10px;border-radius: 10px;max-width: 336px;margin: auto;margin-top: 8px;">
                                              เข้าสู่ระบบเพื่อดูรายละเอียดคำขอนี้
                                          </p>
                                      </a>
                                  </td>
                      </td>
                  </tr>
              </table>

          </td>

      </tr>

      <tr>
          <td align="center" bgcolor="#9aaeba" style="padding:0px">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                      <td align="center" valign="top" style="font-size:14px">
                          <img src="https://survey.btm.co.th/include/img/bg-bt-survey-bottom.png" width="100%"><br>
                      </td>
                  </tr>
                  <tr>
                      <td align="center" bgcolor="#9aaeba"
                          style="text-align: center;padding: 0px 24px; font-size: 14px; line-height: 20px; color: #fff;">
                          <p style="margin: 0;">
                              <small><b>BT Midland Co.,Ltd.</b><br>90 On nut road Prawet Bangkok
                                  10250</small><bR>
                              <a href="https://www.bt-midland.com/privacy">Privacy policy</a>
                          </p>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
  </table>
  </td>
  </tr>
  </table>
</body>';
}



?>