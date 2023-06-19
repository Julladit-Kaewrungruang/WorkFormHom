function testCallAPI() {
  let dataAPI = {
    start: 1,
    end: 0
  }
  // connectApi('get/dashboard', { type: 'SumExpire', data: dataAPI, dataoption: 0 }, ``, function (output) {
  //   //console.log(output)
  //   if (output.status == 200) {
  //   }
  // })
}

function openModalNewtask(type) {
  openModal('newtask')
  byId('taskType').value = type
  let dataAPI = {
  }
  //console.log(dataAPI)
  connectApi('get/work', { type: 'AllEmp', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let who = '';
      let select_emp = byId('select_emp')
      who.innerHTML = "";
      output.data.forEach(Emp => {
        who += ` <option value="${Emp.emp_id}">${Emp.emp_fname} ${Emp.emp_lname}</option>`;
      })
      select_emp.innerHTML = ` <label for="who___" class="form-label">Who</label>
      <select class="form-control selectpicker show-tick" multiple data-actions-box="true" data-live-search="true"  id="who___" name="who">
          ${who}
      </select>`;
      $('#who___').selectpicker();
    }
  })
}

function showNameEmp() {
  let dataAPI = {
  }
  //console.log(dataAPI)
  connectApi('get/work', { type: 'AllEmp', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let who = '';
      let select_emp = byId('select_emp')
      who.innerHTML = "";
      output.data.forEach(Emp => {
        who += ` <option value="${Emp.emp_id}">${Emp.emp_fname} ${Emp.emp_lname}</option>`;
      })

      select_emp.innerHTML = ` <label for="who___" class="form-label">Who</label>
      <select class="form-control selectpicker show-tick" multiple data-actions-box="true" data-live-search="true"  id="who___" name="who">
          ${who}
      </select>`;
      // //console.log($('#who___'))
      $('#who___').selectpicker();
    }
  })
}


function requestform() {
  let EselecType = FindAll(`.selectType.select:checked`);


  // if(date.trim() === '' || from.trim() === '' || to.trim() === ''){
  //   Swal.fire({
  //      icon: 'error',
  //       title: 'Please select a date',
  //       text: 'Please select at least one date',
  //   });
  // }else{
  //   console.log(date,from,to)
  // }



  let selecType = 0;
  console.log(EselecType)
  EselecType.forEach(t => {
    selecType = t.value;
  })
  Swal.fire({
    icon: "warning",
    title: "Confirm?",
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      var arrdate = $('#selected-dates li').map(function () {
        return $(this).text();
      }).get();
      var remark = $('#remark-input').val();
      let assign = byId('btnAssignTo').checked == true ? 1 : 0;
      let assignTo = 0;
      if (assign == 1) {
        assignTo = byId('emp_select_assignto').value
      }
      if (selecType == 2) {
        arrdate = [];
        arrdate = [{
          date: byId('customDate_date').value,
          from: byId('customDate_from').value,
          to: byId('customDate_to').value
        }]

      }
      let dataAPI = {
        date: arrdate,
        remark: remark,
        assign: assign,
        assignTo: assignTo,
        type: selecType,
        // from:moment(),
        // to:0
      }
      //console.log(dataAPI)
      connectApi('get/formrequest', { type: 'request', data: dataAPI, dataoption: 0 }, `formRequest2`, function (output) {
        //console.log(output)
        if (output.status == 200) {
          Swal.fire({
            title: 'Request Success!',
            icon: 'success',
          }).then((result) => {
            location.reload();
          });
        }
      })
    } else {
    }
  })
}


