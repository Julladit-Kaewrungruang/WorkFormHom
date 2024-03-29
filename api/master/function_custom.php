<?php

// use function PHPSTORM_META\type;

function getDashboard($type, $dataAPI, $dataoption)
{
    $datareturn = array();
    $code = 403;
    if ($type == 'GraphExpireInYear') {
    } else if ($type == 'SumExpire') {
    }
    return setDataReturn($code, $datareturn);
}

function manageAdmin($type, $dataAPI, $dataoption)
{
    $datareturn = array();
    $code = 403;
    if ($type == 'SetSchedule') {
    }
    return setDataReturn($code, $datareturn);
}

function getformrequest($type, $dataAPI, $dataoption)
{
    $datareturn = array();
    $code = 403;
    $empId = $_SESSION['emp_id'];
    if ($type == 'request') {
        $datareturn = $dataAPI;
        // $token = 'WFH' . date('ymd', time()) . new_token_uppercaseV2(4);
        $token = genWorkRanningNo();
        $assignTo = $empId;
        $statusApprove = 1;
        if ($dataAPI['assign'] == 1) {
            $assignTo = $dataAPI['assignTo'];
            $statusApprove = 2;
        }
        insertSQL('wfh_request', '[requestor_id]
        ,[request_to]
        ,request_remark
        ,[request_create_at]
        ,[request_type]
        ,[request_quota]
        ,request_type_select
        ,request_token', array($empId, $assignTo, $dataAPI['remark'], date('Y-m-d H:i:s', time()), 1, 1,$dataAPI['type'], $token));
        $wfh = getDataSQLv1(1, 'SELECT request_id from wfh_request  where request_token=?', array($token));
        foreach ($wfh as $request) {
            foreach ($dataAPI['date'] as $date) {
                
                if($dataAPI['type']==1 || $dataAPI['type']==3){
                    insertSQL('wfh_requestDate', 'date_requestid,date_select,date_status,date_select_from,date_select_to', array($request['request_id'], $date, $statusApprove,$date." "."08:00",$date." "."17:00"));
                }else{

                    insertSQL('wfh_requestDate', 'date_requestid,date_select,date_status,date_select_from,date_select_to', array($request['request_id'], $date['date'], $statusApprove,$date['date']." ".$date['from'],$date['date']." ".$date['to']));

                    // insertSQL('wfh_requestDate', 'date_requestid,date_select,date_status', array($request['request_id'], $date['date'], $statusApprove));
                }
                // createTimeline();
            }
            // array_push($datareturn, $request);
        }
        $mail = array();
        if ($dataAPI['assign'] == 1) {
            $mail = sendEmailWFHNotify($token);
        } else {
            $mail = sendEmailForApprove($token);
            $mail = sendEmailForConfirm($token);
        }
        $datareturn = array('mail' => $mail);
        // array_push($datareturn, json_encode($_SESSION['emp_id']));
    } else if ($type == 'Myhistory') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where date_status!=9
        ', array());
    } else if ($type == 'EmpRequest') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where date_status!=9
        ', array());
    } else if ($type == 'MyTeam') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where date_status!=9
        ', array());
    } else if ($type == 'employeeRequest') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
         left join wfh_request on date_requestid=request_id
         left join user_emp_view on todo_type=request_to
         where date_status!=9 
         ', array());
    } else if ($type == 'ShowCalenderdate') {
        // $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        // left join wfh_request on date_requestid=request_id
        // left join user_emp_view on emp_id=request_to
        // where date_status!=9
        // ', array());
        // filterDepartment
        $condition = '';
        if ($dataAPI['filterDepartment'] != 'All') {
            $condition .= " AND orgunit_name='" . $dataAPI['filterDepartment'] . "' ";
        }
        if($dataAPI['status']!='All'){
            $condition .= " AND date_status='" . $dataAPI['status'] . "' ";
        }

        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where (date_status!=4 AND date_status!=3) '.$condition, array());
    } else if ($type == 'empSection') {
        $datareturn = getDataSQLv1(1, 'SELECT * from user_emp_view  where emp_status=1   AND emp_welapproved=? order by emp_fname asc', array($empId));
        // $datareturn = getDataSQLv1(1, 'SELECT * from user_emp_view  where emp_status=1   AND emp_welapproved=? order by emp_fname asc', array('10254'));
    } else if ($type == 'HistoryemployeeRequest') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where date_status!=9 
        ', array());
    }
    return setDataReturn($code, $datareturn);
}

