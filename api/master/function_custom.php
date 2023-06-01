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
        $token = 'RE' . date('ymd', time()) . new_token_uppercaseV2(4);
        insertSQL('wfh_request', '[requestor_id]
        ,[request_to]
        ,request_remark
        ,[request_create_at]
        ,[request_type]
        ,[request_quota]
        ,request_token', array($empId, $empId, $dataAPI['remark'], date('Y-m-d H:i:s', time()), 1, 1, $token));
        $wfh = getDataSQLv1(1, 'SELECT request_id from wfh_request  where request_token=?', array($token));
        foreach ($wfh as $request) {
            foreach ($dataAPI['date'] as $date) {
                insertSQL('wfh_requestDate', '[date_requestid],[date_select]', array($request['request_id'], $date));
                // createTimeline();
            }
            // array_push($datareturn, $request);
        }
        $mail = sendEmailForApprove($token);
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
    foreach ($wfh as $request) {
        $requestTo = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));

        foreach ($requestTo as $To) {
            $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($To['emp_welapproved']));
            foreach ($Leader as $Mgr) {
                //ส่งEmailหาเมลตัวหน้างาน
            }
        }
        // if ($request['request_type'] == 2) {
        //     // send mail requestor and request to;
        // } else {
        //     // send to my email
        //     $Leader = getDataSQLv1(1, 'SELECT top 1 * from user_emp_view  where emp_id=?', array($request['request_to']));


        // }
        // ส่งให้ตัวเอง
        $dataAPITOServer8 = array(
            'toMail' => base64_encode($request['emp_email']),
            'toName' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
            'from' => encrypt($keyAPI, base64_encode($request['emp_fname'])),
            'subject' => encrypt($keyAPI, base64_encode('ยืนยันคำขอ Work From Home #' . $token)),
            'html' => encrypt($keyAPI, base64_encode(createFormEmailRequestWFH($token)))
        );
        $dt = callAPISendMail($dataAPITOServer8);
        $request['email'] = $dt;
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
    $datareturn = array('Test_type' => []);
    $codeReturn = 0;
    $empId = $_SESSION['emp_id'];
    // $data = array();
    if ($type == 'employee') {
        $dataEmp = getDataSQLv1(1, "SELECT * FROM wfh_requestDate left join wfh_request on date_requestid=request_id  left join user_emp_view on request_to=emp_id where emp_status =1 AND date_status=2", array());
        foreach ($dataEmp as $form) {
            array_push($datareturn['Test_type'], $form);
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

function GetEmployeeRequest($type, $dataAPI, $dataoption)
{
    global $dateNow, $browser, $keyAPI;
    $datareturn = array('employeeRequest1' => []);
    $codeReturn = 0;
    $empId = $_SESSION['emp_id'];
    // $data = array();0
    if ($type == 'employeeRequest') {
        $dataEmp = getDataSQLv1(1, "SELECT * from wfh_request left join user_emp_view on emp_id=request_to where request_status!=9", array());
        foreach ($dataEmp as $form) {
            $datadate = getDataSQLv1(1, "SELECT * from wfh_requestDate where date_status!=9 AND date_requestid=?", array($form['request_id']));
            $form['date'] = $datadate;
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
        foreach ($dataAPI['check'] as $date) {
            updateSQL('wfh_requestDate', 'date_status=?', 'date_id=?', array($dataAPI['type'], $date));
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