function getdataEmpRequest() {

  let dataAPI = {
    search: byId(`inputSearch`).value,
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD HH:mm'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD HH:mm'),
  }
  //console.log(dataAPI)
  connectApi('get/EmployeeRequest', { type: 'employeeRequest', data: dataAPI, dataoption: 0 }, `App-history`, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-emprequest')
      body.innerHTML = '';
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];
      output.data.employeeRequest1.forEach(request => {
        let date1 = request.date;
        let dateApp = request.dateApprove;
        let dateRej = request.dateReject;
        let dateCan = request.dateCancel;
        let dateAllStatus = request.dateAllstatus;
        // let date = convertDate(moment(request.date_select)/1000);
        body.innerHTML += `<tr class="align-items-center  ${dateAllStatus.length >= date1.length ? `text-success` : ``}">
          <td style="text-align:left">${moment(request.request_create_at).format('D MMM YY')} at ${moment(request.request_create_at).format('H:mm')}</td>
          <td style="text-align:left">${request.request_token}</td>
          <td >${arrSelestType[request.request_type_select]}</td>
          <td style="text-align:left">${request.emp_fname} ${request.emp_lname}</td>
          <td style="text-align:left">${request.emp_positionName}</td>
           <td>${dateApp.length > 0 ? `${dateApp.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
          <td>${dateRej.length > 0 ? `${dateRej.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
          <td>${dateCan.length > 0 ? `${dateCan.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
          <td>${dateAllStatus.length}/${date1.length}<span class ="d-none">.</span>  </td>
          <td>${dateAllStatus.length >= date1.length ? `<div class="text-success">Completed</div>` : `<div class="text-primary">Pending</div>`} </td>
          <td > <button  class="btn btn-primary">
          <a href='EmployeeRequest2/${request.request_token}'style="color: #fff;"> Detail </a></button>
           </td>
        </tr>`
      })
    }
  })
}

function getdataEmpRequestAll() {

  let dataAPI = {
    search: byId(`inputSearch`).value,
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD HH:mm'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD HH:mm'),
  }
  //console.log(dataAPI)
  connectApi('get/EmployeeRequest', { type: 'employeeRequestAll', data: dataAPI, dataoption: 0 }, `App-history`, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-emprequest')
      body.innerHTML = '';
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];
      output.data.employeeRequest1.forEach(request => {
        let date1 = request.date;
        let dateApp = request.dateApprove;
        let dateRej = request.dateReject;
        let dateCan = request.dateCancel;
        let dateAllStatus = request.dateAllstatus;
        // let date = convertDate(moment(request.date_select)/1000);
        body.innerHTML += `<tr class="align-items-center  ${dateAllStatus.length >= date1.length ? `text-success` : ``}">
          <td style="text-align:left">${moment(request.request_create_at).format('D MMM YY')} at ${moment(request.request_create_at).format('H:mm')}</td>
          <td style="text-align:left">${request.request_token}</td>
          <td >${arrSelestType[request.request_type_select]}</td>
          <td style="text-align:left">${request.emp_fname} ${request.emp_lname}</td>
          <td style="text-align:left">${request.emp_positionName}</td>
           <td>${dateApp.length > 0 ? `${dateApp.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
          <td>${dateRej.length > 0 ? `${dateRej.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
          <td>${dateCan.length > 0 ? `${dateCan.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
          <td>${dateAllStatus.length}/${date1.length}<span class ="d-none">.</span>  </td>
          <td>${dateAllStatus.length >= date1.length ? `<div class="text-success">Completed</div>` : `<div class="text-primary">Pending</div>`} </td>
          <td > <button  class="btn btn-primary">
          <a href='HistoryAll2/${request.request_token}'style="color: #fff;"> Detail </a></button>
           </td>
        </tr>`
      })
    }
  })
}





function getdataDetailReq(token) {
  let dataAPI = {
    token: token
  }
  //console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'detailReq', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-Detail')
      body.innerHTML = '';
      let bodyH = byId('Head-Detail')
      bodyH.innerHTML = '';
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];
      output.data.forEach(request => {
        let date1 = request.date;
        let Approved = request.Approved;
        bodyH.innerHTML = `<div class="col-md-6  d-flex" >
        <div class="profile-request"> <img src=${request.emp_profile} style="" class="mb-5 ms-3">
        </div>
       
        <div style="display: inline-block;">
            <div class="ms-3">
                <p class="mb-1">${request.emp_fname} ${request.emp_lname}</p>
                <p class="mb-1">${request.emp_email} </p>
                <p class="mb-1">${request.emp_positionName}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
    <div class =" p-3"> <p class="mb-1">ID : ${request.request_token}</p>
            <p class="mb-1">Create at : ${moment(request.request_create_at).format('DD/MM/YYYY, H:mm')}</p>
        <p class="mb-1">Request : ${date1.length} Day</p>
        <p class="mb-1"><b style="color:blue">Type : ${arrSelestType[request.request_type_select]}</b></p>
        <p class="mb-1"><b style="color:blue">Remark : ${request.request_remark}</b></p>
        </div>
       
    </div>`
        let contApprove = 0;
        date1.forEach(date => {
          date.date_status == 1 ? contApprove++ : null;
          body.innerHTML += ` <tr class="text-center">
          <td> ${date.date_status == 1 ? `<input type="checkbox" name="foo" value="${date.date_id}" class="checkDateDetail" onClick="checkAll()">` : ``} </td>   
          <td>${moment(date.date_select).format('dddd')}</td>
          <td>${request.request_type_select == 2 ? `${moment(date.date_select_from).format('H:mm')}-${moment(date.date_select_to).format('H:mm')}  ${moment(date.date_select).format('DD/MM/YYYY')}` : moment(date.date_select).format('DD/MM/YYYY')}</td>
            <td> 
            ${date.date_status == 1 ? `<button type="submit" class="btn btn-success " style="border-radius: 15px;" id="approve-btn" data-id="${date.date_id}" onclick="GetApproveBtn(1,2,this)">Approve</button>
            <button type="submit" class="btn btn-danger" style="border-radius: 15px;" id="reject-btn" 
            data-id="${date.date_id}" onclick="GetApproveBtn(1,3,this)">Reject</button>` : date.date_status == 2 ? `<span class="text-success">Approved</span>` : date.date_status == 3 ? `<span class="text-danger">Rejected ${!!date.date_remark ? ` : ${date.date_remark}` : ``}</span>` : `<span class="text-secondary">Cancel${!!date.date_remark ? ` : ${date.date_remark}` : ``}</span>`}
            </td>
          </tr>`
        })
        if (contApprove == 0) {
          byId(`btnCheckAll1`).style.display = "none";
        }
        Cale(date1, Approved);
      })
      let params = new URLSearchParams(window.location.search);
      //console.log(params);
      let action = params.get("action");
      if (!!action) {
        $('#btnCheckAll1').click();
        //console.log(action);
        if (action === "Approve") {
          // $("#btnCheckAll1").click()
          GetApproveBtn(0, 2, 'this')
        } else if (action === "Reject") {
          GetApproveBtn(0, 3, 'this')
        }
      }
    }
  })
}