function createTimeline()
{
    // return  insertSQL('wfh_timeline', '[date_requestid],[date_select]', array($request['request_id'], $date));
}
function sendEmailForApprove($token)
{


    global $dateNow, $browser, $keyAPI;
    $wfh = getDataSQLv1(1, 'SELECT top 1 * from wfh_request 
    left join user_emp_view on requestor_id=emp_id
    where request_token=?', array($token));
    $d = array();
    $arrSelestType = array('','Special Case','Custom','Normal');
    foreach ($wfh as $request) {
        $requestTo = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        foreach ($requestTo as $To) {
            $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($To['emp_welapproved']));
            foreach ($Leader as $Mgr) {
                //ส่งEmailหาหัวหน้างาน
                $MgrEmail = $Mgr['emp_email'];
                $MgrName = $Mgr['emp_fname'];
                // $MgrEmail = 'tangjuradit969@gmail.com';
                // $MgrName = 'User Test';
                $dataAPITOServer8 = array(
                    'toMail' => base64_encode($MgrEmail),
                    'toName' => encrypt($keyAPI, base64_encode($MgrName)),
                    'from' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' ' . $request['emp_lname'])),
                    'subject' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' Request Work From Home #' . $token.' ('.$arrSelestType[$request['request_type_select']].')')),
                    'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFH($token)))
                );
                $dt = callAPISendMail($dataAPITOServer8);
            }
        }
        // if ($request['request_type'] == 2) {
        //     // send mail requestor and request to;
        // } else {
        //     // send to my email
        //     $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        // }
        // ส่งให้ตัวเอง
        // $dataAPITOServer8 = array(
        //     'toMail' => base64_encode($request['emp_email']),
        //     'toName' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
        //     'from' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
        //     'subject' => encrypt($keyAPI, base64_encode('ยืนยันคำขอ Work From Home #' . $token)),
        //     'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFH($token)))
        // );
        // $dt = callAPISendMail($dataAPITOServer8);
        $request['to'] = $requestTo;
        array_push($d, $request);
    }
    return $d;
}

function sendEmailForConfirm($token)
{
    global $dateNow, $browser, $keyAPI;
    $wfh = getDataSQLv1(1, 'SELECT top 1 * from wfh_request 
    left join user_emp_view on requestor_id=emp_id
    where request_token=?', array($token));
    $d = array();
    $arrSelestType = array('','Special Case','Custom','Normal');
    foreach ($wfh as $request) {
        $requestTo = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        foreach ($requestTo as $To) {
            $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($To['emp_welapproved']));
            foreach ($Leader as $Mgr) {
                //ส่งEmailหาหัวหน้างาน
                $MgrEmail = $To['emp_email'];
                $MgrName = $To['emp_fname'];
                // $MgrEmail = 'tangjuradit969@gmail.com';
                // $MgrName = 'User Test';
                $dataAPITOServer8 = array(
                    'toMail' => base64_encode($MgrEmail),
                    'toName' => encrypt($keyAPI, base64_encode($MgrName)),
                    'from' => encrypt($keyAPI, base64_encode('ระบบขอ WFH ')),
                    'subject' => encrypt($keyAPI, base64_encode(' ยืนยันคำร้องขอ Work From Home #' . $token.' ('.$arrSelestType[$request['request_type_select']].')')),
                    'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestToEmp($token)))
                );
                $dt = callAPISendMail($dataAPITOServer8);
            }
        }
        // if ($request['request_type'] == 2) {
        //     // send mail requestor and request to;
        // } else {
        //     // send to my email
        //     $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        // }
        // ส่งให้ตัวเอง
        // $dataAPITOServer8 = array(
        //     'toMail' => base64_encode($request['emp_email']),
        //     'toName' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
        //     'from' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
        //     'subject' => encrypt($keyAPI, base64_encode('ยืนยันคำขอ Work From Home #' . $token)),
        //     'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFH($token)))
        // );
        // $dt = callAPISendMail($dataAPITOServer8);
        $request['to'] = $requestTo;
        array_push($d, $request);
    }
    return $d;
}

