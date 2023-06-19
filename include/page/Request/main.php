<div class="container-fluid" id="App-request14">
    <div class="row">
        <div class="col-md-12">
            <div id="SeletePostion" style="width: 22rem;">
            </div>
        </div>
        <div class="col-md-8">
            <div class="shadow-sm p-3 mt-4 grid" style="border: 0.5px solid #e2e8f0;background-color: #fff;">
                <div class="" style="height: 100%; width: 100%;" id="ShowCaleReq">
                <div class="div my-3 ">
                    <div id='calendar'></div> 
                    </div>
                </div>

            </div>
            <div class="dot-container mt-2 text-right mb-5">
                <span class="dot1"></span>
                <span>Approved</span>
                <span class="dot3 ml-2"></span>
                <span>Requested</span>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="card p-3 mt-4 shadow-xl ">
                <div id="formRequest2">
                    <div class="mb-3" id="my-form">
                        <h1 class="h3 mb-4 text-gray-800 titlePage">Requested Productive Anywhere</h1>

                        <div class="div float-end ms-2"><input type="radio" id="btnSpecialCase" name="btnSpecialCase" class="selectType select" onclick="Special_Case(this)" value="1">
                            <label for="btnSpecialCase">Special Case </label>
                        </div>
                        <div class="div float-end ms-2"><input type="radio" id="btnCustomDate" name="btnSpecialCase" class="selectType select" onclick="CustomDate(this)" value="2">
                            <label for="btnCustomDate">Custom</label>
                        </div>
                        <div class="div float-end "><input type="radio" checked id="btnnormal" name="btnSpecialCase" class="selectType select" onclick="normalDate(this)" value="3">
                            <label for="btnnormal">normal</label>
                        </div>
                        <label for="">Select Date <span style="color: red;">*</span></label>
                        <div id="showCustomTime_1"><input type="text" id="inputselectDate_" autocomplete="off" class="form-control date"></div>
                        <div class="customedate row" style="display:none" id="showCustomTime_2">
                            <div class="col-md-12 mb-2"><input id="customDate_date" min="<?= date('Y-m-d'); ?>" type="date" autocomplete="off" class="form-control"></div>
                            <div class="col-6">
                                <label for="">From <span style="color: red;">*</span></label>
                                <input type="time" id="customDate_from" min="07:00" max="13:00" autocomplete="off" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="">To <span style="color: red;">*</span></label>
                                <input type="time" id="customDate_to" min="10:00" max="18:00" autocomplete="off" class="form-control">
                            </div>

                        </div>

                        <small id="textAlert14" class="textAlert14"></small>
                    </div>

                    <div class="mb-3" id="showPreviewTime">
                        <div>Selected Date</div>
                        <ul id="selected-dates"></ul>
                    </div>
                    <div class="mb-3 <?= $_SESSION['emp']['emp_walroles'] != 3 ? 'd-none' : '' ?>">
                        <input type="checkbox" id="btnAssignTo" onclick="checkbtnAssignTo(this)">
                        <label for="btnAssignTo">To Employee</label>
                    </div>
                    <div class="mb-3" id="ShowEmp">
                        <!-- <div class="" id="select_emp"></div> -->
                    </div>
                    <div class="mb-3">
                        <label for="">Remark </label>
                        <textarea maxlength="250" name="" id="remark-input" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                    <div class="">
                        <button class="btn btn-primary" id="submit-button"><span>Submit</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row shadow-sm mx-2 my-4 grid" style="border: 0.5px solid #e2e8f0;background-color: #fff;">
        <div class="col" style="height: 100%; width: 100%;" id="ShowCaleReq"></div>
        <div class="col">
            
        </div>
    </div> -->
</div>

<script>
    var data = [];
    let checkSpecialCase = false;
    var dateString = moment().format('DD/MM/YYYY');
    $('.date').datepicker({
        multidate: true,
        format: 'dd/mm/yyyy',
        language: 'th',
        todayHighlight: true,
        clearBtn: true,
        // minDate:moment().format('DD/MM/YYYY'),
        minDate: new Date(),
        maxDate: '+30Y',
        beforeShowDay: function(date) {
            dateString = moment(date).format('DD/MM/YYYY');
            // console.log("asdas "+ date);

            if (checkSpecialCase == false) {
                var weekDates = data.filter(function(d) {
                    return moment(d, 'DD/MM/YYYY').isoWeek() === moment(date, 'DD/MM/YYYY').isoWeek();
                });
                // console.log(weekDates);
                if (data.includes(dateString) || weekDates.length >= 1) {
                    return false;
                }
            } else {
                return true;
            }
            // return true;
        }
    }).on('changeDate', function(e) {
        let data_ = e.dates;
        // console.log(data_);
        data_ = data_.sort(function(a, b) {
            return a - b;
        });

        data = data_.map(function(date) {
            console.log(date);
            // if(moment(date)>=moment()){
            //     return moment(date).format('DD/MM/YYYY');
            // }
            return moment(date).format('DD/MM/YYYY');
        });
        // console.log("wwww " + data);
        var selectedDates = data_.map(function(date) {
            if (moment(date).format('YYYY-MM-DD') >= moment().format('YYYY-MM-DD')) {
                return $('<li>').text(moment(date).format('YYYY-MM-DD'));
            }
        });
        $('#selected-dates').empty().append(selectedDates);

    });

    $(".date").datepicker({
        //   maxDate: new Date(2007, 1 - 1, 1)
    });


    $('#submit-button').on('click', function() {
        var selectedDates = $('#inputselectDate_').val();
        console.log(selectedDates)


        if (byId('btnCustomDate').checked == true) {
            // console.log(byId('customDate_date').value())
            checkInputDate14()
        } else {
            if (selectedDates.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Please select a date',
                    text: 'Please select at least one date',
                });
                return;
            }

            requestform()
        }
        // 

    });
    $('.clear').on('click', function() {
        byId(`inputselectDate_`).value = "";
        $('#selected-dates').empty()
        $('#inputselectDate_').val();
        $('#inputselectDate_').datepicker('setDate', null)
        byId(`inputselectDate_`).value = "";
        $('#selected-dates').empty()
        $('#inputselectDate_').val();
        $('#inputselectDate_').datepicker('setDate', null)
    })
</script>
<script type="text/javascript">
    $(window).ready(() => {
        getEmployeePosition(2)
        // getDataShowEmpReq()
        // getdataShowCale()

    });
</script>