function getdataDetailReq2(token) {
  let dataAPI = {
    token: token
  }
  //console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'detailReq', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let ArrayStuts = ['', 'Requested', 'Approved', 'Rejected', 'Cancel request'];
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];

      let ArrayStutsBg = ['', '#FF9800', '#22c55e', '#F97866', '#9ca3af'];
      let body = byId('tbody-Detail')
      body.innerHTML = '';
      let bodyH = byId('Head-Detail')
      bodyH.innerHTML = '';
      output.data.forEach(request => {
        let date1 = request.date;
        let Approved = request.Approved;
        bodyH.innerHTML = `<div class="col-md-6  d-flex" >
        <div class="profile-request"> <img src=${request.emp_profile} style="" class="mb-5 ms-3">
        </div>
       
        <div style="display: inline-block;">
            <div class="ms-3">
                <p class="mb-1">${request.emp_fname} ${request.emp_lname}</p>
                <p class="mb-1">${request.emp_email} </p>
                <p class="mb-1">${request.emp_positionName}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
    <div class =" p-3"> <p class="mb-1">ID : ${request.request_token}</p>
            <p class="mb-1">Create at : ${moment(request.request_create_at).format('DD/MM/YYYY, H:mm')}</p>
        <p class="mb-1">Request : ${date1.length} Day</p>
        <p class="mb-1"><b style="color:blue">Type : ${arrSelestType[request.request_type_select]}</b></p>
        <p class="mb-1"><b style="color:blue">Remark : ${request.request_remark}</b></p>
        </div>
       
    </div>`
        let contApprove = 0;
        date1.forEach(date => {
          date.date_status == 1 ? contApprove++ : null;
          body.innerHTML += ` <tr class="text-center">
          <td> ${date.date_status == 1 ? `<input type="checkbox" name="foo" value="${date.date_id}" class="checkDateDetail" onClick="checkAll()">` : ``} </td>   
      <td>${moment(date.date_select).format('dddd')}</td>
      <td>${request.request_type_select == 2 ? `${moment(date.date_select_from).format('H:mm')}-${moment(date.date_select_to).format('H:mm')}  ${moment(date.date_select).format('DD/MM/YYYY')}` : moment(date.date_select).format('DD/MM/YYYY')}</td>
      <td class="text-center fw-semibold bg_result_A " style=" color: ${ArrayStutsBg[date.date_status]}; border-radius:100px; width: 150px" >
      ${ArrayStuts[date.date_status]}</td>
      <td>${date.date_status == 1 || date.date_status == 2 ? `
      <button type="button" class="btn btn-secondary btn-sm " style="border-radius: 15px;" data-id="${date.date_id}"  onclick="CancelReqDate(1,4,this)">Cancel ${!!date.date_remark ? ` : ${date.date_remark}` : ``}</button>` : ``}</td>
      </tr>`
        })
        if (contApprove == 0) {
          byId(`btnCheckAll1`).style.display = "none";
        }
        Cale(date1, Approved);
      })
      let params = new URLSearchParams(window.location.search);
      //console.log(params);
      let action = params.get("action");
      if (!!action) {
        $('#btnCheckAll1').click();
        //console.log(action);
        if (action === "Cancel") {
          CancelReqDate(0, 4, 'this')
          //console.log(type);
        }
      }
    }
  })
}

function getdataDetailReqAll(token) {
  let dataAPI = {
    token: token
  }
  //console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'detailReq', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-Detail')
      body.innerHTML = '';
      let bodyH = byId('Head-Detail')
      bodyH.innerHTML = '';
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];
      output.data.forEach(request => {
        let date1 = request.date;
        let Approved = request.Approved;
        bodyH.innerHTML = `<div class="col-md-6  d-flex" >
        <div class="profile-request"> <img src=${request.emp_profile} style="" class="mb-5 ms-3">
        </div>
       
        <div style="display: inline-block;">
            <div class="ms-3">
                <p class="mb-1">${request.emp_fname} ${request.emp_lname}</p>
                <p class="mb-1">${request.emp_email} </p>
                <p class="mb-1">${request.emp_positionName}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
    <div class =" p-3"> <p class="mb-1">ID : ${request.request_token}</p>
            <p class="mb-1">Create at : ${moment(request.request_create_at).format('DD/MM/YYYY, H:mm')}</p>
        <p class="mb-1">Request : ${date1.length} Day</p>
        <p class="mb-1"><b style="color:blue">Type : ${arrSelestType[request.request_type_select]}</b></p>
        <p class="mb-1"><b style="color:blue">Remark : ${request.request_remark}</b></p>
        </div>
       
    </div>`
        let contApprove = 0;
        date1.forEach(date => {
          date.date_status == 1 ? contApprove++ : null;
          body.innerHTML += ` <tr class="text-center">
         
          <td>${moment(date.date_select).format('dddd')}</td>
          <td>${request.request_type_select == 2 ? `${moment(date.date_select_from).format('H:mm')}-${moment(date.date_select_to).format('H:mm')}  ${moment(date.date_select).format('DD/MM/YYYY')}` : moment(date.date_select).format('DD/MM/YYYY')}</td>
            <td> 
            ${date.date_status == 1 ? `<span class="text-secondary">Pending</span>` : date.date_status == 2 ? `<span class="text-success">Approved</span>` : date.date_status == 3 ? `<span class="text-danger">Rejected ${!!date.date_remark ? ` : ${date.date_remark}` : ``}</span>` : `<span class="text-secondary">Cancel${!!date.date_remark ? ` : ${date.date_remark}` : ``}</span>`}
            </td>
          </tr>`
        })
        if (contApprove == 0) {
          byId(`btnCheckAll1`).style.display = "none";
        }
        Cale(date1, Approved);
      })
      let params = new URLSearchParams(window.location.search);
      //console.log(params);
      let action = params.get("action");
      if (!!action) {
        $('#btnCheckAll1').click();
        //console.log(action);
        if (action === "Approve") {
          // $("#btnCheckAll1").click()
          GetApproveBtn(0, 2, 'this')
        } else if (action === "Reject") {
          GetApproveBtn(0, 3, 'this')
        }
      }
    }
  })
}

