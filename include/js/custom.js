function testCallAPI() {
  let dataAPI = {
    start: 1,
    end: 0
  }
  connectApi('get/dashboard', { type: 'SumExpire', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
    }
  })
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

function requestform() {
  Swal.fire({
    icon: "warning",
    title: "Confirm?",
    showCancelButton: true,
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      var arrdate = $('#selected-dates li').map(function () {
        return $(this).text();
      }).get();
      var remark = $('#remark-input').val();
      // console.log("Selected date: " + date + ", Remark: " + remark);
      // console.log(arrdate)
      // let arrDate_new = []
      // arrdate.forEach(date => {
      //   // console.log(date)
      //   arrDate_new.push(moment(date).format('YYYY-MM-DD'));
      // });

      let dataAPI = {
        date: arrdate,
        remark: remark
      }
      console.log(dataAPI)
      connectApi('get/formrequest', { type: 'request', data: dataAPI, dataoption: 0 }, `formRequest2`, function (output) {
        console.log(output)
        if (output.status == 200) {
          // ...
          Swal.fire({
            title: 'Request Success!',
            icon: 'success',
          }).then((result) => {
            location.reload();
          });
        }
      })
    } else {
      // Swal.fire({
      //   title: 'Unsuccessful!',
      //   icon: 'error'
      // });
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
          <td>${request.request_token}</td>
          <td>${request.emp_fname} ${request.emp_lname}</td>
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
        date1.forEach(date => {
          body.innerHTML += ` <tr class="text-center">
          <td><input type="checkbox" name="foo" value="${date.date_id}" class="checkDateDetail" onClick="checkAll()"> </td>
          <td>${moment(date.date_select).format('DD/MM/YYYY')}</td>
            <td> 
            ${date.date_status == 1 ? `<button type="submit" class="btn btn-success button-30" style="border-radius: 15px;" id="approve-btn" data-id="${date.date_id}" onclick="GetApproveBtn(1,2,this)">Approve</button>
            <button type="submit" class="btn btn-danger button-31" style="border-radius: 15px;" id="reject-btn" data-id="${date.date_id}" onclick="GetApproveBtn(1,3,this)">Reject</button>` : ``}
            
            </td>
          </tr>`
        })
        Cale(date1);
      })
    }
  })
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

function ClickAll(elem) {
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


function Cale(date1) {
  let EventAll = [];
  // document.addEventListener('DOMContentLoaded', function() {
  date1.forEach(date => {
    EventAll.push({
      title: date.emp_fname,
      start: date.date_select,
      // color: '#a6a6a6'
      color: '#f97316'
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
    // eventColor: '#378006',
    eventRender: function (info) {
      var dotEl = document.createElement('div');
      dotEl.className = 'event-dot';

      info.el.querySelector('.fc-event-title').appendChild(dotEl);
    }
  });
  calendar.render();
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
        // let date = convertDate(moment(request.date_select)/1000);
        body.innerHTML += ` <tr>
        <td>${request.emp_fname} ${request.emp_lname}</td>
        <td>${request.orgunit_name}</td>
        <td>${moment(request.date_select).format('DD/MM/YYYY')}</td>
        <td>26/4/2023</td>
    </tr>`

      })
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
    icon: "warning",
    title: type == 2 ? `Approve?` : `Reject?`,
    showCancelButton: true,
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
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
            icon: 'success',
          }).then((result) => {
            location.reload();
          });
        }
      })
    }
  })
}

function GetRejectBtn() {
  Swal.fire({
    icon: "warning",
    title: "ยืนยัน...asdasdas.",
    showCancelButton: true,
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
  })
}


function getdataHistoryRequestEmp() {
  let dataAPI = {
  }
  console.log(dataAPI)
  connectApi('get/formrequest', { type: 'Myhistory', data: dataAPI, dataoption: 0 }, ``, function (output) {
    console.log(output)
    if (output.status == 200) {
      let body = byId('tbody-historyrequest')
      body.innerHTML = '';
      let ArrayStuts = ['', 'Request', 'Approve', 'Reject'];
      let ArrayStutsBg = ['', '#facc15', '#14b8a6', '#ef4444'];
      output.data.forEach(request => {
        body.innerHTML += `  <tr>
        <td>${request.request_token}</td>
        <td>${request.emp_fname} ${request.emp_lname}</td>
        <td>${moment(request.date_select).format('DD/MM/YYYY')}</td>
        <td class="text-center fw-semibold bg_result_A " style=" background-color: ${ArrayStutsBg[request.date_status]}; border-radius:100px; width: 150px" >
        ${ArrayStuts[request.date_status]}</td>
      </tr>`
      })
    }
  })
}
