<div class="container-fluid">
    <div class="">
        <h1 class="h3 mb-0 text-gray-800">Request to Work from home</h1>
    </div>
    <div class="">
        <p class="text-gray-800 fs-5">Date Picker</p>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 ">
            <div class="card p-3 shadow-xl">
                <div id="formRequest2">
                    <div class="mb-3" id="my-form">
                        <label for="">Select Date </label>
                        <input type="text" id="inputselectDate_" class="form-control date">
                    </div>
                    <div class="mb-3">
                        <div>Selected Date</div>
                        <ul id="selected-dates"></ul>
                    </div>

                    <div class="mb-3">
                        <label for="">Remark </label>
                        <textarea name="" id="remark-input" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                    <div class="">
                        <button class="button-85" id="submit-button"><span>Submit</span></button>
                    </div>
                </div>









            </div>
        </div>
    </div>

    <!-- <div class="mt-3">
        <div class=" mx-2">
            <p class="text-gray-800 fs-5 ">Remark</p>
        </div>
        <div class="row">
            <div class="col col-5 mx-1 ">
                <input type="text" id="remark-input" class="form-control" aria-describedby="emailHelp"
                    placeholder="Type here..." style="border-radius: 10px;">
            </div>
            <div class="col-12 col-md-auto ml-auto">
                <button class="custom-btn btn-6" id="submit-button"><span>Submit</span></button>
            </div>
        </div>
        <div class="">
            <div>Selected Date</div>
            <ul id="selected-dates"></ul>
        </div>
    </div> -->










</div>

<script>
    $('.date').datepicker({
        multidate: true,
        format: 'dd/mm/yyyy',
        language: 'th',
        todayHighlight: true,
        clearBtn: true,
    }).on('changeDate', function(e) {
        // console.log(e.dates)
        let data_ = e.dates;
        data_ = data_.sort(function(a, b) {
            return a - b;
        });
        // console.log(data_)
        var selectedDates = data_.map(function(date) {
            return $('<li>').text(moment(date).format('YYYY-MM-DD'));
        });
        $('#selected-dates').empty().append(selectedDates);
    });

    // $('#selected-dates').click(function(){
    //     $('inputselectDate_').click();
    //     console.log(1)
    // })
    $('#submit-button').on('click', function() {
        requestform()

        // $('#my-form')[0].reset();
        // $('#selected-dates').empty();
        // $('#remark-input').val('');
    });
</script>

<script type="text/javascript">
    $(window).ready(() => {

    });
</script>