function sendEmailWFHNotify($token)
{
    global $dateNow, $browser, $keyAPI;
    $wfh = getDataSQLv1(1, 'SELECT top 1 * from wfh_request 
    left join user_emp_view on requestor_id=emp_id
    where request_token=?', array($token));
    $d = array();
    $arrSelestType = array('','Special Case','Custom','Normal');
    foreach ($wfh as $request) {
        $requestTo = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        foreach ($requestTo as $To) {

            $MgrEmail = $To['emp_email'];
            $MgrName = $To['emp_fname'] . " " . $request['emp_lname'];

            // $MgrEmail = 'tangjuradit969@gmail.com';
            // $MgrName = 'User Test';
            $dataAPITOServer8 = array(
                'toMail' => base64_encode($MgrEmail),
                'toName' => encrypt($keyAPI, base64_encode($MgrName)),
                'from' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' ' . $request['emp_lname'])),
                'subject' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' Assign Work From Home #' . $token.' ('.$arrSelestType[$request['request_type_select']].')')),
                'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFHNotify($token)))
            );
            $dt = callAPISendMail($dataAPITOServer8);
        }
        // if ($request['request_type'] == 2) {
        //     // send mail requestor and request to;
        // } else {
        //     // send to my email
        //     $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        // }
        // ส่งให้ตัวเอง
        // $dataAPITOServer8 = array(
        //     'toMail' => base64_encode($request['emp_email']),
        //     'toName' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
        //     'from' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
        //     'subject' => encrypt($keyAPI, base64_encode('ยืนยันคำขอ Work From Home #' . $token)),
        //     'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFH($token)))
        // );
        // $dt = callAPISendMail($dataAPITOServer8);
        $request['to'] = $requestTo;
        array_push($d, $request);
    }
    return $d;
}

function GetWork($type, $dataAPI, $dataoption)
{
    $datareturn = array();
    $code = 403;
    $empId = $_SESSION['emp_id'];
    if ($type == 'Todo') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_todolist where todo_status!=9', array());
    } else if ($type == 'Create') {
        $token = time() . new_token(10);
        insertSQL('wfh_todolist', '[todo_owner]
        ,[todo_type]
        ,[todo_forType]
        ,[todo_title]
        ,[todo_description]
        ,[todo_private]
        ,[todo_date]
        ,[todo_duedate]
        ,[rodo_created_at]
        ,[todo_token]
        ,[todo_status]', array(
            $empId, $dataAPI['type'], 1, $dataAPI['name'], $dataAPI['aboutWork'],
            $dataAPI['state'], date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', time()),
            date('Y-m-d H:i:s', time()), $token, 1
        ));
        $data = getDataSQLv1(1, 'SELECT * from wfh_todolist where todo_token=?', array($token));
        foreach ($data as $todo) {
            foreach ($dataAPI['who'] as $who) {
                insertSQL('wfh_todoFor', 'for_todoid,for_userid', array($todo['todo_id'], $who));
            }
            array_push($datareturn, $todo);
        }
        // array_push($datareturn,$dataAPI['who']);
    } else if ($type == 'UpdataType') {
        $data = getDataSQLv1(1, 'SELECT * from wfh_todolist where todo_token=?', array($dataAPI['token']));
        foreach ($data as $todo) {
            updateSQL('wfh_todolist', 'todo_type=?', 'todo_token=?', array($dataAPI['newtype'], $dataAPI['token']));
            array_push($datareturn, $todo);
        }
    } else if ($type == 'AllEmp') {
        $datareturn = getDataSQLv1(1, 'SELECT * from user_emp_view where emp_status=1 order by emp_fname asc', array());
    } else if ($type == 'MyTeam1') {
        $datareturn = getDataSQLv1(1, 'SELECT todo_type ,SUM(todo_owner) FROM wfh_todolist GROUP BY todo_type ', array());
    }
    if ($type == 'ShowPositionEmp') {
        $condition = "";

        $datareturn = getDataSQLv1(1, "SELECT orgunit_name FROM  orgunit WHERE orgunit_status = 1  GROUP BY orgunit_name order by orgunit_name asc", array());

        // $datareturn = getDataSQLv1(1, "SELECT orgunit_name FROM orgunit WHERE orgunit_status = 1 ".$condition." GROUP BY orgunit_name", array());
    }

    return setDataReturn($code, $datareturn);
}