function getdataShowCale() {
  // filterStatus
  // filterDepartment
  let dataAPI = {
    filterDepartment: byId('filterDepartment').value,
    status: byId(`filterStatus`).value
  }
  console.log(dataAPI)
  connectApi('get/formrequest', { type: 'ShowCalenderdate', data: dataAPI, dataoption: 0 }, `App-request14`, function (output) {
    console.log(output)
    if (output.status == 200) {
      // let body = byId('ShowCaleReq')
      // body.innerHTML = '';
      // body.innerHTML = `
      //   <div class="div my-3 ">
      //   <div id='calendar'></div> 
      //   </div>`
      // ShowCale(output.data);
      let Approved = output.data;
      let EventAll = [];
      Approved.forEach(Approve => {
        EventAll.push({
          title: Approve.emp_fname,
          start: `${Approve.date_select}${Approve.date_status == 1 ? ` 09:00:00` : ``}`,
          color: `${Approve.date_status == 1 ? `#FF9800` : `#04AA6D`}`
        });
      }
      )
    
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        displayEventTime: false,
        headerToolbar: {
          left: 'prev,next',
          center: 'title',
          right: 'dayGridMonth,listMonth'
        },
        events: EventAll,
        eventRender: function (info) {
          var dotEl = document.createElement('div');
          dotEl.className = 'event-dot';
          info.el.querySelector('.fc-event-title').appendChild(dotEl);
        }
      });
      calendar.render();

      
    }else{
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {});
      var eventSources = calendar.getEventSources(); 
      var len = eventSources.length;
      for (var i = 0; i < len; i++) { 
          eventSources[i].remove(); 
      } 
      calendar.render();
    }
  })
}

// function ShowCale(Approved) {
//   let EventAll = [];
//   Approved.forEach(Approve => {
//     EventAll.push({
//       title: Approve.emp_fname,
//       start: `${Approve.date_select}${Approve.date_status == 1 ? ` 09:00:00` : ``}`,
//       color: `${Approve.date_status == 1 ? `#FF9800` : `#04AA6D`}`
//     });
//   }
//   )

//   var calendarEl = document.getElementById('calendar');
//   var calendar = new FullCalendar.Calendar(calendarEl, {
//     defaultView: 'dayGridMonth',
//     displayEventTime: false,
//     headerToolbar: {
//       left: 'prev,next',
//       center: 'title',
//       right: 'dayGridMonth,listMonth'
//     },
//     events: EventAll,
//     eventRender: function (info) {
//       var dotEl = document.createElement('div');
//       dotEl.className = 'event-dot';
//       info.el.querySelector('.fc-event-title').appendChild(dotEl);
//     }
//   });
//   calendar.render();
// }

function Cale(date1, Approved) {
  let EventAll = [];
  date1.forEach(date => {
    EventAll.push({
      title: date.emp_fname,
      start: date.date_select,
      color: '#FF9800'
    })
  })
  Approved.forEach(Approve => {
    EventAll.push({
      title: Approve.emp_fname,
      start: `${Approve.date_select} 09:00:00`,
      color: '#04AA6D'
    })
  })
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    defaultView: 'dayGridMonth',
    displayEventTime: false,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,listMonth'
    },
    events: EventAll,
    eventRender: function (info) {
      var dotEl = document.createElement('div');
      dotEl.className = 'event-dot';
      info.el.querySelector('.fc-event-title').appendChild(dotEl);
    }
  });
  calendar.render();
}

function checkAll() {
  let checkDateDetail = FindAll(`.checkDateDetail:checked`);
  //console.log(checkDateDetail);
  var ShowBtn = document.getElementById("showBtnAll");
  if (checkDateDetail.length > 1) { // เปลี่ยนจาก celem เป็น elem
    ShowBtn.style.display = "block";
  } else {
    ShowBtn.style.display = "none";
  }
}

function ClickAll1(elem) {
  if (elem.checked) {
    let checkboxes = document.getElementsByName("foo");
    for (let i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = true;
    }
  } else {
    let checkboxes = document.getElementsByName("foo");
    for (let i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = false;
    }
  }
  checkAll()
}

function checkBtnCancel() {

}

function getdataHeadDetailReq(token) {
  let dataAPI = {
    token: token
  }
  //console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'HeadDetail', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('Head-Detail')
      body.innerHTML = '';
      output.data.forEach(request => {
        let date1 = request.date
        date1.forEach(date => {
          body.innerHTML = `<div class="col my-2" >
          <img src=${request.emp_profile} style="width: 20%; height: auto; border-radius: 10px;" class="mb-5 ms-3">
          <div style="display: inline-block;">
              <div class="ms-3">
                  <p>Name : ${request.emp_fname} ${request.emp_lname}</p>
                  <p>Email : ${request.emp_email} </p>
                  <p>Position : ${request.emp_positionName}</p>
              </div>
          </div>
      </div> 
      <div class="col">
          <p>ID : ${request.request_token}</p>
          <div class="row">
              <p>เมื่อ : ${moment(request.request_create_at).format('DD/MM/YYYY, h:mm:ss a')}</p>
              <p>เมื่อ : ${request.request_remark}</p>
          </div>
      </div>
      <div class="col">
          <p>${date1.length} Day</p>
      </div>`
        })
      })
    }
  })
}

function getdataMyTeam() {
  let dataAPI = {
  }
  //console.log(dataAPI)
  connectApi('get/formrequest', { type: 'MyTeam', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-myteam')
      body.innerHTML = '';
      output.data.forEach(request => {
        // let date = convertDate(moment(request.date_select)/1000);
        body.innerHTML += ` <tr>
        <td>${request.emp_fname}</td>
        <td>${request.emp_positionName}</td>
        <td>06</td>
        <td>10</td>
        <td>05</td>
    </tr>`
      })
    }
  })
}

