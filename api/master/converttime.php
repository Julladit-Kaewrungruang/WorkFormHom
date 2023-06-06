<?php
date_default_timezone_set("Asia/Bangkok");
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_dayEN_arr=array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$thai_day_arr_short=array("อ.","จ.","อ.","พ.","พฤ.","ศ.","ส.");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน",
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"
);
$thai_month_arr_short=array(
    "0"=>"",
    "1"=>"ม.ค.",
    "2"=>"ก.พ.",
    "3"=>"มี.ค.",
    "4"=>"เม.ย.",
    "5"=>"พ.ค.",
    "6"=>"มิ.ย.",
    "7"=>"ก.ค.",
    "8"=>"ส.ค.",
    "9"=>"ก.ย.",
    "10"=>"ต.ค.",
    "11"=>"พ.ย.",
    "12"=>"ธ.ค."
);
$thai_month_arr_mum_short=array(
    "0"=>"",
    "1"=>"01",
    "2"=>"02",
    "3"=>"03",
    "4"=>"04",
    "5"=>"05",
    "6"=>"06",
    "7"=>"07",
    "8"=>"08",
    "9"=>"09",
    "10"=>"10",
    "11"=>"11",
    "12"=>"12"
);
function thai_date($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="วัน".$thai_day_arr[date("w",$time)];
    $thai_date_return.= " ที่ ".date("j",$time);
    $thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " พ.ศ.".(date("Y",$time)+543);
    $thai_date_return.= " เวลา  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
function thai_date_bt1($time){
    global $thai_day_arr_short,$thai_month_arr;
    $thai_date_return= $thai_day_arr_short[date("w",$time)];
    $thai_date_return.= ", ".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " ".(date("Y",$time)+543);
    $thai_date_return.= " เวลา  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
function thai_date_short($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " ".(date("Y",$time)+543);
    $thai_date_return.= " เวลา  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
function thai_date_short_v2($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr_short[date("n",$time)];
    $thai_date_return.= " ".(date("Y",$time)+543);
    $thai_date_return.= " เวลา  ".date("H:i",$time)." น.";
    return $thai_date_return;
}

function thai_date_short_v3($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("H:i:s",$time)." น.";
    return $thai_date_return;
}

function thai_date_short_v4($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr_short[date("n",$time)];
    $thai_date_return.= " ".(date("Y",$time)+543);
    $thai_date_return.= ", ".date("H:i:s",$time)." น.";
    return $thai_date_return;
}
function thai_date_short_v5($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr_short[date("n",$time)];
    $thai_date_return.= " ".(date("Y",$time)+543);

    return $thai_date_return;
}
function time_statement($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr_short[date("n",$time)];
    $thai_date_return.= " ".(date("y",$time)+43);
    $thai_date_return.= " เวลา  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
function time_statement2($time){
    global $thai_month_arr_short,$thai_month_arr;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr_short[date("n",$time)];
    $thai_date_return.= " ".(date("y",$time)+43);
    $thai_date_return.= ", ".date("H:i",$time)." น.";
    return $thai_date_return;
}
function time_tableDate($time){
    global $thai_month_arr_short,$thai_month_arr,$thai_month_arr_mum_short;
    $thai_date_return="";
    $thai_date_return.= "".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr_short[date("n",$time)];
    $thai_date_return.= " ".(date("y",$time)+43);
    return $thai_date_return;
}
function time_tableTime($time){
    global $thai_month_arr_short,$thai_month_arr,$thai_month_arr_mum_short;
    $thai_date_return="";
    $thai_date_return.= "".date("H.i",$time)." น.";
    return $thai_date_return;
}
 ?>