function GetTest($type, $dataAPI, $dataoption)
{
    global $dateNow, $browser, $keyAPI;
    $datareturn = array('Test_type' => [], 'it_type' => []);
    $codeReturn = 0;
    $empId = $_SESSION['emp_id'];
    // $data = array();
    if ($type == 'Test') {
        // $query = "SELECT * FROM user_emp_view where orgunit_name='IT Support' AND emp_status =1 ";
        $dataEmp = getDataSQLv1(1, "SELECT * FROM user_emp_view where orgunit_name='IT Support' AND emp_status =1 ", array());
        // $query = 'SELECT * FROM wfh_todolist where todo_owner =1';
        // $dataformemp = getDataSQLv1(1, $query, array());
        foreach ($dataEmp as $emp) {
            // $dataDoing = getDataSQLv1(1, 'SELECT * FROM wfh_todolist where todo_owner =1', array());
            // $dataDone = getDataSQLv1(1, 'SELECT * FROM wfh_todolist where todo_owner =1', array());
            $emp['todo'] = searchDataTodoByEmp($emp['emp_id'], 'todo');
            $emp['doing'] = searchDataTodoByEmp($emp['emp_id'], 'doing');
            $emp['done'] = searchDataTodoByEmp($emp['emp_id'], 'done');
            array_push($datareturn['Test_type'], $emp);
        }
        // foreach ($dataformemp as $form) {
        //     array_push($datareturn['it_type'], $form);
        // }
    }
    return setDataReturn($codeReturn, $datareturn);
}