function getemployee() {
  let dataAPI = {
    filterDepartment: byId('filterDepartment').value,
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD HH:mm'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD HH:mm'),
    search: byId('inputSearch').value,
    status: byId(`filterStatus`).value
  }
  // //console.log(dataAPI)
  connectApi('get/employee', { type: 'employee', data: dataAPI, dataoption: 0 }, `showtable-emp`, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-employee')
      body.innerHTML = '';
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];
      let data = output.data;
      data.forEach(request => {
        let date = request.date_select;
        let dateSelect = '';
        let dateSelectStatus = '';
        let dateSelectType = '';
        let ArrayStuts = ['', 'Requested', 'Approved', 'Rejected', 'Cancel request'];
        let ArrayStutsBg = ['', '#FF9800', '#22c55e', '#F97866', '#9ca3af'];
        request.requestDate.forEach(re => {
          dateSelect += `<div style="color:${ArrayStutsBg[re.date_status]}">${re.request_type_select == 2 ? `${moment(re.date_select_from).format('H:mm')}-${moment(re.date_select_to).format('H:mm')}  ${moment(re.date_select).format('ddd, D MMM YY')}` : `${moment(re.date_select).format('ddd, D MMM YY')}`}</div>`;
          // <td>${moment(date.date_select).format('dddd')}</td>
          // <td>${request.request_type_select == 2 ? `${moment(date.date_select_from).format('H:mm')}-${moment(date.date_select_to).format('H:mm')}  ${moment(date.date_select).format('DD/MM/YYYY')}` : moment(date.date_select).format('DD/MM/YYYY')}</td>
          dateSelectStatus += `<div style="color:${ArrayStutsBg[re.date_status]}">${ArrayStuts[re.date_status]}</div>`;
          dateSelectType += `<div style="color:${ArrayStutsBg[re.date_status]}">${arrSelestType[re.request_type_select]}</div>`;

        })

        body.innerHTML += ` <tr class="align-items-center">
        <td style="text-align:left">${request.emp_fname} ${request.emp_lname}</td>
        <td style="text-align:left">B${request.emp_code}</td>
        <td style="text-align:left">${request.orgunit_name}</td>
        <td style="text-align:left">${request.emp_positionName}</td>
        <!-- <td>${request.request_ids}</td> -->
        <td>${request.requestDate.length}</td>
        <td>${dateSelect}</td>
        <td>${dateSelectType}</td>
        <td>${dateSelectStatus}</td>

    </tr>`
      })
    } else {
      let body = byId('tbody-employee')
      body.innerHTML = '';
    }
  })
}

// function getemployeePostion() {
//   let dataAPI = {
//     filterDepartment : byId('filterDepartment').value
//   }

//   //console.log(dataAPI)
//   connectApi('get/work', { type: 'ShowPositionEmp', data: dataAPI, dataoption: 0 }, ``, function (output) {
//     //console.log(output)
//     if (output.status == 200) {
//       let PositionEmp = ''
//       let body = byId('filterDepartment')
//       PositionEmp.innerHTML = '';
//       output.data.forEach(Emp => {
//         PositionEmp += ` <option value="${Emp.orgunit_id}">${Emp.orgunit_name}</option>`;
//       })
//       body.innerHTML = `${PositionEmp}`
//     }
//   })
// }

function getEmployeePosition(type) {

  // let dataAPI = {
  //     filterDepartment: byId('filterDepartment').value
  // };

  connectApi(
    "get/work",
    { type: "ShowPositionEmp", data: 0, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = document.getElementById("SeletePostion");
        let optionOrgunit = `<option value="All">All</option>`;

        output.data.forEach((option) => {
          optionOrgunit += `<option value="${option.orgunit_name}">${option.orgunit_name}</option>`;
        })
        htmltypeRequest.innerHTML = "";
        // htmltypeRequest.innerHTML += `<option value="All">All</option>`;

        typeRequest.forEach((orgunit) => {
          htmltypeRequest.innerHTML = `<div class="d-flex"> 
           <select class="form-select me-2" id="filterDepartment" name="filterDepartment" onchange="${type==1?`getemployee()`:`getdataShowCale()`}">
                       ${optionOrgunit}
                  </select>
                  <select class="form-select" id="filterStatus" name="filterStatus" onchange="${type==1?`getemployee()`:`getdataShowCale()`}">
                  <option value="All" ${type==2?`selected`:``}>All</option>
                  <option value="1">Requested</option>
                  <option value="2" ${type==1?`selected`:``}>Approved</option>
                 ${type==1?`<option value="3">Rejected</option><option value="4">Cancel request</option>`:``} 
                  

              </select></div>
                 `;
        });

        

        if(type==1){
          getemployee();
        }else if(type==2){
          getdataShowCale();
        }


        // getDataTicketComplete();
      } else {
        // Handle error condition if needed
      }
    }
  );
}


function getDataAddWork() {
  let dataAPI = {

  }
  //console.log(dataAPI)
  connectApi('get/work', { type: 'Todo', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      // body.innerHTML = '';
      output.data.forEach(todoList => {
        let body = byId(`showtodo_${todoList.todo_type}`)
        body.innerHTML += `<div class="card mb-2 task" draggable="true" data-token="${todoList.todo_token}">
        <div class="card-body">
            <h5 class="card-title">${todoList.todo_title}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">${todoList.todo_owner}</h6>
            <p class="card-text">${todoList.todo_description}</p>
        </div>
    </div>`
      })
      MoveWork();
    }
  })
}

