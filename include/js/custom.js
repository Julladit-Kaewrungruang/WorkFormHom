function testCallAPI() {
  let dataAPI = {
    start: 1,
    end: 0
  }
  // connectApi('get/dashboard', { type: 'SumExpire', data: dataAPI, dataoption: 0 }, ``, function (output) {
  //   console.log(output)
  //   if (output.status == 200) {
  //   }
  // })
}

function openModalNewtask(type) {

  openModal('newtask')
  byId('taskType').value = type

  let dataAPI = {


  }
  console.log(dataAPI)
  connectApi('get/work', { type: 'AllEmp', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
      // console.log($('#who___'))
      $('#who___').selectpicker();

    }
  })
}

function showNameEmp() {
  let dataAPI = {
  }
  console.log(dataAPI)
  connectApi('get/work', { type: 'AllEmp', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
      // console.log($('#who___'))
      $('#who___').selectpicker();
    }
  })
}



function requestform() {
  Swal.fire({
    // icon: "warning",
    title: "Confirm?",
    html: `<img src="https://i.gifer.com/4yjE.gif" width="100%">`,
    showCancelButton: true,
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
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
      let dataAPI = {
        date: arrdate,
        remark: remark,
        assign: assign,
        assignTo: assignTo,
      }
      console.log(dataAPI)
      connectApi('get/formrequest', { type: 'request', data: dataAPI, dataoption: 0 }, `formRequest2`, function (output) {
        console.log(output)
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
  }
  console.log(dataAPI)
  connectApi('get/EmployeeRequest', { type: 'employeeRequest', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-emprequest')
      body.innerHTML = '';
      output.data.employeeRequest1.forEach(request => {
        let date1 = request.date;
        // let date = convertDate(moment(request.date_select)/1000);
        body.innerHTML += `<tr class="align-items-center">
          <td>${moment(request.request_create_at).format('D MMM YY')} at ${moment(request.request_create_at).format('H:mm')}</td>
          <td>${request.request_token}</td>
          <td>${request.emp_fname} ${request.emp_lname}</td>
          <td>${request.emp_positionName}</td>
          <td>${date1.length} Day</td>
          <td > <button  class="button-29">
          <a href='EmployeeRequest2/${request.request_token}'style="color: #fff;"> Detail </a></button>
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
  console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'detailReq', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-Detail')
      body.innerHTML = '';
      let bodyH = byId('Head-Detail')
      bodyH.innerHTML = '';
      output.data.forEach(request => {
        let date1 = request.date;
        let Approved = request.Approved;
        bodyH.innerHTML = `<div class="col my-2" >
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
        </div>
    </div>
    <div class="col">
        <p>${date1.length} Day</p>
    </div>`
        let contApprove = 0;
        date1.forEach(date => {
          date.date_status == 1 ? contApprove++ : null;
          body.innerHTML += ` <tr class="text-center">
          <td> ${date.date_status == 1 ? `<input type="checkbox" name="foo" value="${date.date_id}" class="checkDateDetail" onClick="checkAll()">` : ``} </td>   
          <td>${moment(date.date_select).format('DD/MM/YYYY')}</td>
            <td> 
            ${date.date_status == 1 ? `<button type="submit" class="btn btn-success button-30" style="border-radius: 15px;" id="approve-btn" data-id="${date.date_id}" onclick="GetApproveBtn(1,2,this)">Approve</button>
            <button type="submit" class="btn btn-danger button-31" style="border-radius: 15px;" id="reject-btn" 
            data-id="${date.date_id}" onclick="GetApproveBtn(1,3,this)">Reject</button>` : date.date_status == 2 ? `<span class="text-success">Approved</span>` : `<span class="text-danger">Rejected</span>`}
            </td>
          </tr>`
        })
        if (contApprove == 0) {
          byId(`btnCheckAll1`).style.display = "none";
        }
        Cale(date1, Approved);
      })
      let params = new URLSearchParams(window.location.search);
      console.log(params);
      let action = params.get("action");
      if (!!action) {
        $('#btnCheckAll1').click();
        console.log(action);
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
  console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'detailReq', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let ArrayStuts = ['', 'Requested', 'Approved', 'Rejected', 'Cancel request'];
      let ArrayStutsBg = ['', '#E0F183', '#22c55e', '#F97866', '#9ca3af'];
      let body = byId('tbody-Detail')
      body.innerHTML = '';
      let bodyH = byId('Head-Detail')
      bodyH.innerHTML = '';
      output.data.forEach(request => {
        let date1 = request.date;
        let Approved = request.Approved;
        bodyH.innerHTML = `<div class="col my-2" >
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
        </div>
    </div>
    <div class="col">
        <p>${date1.length} Day</p>
    </div>`
        let contApprove = 0;
        date1.forEach(date => {
          date.date_status == 1 ? contApprove++ : null;
          body.innerHTML += ` <tr class="text-center">
          <td> ${date.date_status == 1 ? `<input type="checkbox" name="foo" value="${date.date_id}" class="checkDateDetail" onClick="checkAll()">` : ``} </td>   
      <td>${moment(date.date_select).format('DD/MM/YYYY')}</td>
      <td class="text-center fw-semibold bg_result_A " style=" color: ${ArrayStutsBg[date.date_status]}; border-radius:100px; width: 150px" >
      ${ArrayStuts[date.date_status]}</td>
      <td>${date.date_status == 1 ? `
      <button type="button" class="button-29" style="border-radius: 15px;" data-id="${date.date_id}"  onclick="CancelReqDate(1,4,this)">Cancel</button>` : ``}</td>
      </tr>`
        })
        if (contApprove == 0) {
          byId(`btnCheckAll1`).style.display = "none";
        }
        Cale(date1, Approved);
      })
      let params = new URLSearchParams(window.location.search);
      console.log(params);
      let action = params.get("action");
      if (!!action) {
        $('#btnCheckAll1').click();
        console.log(action);
        if (action === "Cancel") {
          CancelReqDate(0, 4, 'this')
          console.log(type);
        }
      }
    }
  })
}

function getdataShowCale() {
  let dataAPI = {
  }
  console.log(dataAPI)
  connectApi('get/formrequest', { type: 'ShowCalenderdate', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let body = byId('ShowCaleReq')
      body.innerHTML = '';
      body.innerHTML = `
        <div class="div my-3 ">
        <div id='calendar'></div> 
        </div>`
      ShowCale(output.data);
    }
  })
}

function ShowCale(Approved) {
  let EventAll = [];
  Approved.forEach(Approve => {
    EventAll.push({
      title: Approve.emp_fname,
      start: `${Approve.date_select} 09:00:00`,
      color: '#e2283b'
    });
  });
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    defaultView: 'dayGridMonth',
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

function Cale(date1, Approved) {
  let EventAll = [];
  date1.forEach(date => {
    EventAll.push({
      title: date.emp_fname,
      start: date.date_select,
      color: '#97B6B8'
    })
  })
  Approved.forEach(Approve => {
    EventAll.push({
      title: Approve.emp_fname,
      start: `${Approve.date_select} 09:00:00`,
    })
  })
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    defaultView: 'dayGridMonth',
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
  console.log(checkDateDetail);
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
  console.log(dataAPI)
  connectApi('get/DetailRequest', { type: 'HeadDetail', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
  console.log(dataAPI)
  connectApi('get/formrequest', { type: 'MyTeam', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
  }
  console.log(dataAPI)
  connectApi('get/employee', { type: 'employee', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-employee')
      body.innerHTML = '';
      output.data.Test_type.forEach(request => {
        let date = request.date_select;
        body.innerHTML += ` <tr>
        <td>${request.emp_fname} ${request.emp_lname}</td>
        <td>${request.orgunit_name}</td>
        <td>${request.request_ids}</td>
    </tr>`
      })
    }
  })
}

function getemployeePostion() {
  let dataAPI = {
  }
  console.log(dataAPI)
  connectApi('get/work', { type: 'AllEmp', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let PositionEmp = ''
      let body = byId('SeletePostion')
      PositionEmp.innerHTML = '';
      output.data.forEach(Emp => {
        PositionEmp += ` <option value="${Emp.orgunit_name}">${Emp.orgunit_name}</option>`;
      })
      body.innerHTML = `    
        <label for="state" class="form-label text-start" >State</label>
        <select class="form-select" id="state" required>
          ${PositionEmp}
          </select>`
    }
  })
}

function getDataAddWork() {
  let dataAPI = {

  }
  console.log(dataAPI)
  connectApi('get/work', { type: 'Todo', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
  console.log(dataAPI)
  connectApi('get/formrequest', { type: 'empSection', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
  console.log(name, who, aboutWork, type);
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
  console.log(dataAPI)
  connectApi('get/work', { type: 'Create', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
  console.log(newtype,);
  let dataAPI = {
    newtype: newtype,
    token: token,
  }
  console.log(dataAPI)
  connectApi('get/work', { type: 'UpdataType', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
  })
}

function getdataTestTeam() {
  let dataAPI = {
    start: moment(SELECT_FILTER__START_DAY).format('YYYY-MM-DD'),
    end: moment(SELECT_FILTER__END_DAY).format('YYYY-MM-DD'),
    // search: byId('inputSearch').value
  }
  console.log(dataAPI)
  connectApi('get/Test', { type: 'Test', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
        console.log(Test);
      })
    }
  })
}

function createBoxFilterDate() {
  $(`#filterDate`).daterangepicker({
    opens: 'right',
    startDate: moment(SELECT_FILTER__START_DAY),
    endDate: moment(SELECT_FILTER__END_DAY),
    "locale": {
      "format": "DD/MM/YY",
      "separator": " ถึง ",
      "applyLabel": "ตกลง",
      "cancelLabel": "ยกเลิก",
      "fromLabel": "จาก",
      "toLabel": "ถึง",
      "customRangeLabel": "เลือกช่วงเวลาเอง",
      "weekLabel": "W",
      "daysOfWeek": arrWeek,
      "monthNames": arrMonthThaiFull,
      "firstDay": 0
    },
    ranges: {
      'วันนี้': [moment(), moment()],
      // 'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'ย้อนหลัง 7 วัน': [moment().subtract(6, 'days'), moment()],
      'ย้อนหลัง 30 วัน': [moment().subtract(29, 'days'), moment()],
      'เดือนนี้ ': [moment().startOf('month'), moment().endOf('month')],
      // 'เดือนนี้': [moment("12-21-2021", "MM-DD-YYYY"), moment().endOf('month')],
      'เดือนก่อน': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'ปีนี้ ': [moment().startOf('year'), moment().endOf('year')],
      'ปีก่อน': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    }
  }, function (start, end) {
    SELECT_FILTER__START_DAY = start
    SELECT_FILTER__END_DAY = end
    // console.log(1)
    getdataTestTeam();
  });
}

function createBoxFilterDateToDo() {
  $(`#filterDate`).daterangepicker({
    opens: 'right',
    startDate: moment(SELECT_FILTER__START_DAY),
    endDate: moment(SELECT_FILTER__END_DAY),
    "locale": {
      "format": "DD/MM/YY",
      "separator": " ถึง ",
      "applyLabel": "ตกลง",
      "cancelLabel": "ยกเลิก",
      "fromLabel": "จาก",
      "toLabel": "ถึง",
      "customRangeLabel": "เลือกช่วงเวลาเอง",
      "weekLabel": "W",
      "daysOfWeek": arrWeek,
      "monthNames": arrMonthThaiFull,
      "firstDay": 0
    },
    ranges: {
      'วันนี้': [moment(), moment()],
      'เดือนนี้ ': [moment(), moment().endOf('month')],
      // 'เดือนนี้': [moment("12-21-2021", "MM-DD-YYYY"), moment().endOf('month')],
    }
  }, function (start, end) {
    SELECT_FILTER__START_DAY = start
    SELECT_FILTER__END_DAY = end
    console.log(start);
    console.log(end);
  });
}


function getdataHistoryRequest() {
  let dataAPI = {
  }
  console.log(dataAPI)
  connectApi('get/formrequest', { type: 'employeeRequest', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
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
  Swal.fire({
    // icon: "warning",
    title: type == 2 ? `Approve?` : `Reject?`,
    html: `<img src="https://i.gifer.com/LyZJ.gif" width="100%">`,
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: "#10b981",
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
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
      console.log(check);
      let dataAPI = {
        type: type,
        check: check,
      }
      connectApi('get/DetailRequest', { type: 'ApproveAll', data: dataAPI, dataoption: 0 }, ``, function (output) {
        console.log(output)
        if (output.status == 200) {
          Swal.fire({
            title: 'Success!',
            html: `<img src="https://i.gifer.com/Es0.gif" width="100%">`,
            icon: 'success',
          }).then((result) => {
            location.reload();
          });
        }
      })
    }
  })
}

function CancelReqDate(SingleType, type, e) {
  console.log(SingleType, type, e);
  Swal.fire({
    // icon: "warning",
    title: `Cancel?`,
    html: `<img src="https://cdn.vox-cdn.com/thumbor/SFU8wqXYsSS_C-6NgerZMePh4Po=/0x15:500x348/1400x1050/filters:focal(0x15:500x348):format(gif)/cdn.vox-cdn.com/uploads/chorus_image/image/36992002/tumblr_lmwsamrrxT1qagx30.0.0.gif" width="100%">`,
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    confirmButtonColor: "#10b981",
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      let check = [];
      if (SingleType == 0) {
        let checkDateDetail = FindAll(`.checkDateDetail:checked`);
        checkDateDetail.forEach(date => {
          check.push(parseInt(date.value))
        })
      } else {
        check.push(parseInt(e.dataset.id))
      }
      console.log(check);
      let dataAPI = {
        type: type,
        check: check,
      }
      connectApi('get/DetailRequest', { type: 'ApproveAll', data: dataAPI, dataoption: 0 }, ``, function (output) {
        console.log(output)
        if (output.status == 200) {
          Swal.fire({
            title: 'Success!',
            icon: 'success',
          }).then((result) => {
            location.reload();
          });
        }
      })
    }
  })
}

function getdataHistoryRequestEmp(token) {
  let dataAPI = {
    token: token,
  }
  console.log(dataAPI)
  connectApi('get/EmployeeRequest', { type: 'employeeRequest', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-historyrequest')
      body.innerHTML = '';
      let ArrayStuts = ['', 'Request', 'Approve', 'Reject'];
      let ArrayStutsBg = ['', '#E0F183', '#07FAA5', '#F97866'];
      output.data.employeeRequest1.forEach(request => {
        let date1 = request.date;
        body.innerHTML += `<tr class="align-items-center">
        <td>${moment(request.request_create_at).format('D MMM YY')} at ${moment(request.request_create_at).format('H:mm')}</td>
        <td>${request.request_token}</td>
        <td>${request.emp_fname} ${request.emp_lname}</td>
        <td>${date1.length} Day</td>
        <td > <button  class="button-29">
        <a href='HistoryRequest2/${request.request_token}'style="color: #fff;"> Detail </a></button>
         </td>
      </tr>`
      })
    }
  })
}