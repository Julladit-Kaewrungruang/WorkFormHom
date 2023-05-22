<?php
$dateNow = date('Y-m-d  H:i:s',time());
$browser = $_SERVER['HTTP_USER_AGENT'];

function saveSurvey($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if($type=='reply'){
    $dataAPI = json_decode($dataAPI);
    $customerToken = 'Other';
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status=1 AND token=? limit 1',array($dataAPI->token));
    // foreach($questionGroupType AS $survey){
    if(count($questionGroupType)>0){
      $survey = $questionGroupType[0];
      // if($survey['replyType']==1){
      //   // ส่งแบบสอบถามตามรายการ เจาะจงผู้รับ // ค้นหา
      //   $dataCustomer = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where token=? AND cs_status=1 limit 1',array($dataAPI->customer));
      //   if(count($dataCustomer)>0){
      //       $dataCustomer=$dataCustomer[0];
            
      //   }else{
      //       // ไม่พบข้อมูล
      //   }

      // }else{
      //   // ส่งแบบสอบถาม แบบไม่เจาะจงผู้รับ
      // }

      if($dataAPI->customer!='Other'){$customerToken=$dataAPI->customer;}
      // $dataCustomer = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where token=? AND cs_status=1 limit 1',array($dataAPI->customer));
    
      $newTokenResponse = time().'.'.new_token(5).'.'.md5($customerToken);
      // survey_response
      insertSQL('survey_response','userToken,date,token,device,status,groupTypeId,completed',array($customerToken,$dateNow,$newTokenResponse,$browser,1,$survey['id'],1));
      $survey_response = getDataSQLv1(1,'SELECT * FROM survey_response where status=1 AND token=? AND groupTypeId=? limit 1',array($newTokenResponse,$survey['id']));
      if(count($survey_response)>0){
        $response = $survey_response[0];
        foreach($dataAPI->reply AS $reply){
          $questions = getDataSQLv1(1,'SELECT * FROM survey_question where status=1 AND token=? limit 1',array($reply->token));
          if(count($questions)>0){
            $question = $questions[0];
            foreach($reply->arr AS $ans){
              // loop choice
              $ans =checkTextSQLv3($ans);
              // $cs_name = encrypt($keyAPI,base64_encode($account->Name));
              insertSQL('survey_response_detail','responseId,questionId,answer,ansType,status',array($response['id'],$question['id'],$ans,$question['questiontype'],1));
            }
            // insertSQL('survey_response_detail','responseId,questionId,answer,selectedId,status',array($response['id'],$question['id'],$reply->,,1));
          }
          
        }

        // $survey_response = getDataSQLv1(1,'SELECT * FROM survey_response where status=1 AND token=? limit 1',array($newTokenResponse));


        
        updateSQL('survey_mailaccount','cs_status_response=?','token=?',array(time(),$customerToken));

      }


      
      // array_push($data,$survey);
    }else{
      $codeReturn = 404;
    }





  }else if($type=='manageSurvey'){
    $dataAPI = json_decode($dataAPI);
    $token = $dataAPI->token;
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where  token=? limit 1',array($token));
    if(count($questionGroupType)>0){
      $survey = $questionGroupType[0];
      // update
      updateSQL('survey_question_grouptype','title=?,description=?,descriptionShow=?,txtcompleted=?,txtcompleted_description=?,replyType=?,htmlEmail=?,subjectEmail=?','token=?'
      ,array($dataAPI->title,$dataAPI->description,$dataAPI->descriptionShow,$dataAPI->Txtcompleted,$dataAPI->Txtcompleted_description,$dataAPI->type,$dataAPI->html,$dataAPI->subjectEmail,$token));
    }else{
      // $codeReturn = 404;
      // insert new 
      $token = new_token(6);
      insertSQL('survey_question_grouptype','title,description,descriptionShow,txtcompleted,txtcompleted_description,token,replyType,status,htmlEmail,subjectEmail'
      ,array($dataAPI->title,$dataAPI->description,$dataAPI->descriptionShow,$dataAPI->Txtcompleted,$dataAPI->Txtcompleted_description,$token,$dataAPI->type,1,$dataAPI->html,$dataAPI->subjectEmail));
    }

    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where  token=? limit 1',array($token));
    if(count($questionGroupType)>0){
      $survey = $questionGroupType[0];
      updateSQL('survey_question','status=?','grouptype=?',array(9,$survey['id']));
      foreach($dataAPI->question AS $question){
        // insert Questions
          $questionArr = getDataSQLv1(1,'SELECT * FROM survey_question where  token=? limit 1',array($question->token));
          if(count($questionArr)>0){
            // update
            updateSQL('survey_question','question=?,questiontype=?,showListChoice=?,required=?,grouptype=?,status=?','token=?'
            ,array($question->Question,$question->questiontype,$question->showListChoice,1,$survey['id'],1,$question->token));
          }else{
            // insert
            insertSQL('survey_question','question,questiontype,showListChoice,required,token,grouptype,status'
            ,array($question->Question,$question->questiontype,$question->showListChoice,1,$question->token,$survey['id'],1));
          }

          $questionArr = getDataSQLv1(1,'SELECT * FROM survey_question where  token=? limit 1',array($question->token));
          if(count($questionArr)>0){
            $questionId = $questionArr[0]['id'];
            // $questionArr = getDataSQLv1(1,'SELECT * FROM survey_question where  token=? limit 1',array($question->token));
            updateSQL('survey_choice','status=?','questionid=?',array(9,$questionId));

            foreach($question->choices AS $choice){
              $choiceArr = getDataSQLv1(1,'SELECT * FROM survey_choice where  token=? limit 1',array($choice->token));
              if(count($choiceArr)>0){
                //update
                updateSQL('survey_choice','questionid=?,choice=?,choice_score=?,status=?','token=?',array($questionId,$choice->choice,$choice->score,$choice->status,$choice->token));
              }else{
                // insert
                insertSQL('survey_choice','questionid,choice,choice_score,token,status' ,array($questionId,$choice->choice,$choice->score,$choice->token,$choice->status));
              }


            }

          }

      }
      array_push($data,$survey);

    }





  }else if($type=='AddEmailAccount'){
    $dataAPI = json_decode($dataAPI);
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where  token=? limit 1',array($dataAPI->token));
    if(count($questionGroupType)>0){
      $survey = $questionGroupType[0];
      foreach($dataAPI->data AS $account){
        $token = new_token(12);
        $cs_name = encrypt($keyAPI,base64_encode($account->Name));
        $cs_nameEng = encrypt($keyAPI,base64_encode($account->NameEng));
        $cs_company = encrypt($keyAPI,base64_encode($account->CompanyName));
        $cs_no = encrypt($keyAPI,base64_encode($account->no));
        $cs_mail = base64_encode($account->Email);
        $SalesPersonName = encrypt($keyAPI,base64_encode($account->SalesPersonName));
        $SalesPersonNameEng = encrypt($keyAPI,base64_encode($account->SalesPersonNameEng));
        $EmailSalesPerson = encrypt($keyAPI,base64_encode($account->EmailSalesPerson));

        // $cs_mail = base64_decode(decrypt($keyAPI,$cs_mail));

        $accountArr = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where  cs_type=? AND cs_status=1 AND cs_mail=? limit 1',array($survey['id'],$cs_mail));
        
        


        
        if(count($accountArr)>0){
          //update
          $token = $accountArr[0]['token'];
          updateSQL('survey_mailaccount','cs_name=?,cs_nameEng=?,cs_company=?,cs_no=?,cs_mail=?,cs_type=?,SalesPersonName=?,SalesPersonNameEng=?,EmailSalesPerson=?','token=?',
          array($cs_name,$cs_nameEng,$cs_company,$cs_no,$cs_mail,$survey['id'],$SalesPersonName,$SalesPersonNameEng,$EmailSalesPerson,$token));

        }else{
          // insert

          


          insertSQL('survey_mailaccount','token,cs_name,cs_nameEng,cs_company,cs_no,cs_mail,cs_type,SalesPersonName,SalesPersonNameEng,EmailSalesPerson,cs_status_sent,cs_status_response,cs_status'
          ,array($token,$cs_name,$cs_nameEng,$cs_company,$cs_no,$cs_mail,$survey['id'],$SalesPersonName,$SalesPersonNameEng,$EmailSalesPerson,0,0,1));

        }
      }

      array_push($data,$survey);



    }
    
  }else if($type=='reply_one'){
    $dataAPI = json_decode($dataAPI);
    $customerToken = 'Other';
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status=1 AND token=? limit 1',array($dataAPI->DATA_tokenSurvey));
    // foreach($questionGroupType AS $survey){
    if(count($questionGroupType)>0){
      $survey = $questionGroupType[0];
      if($dataAPI->DATA_tokenCustomer!='Other'){$customerToken=$dataAPI->DATA_tokenCustomer;}
      // $dataCustomer = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where token=? AND cs_status=1 limit 1',array($dataAPI->customer));
    
      $newTokenResponse = $dataAPI->newToken;
      $survey_response = getDataSQLv1(1,'SELECT * FROM survey_response where status=1 AND token=? AND groupTypeId=? limit 1',array($newTokenResponse,$survey['id']));
      if(count($survey_response)==0){
      // survey_response
        insertSQL('survey_response','userToken,date,token,device,status,groupTypeId',array($customerToken,$dateNow,$newTokenResponse,$browser,1,$survey['id']));
      }


      $survey_response = getDataSQLv1(1,'SELECT * FROM survey_response where status=1 AND token=? AND groupTypeId=? limit 1',array($newTokenResponse,$survey['id']));
      if(count($survey_response)>0){
        $response = $survey_response[0];
        $questions = getDataSQLv1(1,'SELECT * FROM survey_question where status=1 AND token=? limit 1',array($dataAPI->QuestionToken));
        if(count($questions)>0){
          $question = $questions[0];
          foreach($dataAPI->choiceToken AS $ans){
            $ans =checkTextSQLv3($ans);
            $answer = getDataSQLv1(1,'SELECT * FROM survey_response_detail where responseId=? AND questionId=?', array($response['id'],$question['id']));
            if(count($answer)>0){
              updateSQL('survey_response_detail','answer=?','responseId=? AND questionId=? AND status=1',array($ans,$response['id'],$question['id']));
            }else{
              insertSQL('survey_response_detail','responseId,questionId,answer,ansType,status',array($response['id'],$question['id'],$ans,$question['questiontype'],1));
            }

          }
        }
      array_push($data,$questions);

      }



     


      
    }else{
      $codeReturn = 404;
    }
  }


  
  return setDataReturn($codeReturn,$data);;
}