function getemployee($type, $dataAPI, $dataoption)
{
    global $dateNow, $browser, $keyAPI;
    $datareturn = array();
    $codeReturn = 0;
    $empId = $_SESSION['emp_id'];
    // $data = array();
    if ($type == 'employee') {
        $condition = '';
        if ($dataAPI['filterDepartment'] != 'All') {
            $condition = " AND orgunit_name='" . $dataAPI['filterDepartment'] . "' ";
        }
        $start = $dataAPI['start'];
        $end = $dataAPI['end'];
        $search = "%" . $dataAPI['search'] . "%";
        $condition .= " AND ( emp_fname like '" . $search . "' ";
        $condition .= " OR emp_lname like '" . $search . "' ";
        $condition .= " OR emp_positionName like '" . $search . "' ";
        $condition .= " OR orgunit_name like '" . $search . "' ) ";
        // $condition.=" )' ";


        if($dataAPI['status']!='All'){
            $condition .= " AND date_status='" . $dataAPI['status'] . "' ";
        }


        // $dataEmp = getDataSQLv1(1, 'SELECT emp_id, emp_fname, emp_lname, orgunit_name, COUNT(date_requestid) AS request_ids
        // FROM wfh_requestDate
        // LEFT JOIN wfh_request ON date_requestid = request_id
        // LEFT JOIN user_emp_view ON request_to = emp_id
        // WHERE emp_status = 1 AND date_status = 2 '.$condition.' AND (date_select between ? AND ?)
        // GROUP BY emp_id, emp_fname, emp_lname, orgunit_name 
        // ORDER BY emp_fname ASC', array($start,$end));

        $dataEmp = getDataSQLv1(1, 'SELECT emp_id, emp_fname, emp_lname,emp_code, orgunit_name, COUNT(date_requestid) AS request_ids,emp_positionName
        FROM wfh_requestDate
        LEFT JOIN wfh_request ON date_requestid = request_id
        LEFT JOIN user_emp_view ON request_to = emp_id
        WHERE emp_status = 1 ' . $condition . ' AND (date_select between ? AND ?)
        GROUP BY emp_id, emp_fname, emp_lname, orgunit_name,emp_positionName,emp_code
        ORDER BY emp_fname ASC', array($start, $end));
        foreach ($dataEmp as $form) {
            $form['requestDate']  = getDataSQLv1(1, 'SELECT emp_fname,emp_code,emp_lname,[date_select]
            ,[date_remark]
            ,[date_remark2]
            ,[date_status]
            ,[date_select_from],request_type_select
            ,[date_select_to] FROM wfh_requestDate
            LEFT JOIN wfh_request ON date_requestid = request_id
            LEFT JOIN user_emp_view ON request_to = emp_id
            WHERE emp_status = 1  AND (date_select between ? AND ?) AND request_to=? 
            group by emp_fname,emp_code,emp_lname,[date_select]
            ,[date_remark]
            ,[date_remark2]
            ,[date_status]
            ,[date_select_from],request_type_select
            ,[date_select_to]
            ORDER BY date_select ASC', array($start, $end, $form['emp_id']));
            array_push($datareturn, $form);
        }
    }
    return setDataReturn($codeReturn, $datareturn);
}

function searchDataTodoByEmp($empId, $type)
{
    return getDataSQLv1(1, 'SELECT * FROM wfh_todoFor 
            left join wfh_todolist on for_todoid=todo_id
            where for_userid =? AND  for_status=1 AND todo_status=1 AND todo_type=?', array($empId, $type));
}
function searchDataWFHByEmpAndDate($empId, $date)
{
    return getDataSQLv1(1, 'SELECT * FROM wfh_requestDate 
            left join wfh_request on request_id=date_requestid
            where date_status=2 AND request_status=1 AND request_to=? AND date_select=?', array($empId, $date));
}

function GetEmployeeRequest($type, $dataAPI, $dataoption)
{
    global $dateNow, $browser, $keyAPI;
    $datareturn = array('employeeRequest1' => []);
    $codeReturn = 0;
    $empId = $_SESSION['emp_id'];
    // $data = array();0
    if ($type == 'employeeRequest') {
            $search = '%' . $dataAPI['search'] . '%';
            $start = $dataAPI['start'];
            $end = $dataAPI['end'];
            // $conditon = '';
            $conditon = ' AND ( ';
            $conditon .= " request_token like '" . $search . "' ";
            $conditon .= " OR request_remark like '" . $search . "' ";
            $conditon .= " OR emp_fname like '" . $search . "' ";
            $conditon .= " OR emp_lname like '" . $search . "' ";
            $conditon .= " OR emp_fname_th like '" . $search . "' ";
            $conditon .= " OR emp_lname_th like '" . $search . "' ";
            $conditon .= " OR emp_positionName like '" . $search . "' ";
            $conditon .= ' ) ';
            $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=request_to where request_status!=9 AND (request_create_at between ? AND ? ) AND emp_welapproved =? " . $conditon . " order by request_create_at desc", array($start, $end, $empId));
            // $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=request_to where request_status!=9 AND (request_create_at between ? AND ? )" . $conditon . " order by request_create_at desc", array($start, $end));
            foreach ($dataEmp as $form) {
                $datadate = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status!=9 AND date_requestid=?", array($form['request_id']));
                $datadateApprove = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=2 AND date_requestid=?", array($form['request_id']));
                $datadateReject = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=3 AND date_requestid=?", array($form['request_id']));
                $datadateCancel = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=4 AND date_requestid=?", array($form['request_id']));
                $datadateAllstatus = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status IN (2, 3, 4) AND date_requestid=?", array($form['request_id']));

                $form['date'] = $datadate;
                $form['dateApprove'] = $datadateApprove;
                $form['dateReject'] = $datadateReject;
                $form['dateCancel'] = $datadateCancel;
                $form['dateAllstatus'] = $datadateAllstatus;

                array_push($datareturn['employeeRequest1'], $form);
            }
        }else if ($type == 'employeeRequestAll') {
            $search = '%' . $dataAPI['search'] . '%';
            $start = $dataAPI['start'];
            $end = $dataAPI['end'];
            // $conditon = '';
            $conditon = ' AND ( ';
            $conditon .= " request_token like '" . $search . "' ";
            $conditon .= " OR request_remark like '" . $search . "' ";
            $conditon .= " OR emp_fname like '" . $search . "' ";
            $conditon .= " OR emp_lname like '" . $search . "' ";
            $conditon .= " OR emp_fname_th like '" . $search . "' ";
            $conditon .= " OR emp_lname_th like '" . $search . "' ";
            $conditon .= " OR emp_positionName like '" . $search . "' ";
            $conditon .= ' ) ';
          
            $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=request_to where request_status!=9 AND (request_create_at between ? AND ? )" . $conditon . " order by request_create_at desc", array($start, $end));
            foreach ($dataEmp as $form) {
                $datadate = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status!=9 AND date_requestid=?", array($form['request_id']));
                $datadateApprove = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=2 AND date_requestid=?", array($form['request_id']));
                $datadateReject = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=3 AND date_requestid=?", array($form['request_id']));
                $datadateCancel = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=4 AND date_requestid=?", array($form['request_id']));
                $datadateAllstatus = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status IN (2, 3, 4) AND date_requestid=?", array($form['request_id']));

                $form['date'] = $datadate;
                $form['dateApprove'] = $datadateApprove;
                $form['dateReject'] = $datadateReject;
                $form['dateCancel'] = $datadateCancel;
                $form['dateAllstatus'] = $datadateAllstatus;

                array_push($datareturn['employeeRequest1'], $form);
            }
        } else if ($type == 'HistoryEmployeeRequest') {
            $search = '%' . $dataAPI['search'] . '%';
            $start = $dataAPI['start'];
            $end = $dataAPI['end'];
            // $conditon = '';
            $conditon = ' AND ( ';
            $conditon .= " request_token like '" . $search . "' ";
            $conditon .= " OR request_remark like '" . $search . "' ";
            $conditon .= " OR emp_fname like '" . $search . "' ";
            $conditon .= " OR emp_lname like '" . $search . "' ";
            $conditon .= " OR emp_fname_th like '" . $search . "' ";
            $conditon .= " OR emp_lname_th like '" . $search . "' ";
            $conditon .= " OR emp_positionName like '" . $search . "' ";
            $conditon .= ' ) ';
            $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=requestor_id where request_status!=9 AND (request_create_at between ? AND ? ) AND request_to =?" . $conditon . " order by request_create_at desc", array($start, $end, $empId));
            foreach ($dataEmp as $form) {
                $datadate = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status!=9 AND date_requestid=?", array($form['request_id']));
                $datadateApprove = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=2 AND date_requestid=?", array($form['request_id']));
                $datadateReject = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=3 AND date_requestid=?", array($form['request_id']));
                $datadateCancel = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status=4 AND date_requestid=?", array($form['request_id']));
                $datadateAllstatus = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status IN (2, 3, 4) AND date_requestid=?", array($form['request_id']));

                $form['date'] = $datadate;
                $form['dateApprove'] = $datadateApprove;
                $form['dateReject'] = $datadateReject;
                $form['dateCancel'] = $datadateCancel;
                $form['dateAllstatus'] = $datadateAllstatus;

            array_push($datareturn['employeeRequest1'], $form);
        }
    }
    return setDataReturn($codeReturn, $datareturn);
}

function GetBtnApp_Rej($type, $dataAPI, $dataoption)
{
    global $dateNow, $browser, $keyAPI;
    $datareturn = array('App_ReJ_Btn' => []);
    $codeReturn = 0;
    $empId = $_SESSION['emp_id'];
    // $data = array();0
    if ($type == 'App_Rej') {
        $dataEmp = getDataSQLv1(1, "SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where date_status!=9
        ", array());
        foreach ($dataEmp as $form) {
            array_push($datareturn['App_ReJ_Btn'], $form);
        }
    }
    return setDataReturn($codeReturn, $datareturn);
}

function GetDetailRequest($type, $dataAPI, $dataoption)
{
    global $dateNow, $browser, $keyAPI;
    $datareturn = array();
    $codeReturn = 0;
    // $empId = $_SESSION['emp_id'];
    // $data = array();0
    if ($type == 'detailReq') {
        $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=request_to where request_status!=9 AND request_token=?", array($dataAPI['token']));
        foreach ($dataEmp as $form) {
            $datadate = getDataSQLv1(1, "SELECT * from wfh_requestDate 
                left join wfh_request on date_requestid=request_id
                left join user_emp_view on emp_id=request_to
                where date_status!=9 AND date_requestid=?", array($form['request_id']));
            $Approved = getDataSQLv1(1, "SELECT * from wfh_requestDate 
            left join wfh_request on date_requestid=request_id
            left join user_emp_view on emp_id=request_to
            where date_status=2 ", array());
            $form['Approved'] = $Approved;
            $form['date'] = $datadate;
            array_push($datareturn, $form);
        }
    } else if ($type == 'HeadDetail') {
        $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=request_to where request_status!=9 AND request_token=?", array($dataAPI['token']));
        foreach ($dataEmp as $form) {
            $datadate = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status!=9 AND date_requestid=?", array($form['request_id']));
            $form['date'] = $datadate;
            array_push($datareturn, $form);
        }
    } else if ($type == 'ApproveAll') {
        // $Approved = getDataSQLv1(1, "SELECT * from wfh_requestDate 
        //     left join wfh_request on date_requestid=request_id
        //     left join user_emp_view on emp_id=request_to where  date_id=?", array());

        $requestID = 0;
        foreach ($dataAPI['check'] as $date) {
            $dataRequest = getDataSQLv1(1, "SELECT date_requestid from wfh_requestDate where date_id=?", array($date));
            foreach ($dataRequest as $request) {
                $requestID = $request['date_requestid'];
                updateSQL('wfh_requestDate', 'date_status=?,date_remark=?', 'date_id=?', array($dataAPI['type'], $dataAPI['remark'], $date));
            }
        }
        if ($dataAPI['type'] == 2 || $dataAPI['type'] == 3) {
            sendEmailNotifyEmpOnApprove($requestID, $dataAPI['type'], $dataAPI['check'], $dataAPI['remark']);
        }else if($dataAPI['type'] == 4){
            sendEmailNotifyEmpOnCancel($requestID, $dataAPI['type'], $dataAPI['check'], $dataAPI['remark']);

        }

        array_push($datareturn, $dataAPI);
    } else if ($type == 'DetailHistoryEmp') {
        $datareturn = getDataSQLv1(1, 'SELECT * from wfh_requestDate  
        left join wfh_request on date_requestid=request_id
        left join user_emp_view on emp_id=request_to
        where date_status!=9
        ', array());
    }
    return setDataReturn($codeReturn, $datareturn);
}


function sendEmailNotifyEmpOnApprove($id, $type, $date, $remark)
{
    global $dateNow, $browser, $keyAPI;

    $arrStatus = array('', '', 'Approved', 'Rejected', 'Cancel');
    $wfh = getDataSQLv1(1, 'SELECT top 1 * from wfh_request 
    left join user_emp_view on requestor_id=emp_id
    where request_id=?', array($id));
    $d = array();
    $arrSelestType = array('','Special Case','Custom','Normal');
    foreach ($wfh as $request) {
        $token = $request['request_token'];
        $requestTo = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        foreach ($requestTo as $To) {
            $MgrEmail = $To['emp_email'];
            $MgrName = $To['emp_fname'] . " " . $request['emp_lname'];
            
            // $MgrEmail = 'tangjuradit969@gmail.com';
            // $MgrName = 'User Test';
            $dataAPITOServer8 = array(
                'toMail' => base64_encode($MgrEmail),
                'toName' => encrypt($keyAPI, base64_encode($MgrName)),
                'from' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' ' . $request['emp_lname'])),
                'subject' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' ' . $arrStatus[$type] . ' #' . $token .' ('.$arrSelestType[$request['request_type_select']].')'. ' - ' . $remark)),
                'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFHApproveNotify($token, $type, $date, $remark)))
            );
            $dt = callAPISendMail($dataAPITOServer8);
        }

        $request['to'] = $requestTo;
        array_push($d, $request);
    }
    return $d;
}

function sendEmailNotifyEmpOnCancel($id, $type, $date, $remark)
{
    global $dateNow, $browser, $keyAPI;

    $arrStatus = array('', '', 'Approved', 'Rejected', 'Cancel');
    $wfh = getDataSQLv1(1, 'SELECT top 1 * from wfh_request 
    left join user_emp_view on requestor_id=emp_id
    where request_id=?', array($id));
    $d = array();
    $arrSelestType = array('','Special Case','Custom','Normal');
    foreach ($wfh as $request) {
        $token = $request['request_token'];
        $requestTo = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));
        foreach ($requestTo as $To) {

            $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($To['emp_welapproved']));
            foreach ($Leader as $Mgr) {
                //ส่งEmailหาหัวหน้างาน
                $MgrEmail = $Mgr['emp_email'];
                $MgrName = $Mgr['emp_fname'];
                // $MgrEmail = 'tangjuradit969@gmail.com';
                // $MgrName = 'User Test';
                // $MgrName = 'User Test';
                $dataAPITOServer8 = array(
                    'toMail' => base64_encode($MgrEmail),
                    'toName' => encrypt($keyAPI, base64_encode($MgrName)),
                    'from' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' ' . $request['emp_lname'])),
                    'subject' => encrypt($keyAPI, base64_encode($request['emp_fname'] . ' ' . $arrStatus[$type] . ' #' . $token .' ('.$arrSelestType[$request['request_type_select']].')'. ' - ' . $remark)),
                    'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFHApproveNotify($token, $type, $date, $remark)))
                );
                $dt = callAPISendMail($dataAPITOServer8);
            }


        }

        $request['to'] = $requestTo;
        array_push($d, $request);
    }
    return $d;
}