function getDataShowEmpReq() {
  let dataAPI = {
  }
  //console.log(dataAPI)
  connectApi('get/formrequest', { type: 'empSection', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('ShowEmp')
      if (output.data.length > 0) {
        let option = '';
        output.data.forEach(emp => {
          // body.innerHTML += `<h6 class="mb-2 text-body-secondary">${todoList.todo_owner}</h6>`
          option += `<option value="${emp.emp_id}">${emp.emp_fname} ${emp.emp_lname} (${emp.emp_positionName})</option>`;
        })
        body.innerHTML = `<div>
          <label for="">To</label>
          <select class="form-select" id="emp_select_assignto">${option}</select>
        </div>
        `;
      } else {
        body.innerHTML = '';
      }
      // output.data.forEach(todoList => {
      //   let body = byId('ShowEmp')
      //   body.innerHTML += `<h6 class="mb-2 text-body-secondary">${todoList.todo_owner}</h6>`
      // })
    }
  })
}

function checkbtnAssignTo(e) {
  let body = byId('ShowEmp')
  e.checked == true ? getDataShowEmpReq() : body.innerHTML = '';
}

function CreateToDo(name, who, aboutWork, type) {
  //console.log(name, who, aboutWork, type);
  let dataAPI = {
    name: name,
    who: who,
    aboutWork: aboutWork,
    type: type,
    state: byId('state').value,
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD'),
    search: byId('inputSearch').value
  }
  //console.log(dataAPI)
  connectApi('get/work', { type: 'Create', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      output.data.forEach(todoList => {
        let card = `<div class="card mb-2 task" draggable="true" data-token="${todoList.todo_token}">
        <div class="card-body">
            <h5 class="card-title">${todoList.todo_title}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">${todoList.todo_owner}</h6>
            <p class="card-text">${todoList.todo_description}</p>
        </div>
    </div>`
        const cardContainer = byId(`showtodo_${type}`);
        cardContainer.insertAdjacentHTML('beforeend', card);
        byId('my-form').reset();
        MoveWork();
      })
    }
    // MoveWork();
    // location.reload()
  })
}

function UpdateTodoType(newtype, token) {
  //console.log(newtype,);
  let dataAPI = {
    newtype: newtype,
    token: token,
  }
  //console.log(dataAPI)
  connectApi('get/work', { type: 'UpdataType', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
  })
}
function getdataTestTeam() {
  let dataAPI = {
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD'),
    // search: byId('inputSearch').value
  }
  //console.log(dataAPI)
  connectApi('get/Test', { type: 'Test', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-myteam1')
      body.innerHTML = '';
      output.data.Test_type.forEach(Test => {
        // let date = convertDate(moment(request.date_select)/1000);
        body.innerHTML += ` <tr>
        <td>${Test.emp_fname} ${Test.emp_lname}</td>
        <td>${Test.emp_positionName}</td>
        <td>${moment(Test.date_select).format('DD/MM/YYYY')}</td>
        <td data-type="todo"> ${Test.todo.length > 0 ? addCommas(Test.todo.length) : '-'}</td>
        <td data-type="doing"> ${Test.doing.length > 0 ? addCommas(Test.doing.length) : '-'}</td>
        <td data-type="done">${Test.done.length > 0 ? addCommas(Test.done.length) : '-'}</td>
    </tr>`
        //console.log(Test);
      })
    }
  })
}

function createBoxFilterDate(type) {
  $(`#filterDate`).daterangepicker({
    opens: 'right',
    startDate: moment(SELECT_FILTER__START_DAY),
    endDate: moment(SELECT_FILTER__END_DAY),
    "locale": {
      "format": "DD/MM/YY",
      "separator": " To ",
      "applyLabel": "Okay",
      "cancelLabel": " Cancel ",
      "fromLabel": "From",
      "toLabel": "To",
      "customRangeLabel": "Custom Range",
      "weekLabel": "W",
      "daysOfWeek": ArrDayNamesShort,
      "monthNames": ArrMonthEN,
      "firstDay": 0
    },
    ranges: {
      'Today': [moment(), moment()],
      // 'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 days': [moment().subtract(6, 'days'), moment()],
      'Last 30 days': [moment().subtract(29, 'days'), moment()],
      'This Month ': [moment().startOf('month'), moment().endOf('month')],
      // 'เดือนนี้': [moment("12-21-2021", "MM-DD-YYYY"), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'This year ': [moment().startOf('year'), moment().endOf('year')],
      'Last years': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    }
  }, function (start, end) {
    SELECT_FILTER__START_DAY = start
    SELECT_FILTER__END_DAY = end
    // //console.log(1)
    // getdataTestTeam();
    if (type == 1) {
      getdataEmpRequest();
    } else if (type == 2) {
      getdataHistoryRequestEmp()
    } else if (type == 3) {
      getemployee()
    }else if (type == 4) {
      getdataEmpRequestAll();
    }

  });
}

function createBoxFilterDateToDo() {
  $(`#filterDate`).daterangepicker({
    opens: 'right',
    startDate: moment(SELECT_FILTER__START_DAY),
    endDate: moment(SELECT_FILTER__END_DAY),
    "locale": {
      "format": "DD/MM/YY",
      "separator": " To ",
      "applyLabel": "Okay",
      "cancelLabel": " Cancel ",
      "fromLabel": "From",
      "toLabel": "To",
      "customRangeLabel": "Custom Range",
      "weekLabel": "W",
      "daysOfWeek": ArrDayNamesShort,
      "monthNames": ArrMonthEN,
      "firstDay": 0
    },
    ranges: {
      'Today': [moment(), moment()],
      'Last Month ': [moment(), moment().endOf('month')],
      // 'เดือนนี้': [moment("12-21-2021", "MM-DD-YYYY"), moment().endOf('month')],
    }
  }, function (start, end) {
    SELECT_FILTER__START_DAY = start
    SELECT_FILTER__END_DAY = end
    //console.log(start);
    //console.log(end);
  });
}