function getSurvey($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI;
  $datareturn = array();
  $codeReturn = 0;

  $data = array();
  if($type=='all'){
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status!=9',array());
    foreach($questionGroupType AS $survey){
      $survey['reply']=countColumn('survey_response WHERE groupTypeId=? AND status=1 AND completed=1',array($survey['id']));
      array_push($data,$survey);
    }
  }else if($type=='switchStatusSurvey'){
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status!=9 AND token=? limit 1',array($dataAPI));
    foreach($questionGroupType AS $survey){
      updateSQL('survey_question_grouptype','status=?','token=?',array($survey['status']==1?0:1,$dataAPI));
      array_push($data,$survey);
    }
  }else if($type=='GetdataSurveyByToken'){
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status!=9 AND token=? limit 1',array($dataAPI));
    foreach($questionGroupType AS $survey){
      $questions = getDataSQLv1(1,'SELECT * FROM survey_question where grouptype=? AND status!=9',array($survey['id']));
      $replacetag = getDataSQLv1(1,'SELECT * FROM survey_replacetag where forGroupType=? AND status!=9',array($survey['id']));
      $arrQuestion = array();
      foreach($questions AS $question){
        $Choices = getDataSQLv1(1,'SELECT * FROM survey_choice where questionid=? AND status!=9',array($question['id']));
        $question['choice']=$Choices;
        array_push($arrQuestion,$question);
      }
      $survey['questions']=$arrQuestion;
      $survey['replacetag']=$replacetag;

      array_push($data,$survey);
    }
  }else if($type=='getDataReplyByTokenSurvey'){
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status!=9 AND token=? limit 1',array($dataAPI));
    foreach($questionGroupType AS $survey){
      $survey_response = getDataSQLv1(1,'SELECT 
      reply.id,
      reply.date,
      mail.cs_name,
      mail.cs_mail
      ,mail.cs_status_sent
      ,mail.cs_status_response
      ,mail.id AS cs_id
      ,mail.cs_company as company
      ,mail.cs_nameEng
      ,mail.SalesPersonName
      ,mail.SalesPersonNameEng
      ,mail.EmailSalesPerson
      ,mail.cs_no
      FROM survey_response as reply
      left join survey_mailaccount as mail 
      on reply.userToken=mail.token  where reply.status=1 AND reply.groupTypeId=? AND reply.completed=1',array($survey['id']));
      $arrReply = array();
      $questions = getDataSQLv1(1,'SELECT * FROM survey_question where grouptype=? AND status=1',array($survey['id']));
      foreach($survey_response AS $reply){

        $reply['cs_mail']=base64_decode($reply['cs_mail']);
        // $reply['cs_name']=base64_decode(decrypt($keyAPI,$reply['cs_name']));
        $reply['cs_name'] = base64_decode(decrypt($keyAPI,$reply['cs_name']));
        $reply['company']=base64_decode(decrypt($keyAPI,$reply['company']));
        $reply['cs_nameEng']=base64_decode(decrypt($keyAPI,$reply['cs_nameEng']));
        $reply['SalesPersonName']=base64_decode(decrypt($keyAPI,$reply['SalesPersonName']));
        $reply['SalesPersonNameEng']=base64_decode(decrypt($keyAPI,$reply['SalesPersonNameEng']));
        $reply['EmailSalesPerson']=base64_decode(decrypt($keyAPI,$reply['EmailSalesPerson']));
        $reply['cs_no']=base64_decode(decrypt($keyAPI,$reply['cs_no']));

        
        $arrAns = array();
        foreach($questions AS $question){
          $dataReplyDetail = getDataSQLv1(1,'SELECT * FROM survey_response_detail  where responseId=? AND questionId=? AND status=1',array($reply['id'],$question['id']));
          $dataAnsDetail = array();
          if($question['questiontype']==1 || $question['questiontype']==2){
            foreach($dataReplyDetail AS $detail){
              
              $ans = getDataSQLv1(1,'SELECT * FROM survey_choice  where questionid=? AND token=? AND status=1',array($question['id'],$detail['answer']));
              $detail['ans']=$ans;
              array_push($dataAnsDetail,$detail);

            }
          }
          
          array_push($arrAns,$dataAnsDetail);
        }

        $reply['reply'] = $arrAns;
        array_push($arrReply,$reply);
      }
      

      $survey['questions']=$questions;
      $survey['reply']=$arrReply;
      array_push($data,$survey);
    }
  }else if($type=='getDataReplyByAccount'){
    $accounts = getDataSQLv1(1,'SELECT mail.token as mailToken
    ,mail.cs_name
    ,mail.cs_mail
    ,mail.cs_status_sent
    ,mail.cs_status_response
    ,mail.id AS cs_id
    ,mail.cs_company as company
    ,mail.cs_nameEng
    ,mail.SalesPersonName
    ,mail.SalesPersonNameEng
    ,mail.EmailSalesPerson
    ,followup
    ,followupby
    ,followupRemark
    ,mail.cs_no
     FROM survey_mailaccount as mail
    left join survey_question_grouptype as survey on survey.id=mail.cs_type where mail.cs_status=1 AND survey.token=? ',array($dataAPI));
    foreach($accounts AS $mail){
      // $cs_mail = base64_decode(decrypt($keyAPI,$cs_mail));
      $mail['cs_name']=base64_decode(decrypt($keyAPI,$mail['cs_name']));
      $mail['company']=base64_decode(decrypt($keyAPI,$mail['company']));
      $mail['cs_nameEng']=base64_decode(decrypt($keyAPI,$mail['cs_nameEng']));
      $mail['SalesPersonName']=base64_decode(decrypt($keyAPI,$mail['SalesPersonName']));
      $mail['SalesPersonNameEng']=base64_decode(decrypt($keyAPI,$mail['SalesPersonNameEng']));
      $mail['EmailSalesPerson']=base64_decode(decrypt($keyAPI,$mail['EmailSalesPerson']));
      $mail['cs_no']=base64_decode(decrypt($keyAPI,$mail['cs_no']));



      $mail['cs_mail']=base64_decode($mail['cs_mail']);
      array_push($data,$mail);
    }
  }else if($type=='getDataReplyByTokenSurvey_Questions'){
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where status=1 AND token=? limit 1',array($dataAPI));
    foreach($questionGroupType AS $survey){
      $questions = getDataSQLv1(1,'SELECT * FROM survey_question where grouptype=? AND status=1',array($survey['id']));
      // $replacetag = getDataSQLv1(1,'SELECT * FROM survey_replacetag where forGroupType=? AND status!=9',array($survey['id']));
      $arrQuestion = array();
      foreach($questions AS $question){
        $Choices = getDataSQLv1(1,'SELECT * FROM survey_choice where questionid=? AND status=1',array($question['id']));
        $arrChoice = array();
        foreach($Choices AS $choice){
          $reply = getDataSQLv1(1,'SELECT count(*) as num FROM survey_response_detail as detail
          left join survey_response as reply on detail.responseId=reply.id 
          where reply.groupTypeId=? 
          AND reply.completed=1
          AND detail.questionId=?
          AND detail.answer=?
          AND detail.status=1
          ',array($survey['id'],$question['id'],$choice['token']));
          $choice['reply']=$reply;
          array_push($arrChoice,$choice);
        }
        $question['choice']=$arrChoice;
        array_push($arrQuestion,$question);
      }
      $survey['questions']=$arrQuestion;
      // $survey['replacetag']=$replacetag;
      // $survey_response = getDataSQLv1(1,'SELECT 
      // reply.date,
      // users.cs_name
      //  FROM survey_response as reply
      // left join survey_mailaccount as users on reply.userToken=users.token  where reply.status=1 AND reply.groupTypeId=?',array($survey['id']));
      // $arrReply = array();
      // foreach($survey_response AS $reply){
      //   array_push($arrReply,$reply);
      // }

      // $survey['reply']=$arrReply;
      array_push($data,$survey);
    }
  }


 
  return setDataReturn($codeReturn,$data);
}


function sentEmailFunction($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI;
  $data = array();
  $codeReturn = 0;
  if($type=='SentEmailByUser'){
    $dataAPI = json_decode($dataAPI);
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where  token=? limit 1',array($dataAPI->token));
    foreach($questionGroupType AS $survey){
      $ArrReplacetag = getDataSQLv1(1,'SELECT * FROM survey_replacetag where  forGroupType=? AND status=1',array($survey['id']));
      $countSent=0;
      $countSent_html="";

      foreach($dataAPI->arrEmail AS $emailToken){
        $accountArr = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where  cs_type=? AND cs_status=1 AND token=? limit 1',array($survey['id'],$emailToken));
        foreach($accountArr AS $email){
          $tagHTML_Email = $survey['htmlEmail'];
          $subjectEmail =  $survey['subjectEmail'];
          foreach($ArrReplacetag AS $replace){
            $phpnew = '';
            $subjectEmailNew = '';
            if($replace['RefTable']=='survey_mailaccount'){
              // ถอดรหัสข้อมูล
              $newDataSQL = $email[$replace['new']];
              $newDataSQL_subjectEmail = $email[$replace['new']];
              if($replace['new']=='cs_mail'){
                $newDataSQL = base64_decode($newDataSQL);
                $newDataSQL_subjectEmail = base64_decode($newDataSQL_subjectEmail);
              }else if(
                $replace['new']=='cs_name' || 
                $replace['new']=='cs_nameEng' || 
                $replace['new']=='cs_company' || 
                $replace['new']=='cs_no' || 
                $replace['new']=='SalesPersonName' ||
                $replace['new']=='SalesPersonNameEng' || 
                $replace['new']=='EmailSalesPerson'
                ){
                  $newDataSQL = base64_decode(decrypt($keyAPI,$newDataSQL));
                  $newDataSQL_subjectEmail = base64_decode(decrypt($keyAPI,$newDataSQL_subjectEmail));

              }else{
                // $newDataSQL = base64_decode(decrypt($keyAPI,$newDataSQL));
              }
              $phpnew = $newDataSQL;
              $subjectEmailNew = $newDataSQL_subjectEmail;
            }else if($replace['RefTable']=='survey_question_grouptype'){
              $phpnew = $survey[$replace['new']];
              $subjectEmailNew = $survey[$replace['new']];
            }
            // $phpnew = "$".$replace['new']."";
            $tagHTML_Email = str_replace($replace['old'],$phpnew,$tagHTML_Email);
            $subjectEmail = str_replace($replace['old'],$subjectEmailNew,$subjectEmail);
          }

          
            // เรียกใช้ function ส่ง sent Email ตรงนี้
            // $from_ = 'BTM Survey';
            // $arrTo_ = array();
            // array_push($arrTo_,array('mail'=>base64_decode($email['cs_mail']),'name'=>base64_decode(decrypt($keyAPI,$email['cs_name']))));
            // $sent = sendmailToEmp($from_,$arrTo_,$subjectEmail,$tagHTML_Email);
            // array_push($data,array('status'=>$sent));
            
            $dataAPITOServer8 = array(
              'toMail'=>$email['cs_mail'],
              'toName'=>$email['cs_name'],
              'subject'=>encrypt($keyAPI,base64_encode($subjectEmail)),
              'html'=>encrypt($keyAPI,base64_encode($tagHTML_Email))
            );
            $connectAPI =callAPISendMail($dataAPITOServer8);
            // $connectAPI=json_decode($connectAPI);


            // if($connectAPI->data=='true'){
              // เรียกใช้ api
              array_push($data,array('output'=>$connectAPI));
              // array_push($data,array('status'=>$dataAPITOServer8));
              $countSent++;
              $countSent_html .=base64_decode($email['cs_mail']).' -> '.base64_decode(decrypt($keyAPI,$email['cs_name'])).'<br>';
              updateSQL('survey_mailaccount','cs_status_sent=?,cs_log=?','token=?',array(time(),json_encode($connectAPI),$emailToken));
              
            // }
           
           
            



        }

      }

      if($countSent>0){
        $dataAPITOServer8 = array(
          'toMail'=>base64_encode('patipan@btm.co.th'),
          'toName'=>encrypt($keyAPI,base64_encode('Admin BT Survey')),
          'subject'=>encrypt($keyAPI,base64_encode('Log Sent Email')),
          'html'=>encrypt($keyAPI,base64_encode('<b>Sent Email by '.base64_decode($_SESSION['loginAd']['name']).' Completed '.$dateNow.'</b><br>'.$countSent_html))
        );
        // เรียกใช้ api
        $df = callAPISendMail($dataAPITOServer8);
  
      }
    
      



      // array_push($data,$tagHTML_Email);
    }



  }else if($type=='newCustomer'){
    $questionGroupType = getDataSQLv1(1,'SELECT * FROM survey_question_grouptype where  token=? limit 1',array($dataAPI['token']));
    if(count($questionGroupType)>0){
      $survey = $questionGroupType[0];

      $Newtoken = new_token(12);
      $cs_name = encrypt($keyAPI,base64_encode($dataAPI['name']));
      $cs_nameEng = encrypt($keyAPI,base64_encode($dataAPI['name']));
      $cs_company = encrypt($keyAPI,base64_encode($dataAPI['csName']));
      $cs_no = encrypt($keyAPI,base64_encode('CD-0000'));
      $cs_mail = base64_encode($dataAPI['email']);
      $SalesPersonName = encrypt($keyAPI,base64_encode($dataAPI['phone']));
      $SalesPersonNameEng = encrypt($keyAPI,base64_encode('-'));
      $EmailSalesPerson = encrypt($keyAPI,base64_encode('-'));

      // // $cs_mail = base64_decode(decrypt($keyAPI,$cs_mail));
      $accountArr = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where  cs_type=? AND cs_status=1 AND cs_mail=? limit 1',array($survey['id'],$cs_mail));
      if(count($accountArr)>0){
        $Newtoken =$accountArr[0]['token'];
        $data = array('new'=>0,'data'=>$accountArr[0]);
        $codeReturn=200;
      }else{
        insertSQL('survey_mailaccount','token,cs_name,cs_nameEng,cs_company,cs_no,cs_mail,cs_type,SalesPersonName,SalesPersonNameEng,EmailSalesPerson,cs_status_sent,cs_status_response,cs_status'
        ,array($Newtoken,$cs_name,$cs_nameEng,$cs_company,$cs_no,$cs_mail,$survey['id'],$SalesPersonName,$SalesPersonNameEng,$EmailSalesPerson,0,0,1));
        $data = array('new'=>1,'data'=>$Newtoken);
        $codeReturn=200;
      }

      if($dataAPI['requestSent']==1){
          // sendEmail 
          $ArrReplacetag = getDataSQLv1(1,'SELECT * FROM survey_replacetag where  forGroupType=? AND status=1',array($survey['id']));
          $countSent=0;
          $countSent_html="";

          $accountArr = getDataSQLv1(1,'SELECT * FROM survey_mailaccount where  cs_type=? AND cs_status=1 AND token=? limit 1',array($survey['id'],$Newtoken));
          foreach($accountArr AS $email){
            $tagHTML_Email = $survey['htmlEmail'];
            $subjectEmail =  $survey['subjectEmail'];

            foreach($ArrReplacetag AS $replace){
              $phpnew = '';
              $subjectEmailNew = '';
              if($replace['RefTable']=='survey_mailaccount'){
                // ถอดรหัสข้อมูล
                $newDataSQL = $email[$replace['new']];
                $newDataSQL_subjectEmail = $email[$replace['new']];
                if($replace['new']=='cs_mail'){
                  $newDataSQL = base64_decode($newDataSQL);
                  $newDataSQL_subjectEmail = base64_decode($newDataSQL_subjectEmail);
                }else if(
                  $replace['new']=='cs_name' || 
                  $replace['new']=='cs_nameEng' || 
                  $replace['new']=='cs_company' || 
                  $replace['new']=='cs_no' || 
                  $replace['new']=='SalesPersonName' ||
                  $replace['new']=='SalesPersonNameEng' || 
                  $replace['new']=='EmailSalesPerson'
                  ){
                    $newDataSQL = base64_decode(decrypt($keyAPI,$newDataSQL));
                    $newDataSQL_subjectEmail = base64_decode(decrypt($keyAPI,$newDataSQL_subjectEmail));
  
                }else{
                  // $newDataSQL = base64_decode(decrypt($keyAPI,$newDataSQL));
                }
                $phpnew = $newDataSQL;
                $subjectEmailNew = $newDataSQL_subjectEmail;
              }else if($replace['RefTable']=='survey_question_grouptype'){
                $phpnew = $survey[$replace['new']];
                $subjectEmailNew = $survey[$replace['new']];
              }
              // $phpnew = "$".$replace['new']."";
              $tagHTML_Email = str_replace($replace['old'],$phpnew,$tagHTML_Email);
              $subjectEmail = str_replace($replace['old'],$subjectEmailNew,$subjectEmail);
            }


            $dataAPITOServer8 = array(
              'toMail'=>$email['cs_mail'],
              'toName'=>$email['cs_name'],
              'subject'=>encrypt($keyAPI,base64_encode($subjectEmail)),
              'html'=>encrypt($keyAPI,base64_encode($tagHTML_Email))
            );
            $connectAPI =callAPISendMail($dataAPITOServer8);
            // $connectAPI=json_decode($connectAPI);
            // if($connectAPI->data=='true'){
            //   // เรียกใช้ api
              
            //   // array_push($data,array('status'=>$dataAPITOServer8));
            //   // $countSent++;
              $countSent_html .=base64_decode($email['cs_mail']).' -> '.base64_decode(decrypt($keyAPI,$email['cs_name'])).'<br>';
              updateSQL('survey_mailaccount','cs_status_sent=?,cs_log=?','token=?',array(time(),base64_decode($_SESSION['loginAd']['name']).' - '.json_encode($connectAPI),$Newtoken));

              // updateSQL('survey_mailaccount','followup=?,followupby=?,followupRemark=?','token=?',array(time(),base64_decode($_SESSION['loginAd']['name']),$dataAPI['remark'],$dataAPI['token']));

            // }
     
              // $dataAPITOServer8 = array(
              //   'toMail'=>base64_encode('patipan@btm.co.th'),
              //   'toName'=>encrypt($keyAPI,base64_encode('Admin BT Survey')),
              //   'subject'=>encrypt($keyAPI,base64_encode('Log Sent Email')),
              //   'html'=>encrypt($keyAPI,base64_encode('<b>Sent Email by '.base64_decode($_SESSION['loginAd']['name']).' Completed (AddNew)'.$dateNow.'</b><br>'.$countSent_html))
              // );
              // // เรียกใช้ api
              // $df = callAPISendMail($dataAPITOServer8);
        
            



            array_push($data,array('output'=>$connectAPI));

          }
      }

    }
  }



  return setDataReturn($codeReturn,$data);
}

function sentEmailFunction_Public($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI;
  $data = array();
  $codeReturn = 0;
  if($type=="random"){
    $accountArr = getDataSQLv1(1,'SELECT mail.token FROM survey_mailaccount  as mail
    left join survey_question_grouptype as grouptype on mail.cs_type=grouptype.id
    where  grouptype.token=? AND grouptype.status=1 AND mail.cs_status=1 AND (mail.cs_status_sent=0 AND cs_status_response=0)
    order by mail.id asc
    limit ?',array($dataAPI['survey'],$dataAPI['limit']));
    
    $arrAcc = array();
    foreach($accountArr AS $account){
      array_push($arrAcc,$account['token']);
    }

    if(count($accountArr)>0){
      $codeReturn = 200;
      $dataP = array('token'=>$dataAPI['survey'],'arrEmail'=>$arrAcc);
      $dataP = json_encode($dataP);
      $data = sentEmailFunction('SentEmailByUser',$dataP,0);
    }else{
      $codeReturn = 404;
    }

    

    // $data =  array('token'=>$dataAPI['survey'],'arrEmail'=>$arrAcc);
    // array();

  }


  return setDataReturn($codeReturn,$data);
}




function auth($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI,$arrAllowEmailAccount;
  $data = array();

  $codeReturn = 0;
  if($type=='otp'){
    // $data = $arrAllowEmailAccount;
    $codeReturn=403;
    foreach($arrAllowEmailAccount AS $admin){
      if(base64_encode($dataAPI['mail'])==$admin['mail'] && base64_encode($dataAPI['empcode'])==$admin['code']){
        $OTP = new_otp(6);
        $OTPToken = new_token(6);

        $dataAPITOServer8 = array(
            'toMail'=>$admin['mail'],
            'toName'=>encrypt($keyAPI,base64_encode('Admin BT Survey')),
            'subject'=>encrypt($keyAPI,base64_encode('AuthCode : '.$OTP)),
            'html'=>encrypt($keyAPI,base64_encode('<b>Your authentication token code is '.$OTP.'.</b><br>หากไม่ได้ทำรายการ โปรดติดต่อฝ่าย IT 350-354 ด่วนที่สุด เนื่องจากอาจมีผู้ไม่หวังดี ต้องการเข้าถึงข้อมูลของท่าน'))
          );
          // เรียกใช้ api
          $_SESSION['tokenLogin____request']=$OTP;
          $_SESSION['tokenLogin____request_mail']=$admin['mail'];
          
          $dt = callAPISendMail($dataAPITOServer8);
          $data = array('otp'=>$OTPToken,'sent'=>$dt);
          $codeReturn=200;
      }
    }
    

   
  }else if($type=='checkLogin'){
    $data = array('otp'=>$dataAPI['mail']);
    if($dataoption==$_SESSION['tokenLogin____request'] && base64_encode($dataAPI['mail'])==$_SESSION['tokenLogin____request_mail']){
      foreach($arrAllowEmailAccount AS $admin){
        if(base64_encode($dataAPI['mail'])==$admin['mail'] && base64_encode($dataAPI['empcode'])==$admin['code']){
          $_SESSION['tokenLogin_role'] = $admin['role'];
          $_SESSION['loginAd']=$admin;
          $_SESSION['tokenLogin'] = base64_encode($dataAPI['mail']).'.'.$_SESSION['tokenLogin____request'].'.'.new_token(120);
          $codeReturn=200;
        }
      }
      
      
    }else{
      $codeReturn=403;
    }
  }

  return setDataReturn($codeReturn,$data);
}





function followUp($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI,$arrAllowEmailAccount;
  $data = array();
  $codeReturn = 0;
  if($type=='followUpRemark'){
    updateSQL('survey_mailaccount','followup=?,followupby=?,followupRemark=?','token=?',array(time(),base64_decode($_SESSION['loginAd']['name']),$dataAPI['remark'],$dataAPI['token']));
    $codeReturn=200;
    $data=array('name'=>base64_decode($_SESSION['loginAd']['name']));
  }


  return setDataReturn($codeReturn,$data);
}














 ?>