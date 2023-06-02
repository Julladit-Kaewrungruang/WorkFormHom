<div class="container-fluid">
    <div class="">
        <h1 class="h3 mb-0 text-gray-800">Request to Work from home</h1>
    </div>
    <div class="">
        <p class="text-gray-800 fs-5">Date Picker</p>
    </div>

    <div class="row  shadow-sm mx-2 my-4" style="border: 0.5px solid #e2e8f0;">
        <div class="col" style="height: 100%; width: 100%;" id="ShowCaleReq">
        </div>
        <div class="col">
            <div class="card p-3 shadow-xl mt-5 mx-3">
                <div id="formRequest2">
                    <div class="mb-3" id="my-form">
                        <label for="">Select Date <span style="color: red;">*</span></label>
                        <input type="text" id="inputselectDate_" autocomplete="off" class="form-control date">
                    </div>
                    <div class="mb-3">
                        <div>Selected Date</div>
                        <ul id="selected-dates"></ul>
                    </div>
                    <div class="mb-3">
                        
                        <input type="checkbox" id="btnAssignTo" onclick="checkbtnAssignTo(this)" >
                        <label for="btnAssignTo">To Employee</label>
                    </div>
                    <div class="mb-3" id="ShowEmp">
                        <!-- <div class="" id="select_emp"></div> -->
                    </div>
                    <div class="mb-3">
                        <label for="">Remark </label>
                        <textarea name="" id="remark-input" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                    <div class="">
                        <button class="button-29" id="submit-button"><span>Submit</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var data = [];
    $('.date').datepicker({
        multidate: true,
        format: 'dd/mm/yyyy',
        language: 'th',
        todayHighlight: true,
        clearBtn: true,
        beforeShowDay: function(date) {
            var dateString = moment(date).format('DD/MM/YYYY');
            var weekDates = data.filter(function(d) {
                return moment(d, 'DD/MM/YYYY').isoWeek() === moment(date, 'DD/MM/YYYY').isoWeek();
            });
            if (data.includes(dateString) || weekDates.length >= 1) {
                return false;
            }
            return true;
        }
    }).on('changeDate', function(e) {
        let data_ = e.dates;
        data_ = data_.sort(function(a, b) {
            return a - b;
        });
        data = data_.map(function(date) {
            return moment(date).format('DD/MM/YYYY');
        });

        var selectedDates = data_.map(function(date) {
            return $('<li>').text(moment(date).format('YYYY-MM-DD'));
        });
        $('#selected-dates').empty().append(selectedDates);
        console.log("Data : " + data_);
        console.log("test : " + data);
    });
    $('#submit-button').on('click', function() {
        var selectedDates = $('#inputselectDate_').val();
        if (selectedDates.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Please select a date',
                text: 'Please select at least one date',
            });
            return;
        }
        requestform()
    });
</script>

<script type="text/javascript">
    $(window).ready(() => {
        // getDataShowEmpReq()
        getdataShowCale()
    });
</script>