function getdataHistoryRequest() {
  let dataAPI = {

  }
  //console.log(dataAPI)
  connectApi('get/formrequest', { type: 'HistoryEmployeeRequest', data: dataAPI, dataoption: 0 }, ``, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-emprequest')
      body.innerHTML = '';
      output.data.employeeRequest1.forEach(request => {
        body.innerHTML += `  <tr>
        <th><input type="checkbox" name="foo" value="bar1"> <br /></th>
        <td>${request.emp_fname} ${request.emp_lname}</td>
        <td>${request.emp_positionName}</td>
        <td>${request.date_status}</td>
    </tr>`
      })
    }
  })
}

function GetApproveBtn(SingleType, type, e) {
  let path = window.location.href
  path = path.replace('?action=Approve', '');
  path = path.replace('?action=Reject', '');
  //console.log(path);
  Swal.fire({
    icon: "warning",
    title: type == 2 ? `Approve?` : `Reject?`,
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: "#10b981",
    cancelButtonText: 'Cancel',
    input: type == 3 ? 'textarea' : ``,
    inputLabel: 'Remark',
    inputPlaceholder: 'Remark',
    inputValidator: (value) => {
      if (value && type == 3) {
        let check = [];
        if (SingleType == 0) {
          let checkDateDetail = FindAll(`.checkDateDetail:checked`);
          checkDateDetail.forEach(date => {
            check.push(parseInt(date.value))
          })
        } else {
          check.push(parseInt(e.dataset.id))
          // check.push(parseInt(date.value))
        }
        //console.log(check);
        let dataAPI = {
          type: type,
          check: check,
          remark: value,
        }
        connectApi('get/DetailRequest', { type: 'ApproveAll', data: dataAPI, dataoption: 0 }, `App-request`, function (output) {
          //console.log(output)
          if (output.status == 200) {
            Swal.fire({
              title: 'Success!',
              icon: 'success',
            }).then((result) => {
              // location.reload();
              let path = window.location.href
              path = path.replace('?action=Approve', '');
              path = path.replace('?action=Reject', '');
              // window.location=`${BASEPATH}HistoryRequest2/`;
              window.location = path;;
            });
          }
        })
      } else {
        return 'Please provide complete information!'
      }
    }
  }).then((result) => {
    if (result.isConfirmed && type == 2) {
      let check = [];
      if (SingleType == 0) {
        let checkDateDetail = FindAll(`.checkDateDetail:checked`);
        checkDateDetail.forEach(date => {
          check.push(parseInt(date.value))
        })
      } else {
        check.push(parseInt(e.dataset.id))
        // check.push(parseInt(date.value))
      }
      //console.log(check);
      let dataAPI = {
        type: type,
        check: check,
        remark: ""
      }
      connectApi('get/DetailRequest', { type: 'ApproveAll', data: dataAPI, dataoption: 0 }, `App-request`, function (output) {
        //console.log(output)
        if (output.status == 200) {
          Swal.fire({
            title: 'Success!',
            icon: 'success',
          }).then((result) => {
            // location.reload();
            let path = window.location.href
            path = path.replace('?action=Approve', '');
            path = path.replace('?action=Reject', '');
            // window.location=`${BASEPATH}HistoryRequest2/`;
            window.location = path;;
          });
        }
      })
    }
  })
}

function CancelReqDate(SingleType, type, e) {
  //console.log(SingleType, type, e);
  Swal.fire({
    icon: "warning",
    title: `Cancel?`,
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: "#10b981",
    cancelButtonText: 'Cancel',
    input: 'textarea',
    inputLabel: 'Remark',
    inputPlaceholder: 'Remark',
    inputValidator: (value) => {
      if (value) {
        let check = [];
        if (SingleType == 0) {
          let checkDateDetail = FindAll(`.checkDateDetail:checked`);
          checkDateDetail.forEach(date => {
            check.push(parseInt(date.value))
          })
        } else {
          check.push(parseInt(e.dataset.id))
        }
        //console.log(check);
        let dataAPI = {
          type: type,
          check: check,
          remark: value
        }
        connectApi('get/DetailRequest', { type: 'ApproveAll', data: dataAPI, dataoption: 0 }, `App-request`, function (output) {
          //console.log(output)
          if (output.status == 200) {
            Swal.fire({
              title: 'Success!',
              icon: 'success',
            }).then((result) => {
              location.reload();
            });
          }
        })
      } else {
        return 'Please provide complete information!'
      }
    }
  })
}

// function getdataHistoryRequestEmp(token) {
//   let dataAPI = {
//     token: token,
//   }
//   //console.log(dataAPI)
//   connectApi('get/EmployeeRequest', { type: 'employeeRequest', data: dataAPI, dataoption: 0 }, ``, function (output) {
//     //console.log(output)
//     if (output.status == 200) {
//       let body = byId('tbody-historyrequest')
//       body.innerHTML = '';
//       let ArrayStuts = ['', 'Request', 'Approve', 'Reject'];
//       let ArrayStutsBg = ['', '#E0F183', '#07FAA5', '#F97866'];
//       output.data.employeeRequest1.forEach(request => {
//         let date1 = request.date;
//         body.innerHTML += `<tr class="align-items-center">
//         <td>${moment(request.request_create_at).format('D MMM YY')} at ${moment(request.request_create_at).format('H:mm')}</td>
//         <td>${request.request_token}</td>
//         <td>${request.emp_fname} ${request.emp_lname}</td>
//         <td>${date1.length} Day</td>
//         <td > <button  class="button-29">
//         <a href='HistoryRequest2/${request.request_token}'style="color: #fff;"> Detail </a></button>
//          </td>
//       </tr>`
//       })
//     }
//   })
// }

function getdataHistoryRequestEmp() {
  let dataAPI = {
    search: byId(`inputSearch`).value,
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD HH:mm'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD HH:mm'),
  }
  //console.log(dataAPI)
  connectApi('get/EmployeeRequest', { type: 'HistoryEmployeeRequest', data: dataAPI, dataoption: 0 }, `App-history`, function (output) {
    //console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-historyrequest')
      body.innerHTML = '';
      let ArrayStuts = ['', 'Request', 'Approve', 'Reject'];
      let ArrayStutsBg = ['', '#E0F183', '#07FAA5', '#F97866'];
      let arrSelestType = ['', '<b>Special Case</b>', 'Custom', 'Normal'];
      output.data.employeeRequest1.forEach(request => {
        let date1 = request.date;
        let dateApp = request.dateApprove;
        let dateRej = request.dateReject;
        let dateCan = request.dateCancel;
        let dateAllStatus = request.dateAllstatus;
        body.innerHTML += `<tr class="align-items-center ${dateAllStatus.length >= date1.length ? `text-success` : ``}">
        <td>${moment(request.request_create_at).format('D MMM YY')} at ${moment(request.request_create_at).format('H:mm')}</td>
        <td>${request.request_token}</td>
        <td>${arrSelestType[request.request_type_select]}</td>
        <td>${request.emp_fname} ${request.emp_lname}</td>
        <td>${dateApp.length > 0 ? `${dateApp.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
        <td>${dateRej.length > 0 ? `${dateRej.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
        <td>${dateCan.length > 0 ? `${dateCan.length}/${date1.length}` : `-`}<span class ="d-none">.</span>  </td>
        <td>${dateAllStatus.length}/${date1.length}<span class ="d-none">.</span> </td>
        <td>${dateAllStatus.length >= date1.length ? `<div class="text-success">Completed</div>` : `<div class="text-primary">Pending</div>`} </td>
        <td > <button  class="btn btn-primary">
        <a href='HistoryRequest2/${request.request_token}'style="color: #fff;"> Detail </a></button>
         </td>
      </tr>`
      })
    }
  })
}

function getFilterEmployee() {
  let show = byId(`SeletePostion`);
  show.innerHTML = "";
  let dataAPI = {
    filterEmp: byId('state').value
  }
}

function Special_Case(e) {
  let textAlert14 = byId('textAlert14')
  if (e.checked == true) {
    checkSpecialCase = true;
    textAlert14.innerHTML = `เลือกวันที่ต้องการ`;
    byId('showCustomTime_2').style.display = 'none';
    byId('showCustomTime_1').style.display = 'flex';
    byId('showPreviewTime').style.display = 'block';

  } else {
    checkSpecialCase = false;
    textAlert14.innerHTML = ``;
  }
  byId(`inputselectDate_`).value = "";
  $('#selected-dates').empty()
  $('#inputselectDate_').val();
  $('#inputselectDate_').datepicker('setDate', null)
  byId(`inputselectDate_`).value = "";
  $('#selected-dates').empty()
  $('#inputselectDate_').val();
  $('#inputselectDate_').datepicker('setDate', null)

}


function CustomDate(e) {
  console.log(e);
  checkSpecialCase = false;
  let textAlert14 = byId('textAlert14')

  if (e.checked == true) {
    textAlert14.innerHTML = `เลือกวัน และเวลาที่ต้องการ (1 วัน)`;
    byId('showCustomTime_1').style.display = 'none';
    byId('showCustomTime_2').style.display = 'flex';
    byId('showPreviewTime').style.display = 'none';

  } else {
    textAlert14.innerHTML = ``;
    // byId('showCustomTime_2').style.display ='none';
  }


}

function normalDate(e) {
  let textAlert14 = byId('textAlert14')
  if (e.checked == true) {
    checkSpecialCase = false;
    textAlert14.innerHTML = `เลือกวันที่ต้องการ`;
    byId('showCustomTime_2').style.display = 'none';
    byId('showCustomTime_1').style.display = 'flex';
    byId('showPreviewTime').style.display = 'block';

  } else {
    checkSpecialCase = true;
    textAlert14.innerHTML = ``;
  }
  byId(`inputselectDate_`).value = "";
  $('#selected-dates').empty()
  $('#inputselectDate_').val();
  $('#inputselectDate_').datepicker('setDate', null)
  byId(`inputselectDate_`).value = "";
  $('#selected-dates').empty()
  $('#inputselectDate_').val();
  $('#inputselectDate_').datepicker('setDate', null)
}

function checkDesktop() {
  if (mobileAndTabletCheck()) {
    byId('accordionSidebar').classList.add('toggled')
  }
}

function checkInputDate14() {
  let date = byId('customDate_date').value;
  let from = byId('customDate_from').value;
  let to = byId('customDate_to').value;

  if (date.trim() === '' || from.trim() === '' || to.trim() === '') {
    Swal.fire({
      icon: 'error',
      title: 'Please select a date',
      text: 'Please select at least one date',
    });
  } else {

    requestform()

    console.log(date, from, to)
  }




}