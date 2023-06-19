<div class="container-fluid">
    <div class="row">
        <div class="col-xl-10 d-flex">
            <div class="customInputFilterDate">
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar"></i></span>
                    <input type="text" id="filterDate" class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="customInputFilterDate ml-2">
                <div class="input-group mb-2">
                    <input type="text" id="inputSearch" onkeyup="getdataEmpRequest()" placeholder="Search..." class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>

                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4 ">
        <div class="card-header py-3 headerXX bg-body-secondary">
            <div class="float-end"><button class="btn btn-success btn-sm" onclick="ExportFileExcel('ExcelRequestEmployeeWFH','Excel RequestEmployee WFH')">Export</button></div>
            <h6 class="m-0 font-weight-bold text-black ">Request</h6>
        </div>
        <div class="card-body TableScroll" id="App-history">
            <table class="table ui text-black text-center overflow-auto tableHistoryRequest2 " id="table-ExcelRequestEmployeeWFH" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-">Request Date</th>
                        <th rowspan="2">No.Token</th>
                        <th rowspan="2">Type</th>
                        <th rowspan="2">Name Request</th>
                        <th rowspan="2">position</th>
                        <th colspan="4">Request / Approve(Day)</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th>Approve</th>
                        <th>Reject</th>
                        <th>Cancel</th>
                        <th>All Date</th>
                    </tr>
                </thead>
                <tbody id="tbody-emprequest">
                    <tr>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    function checkAll(elem) {
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
    }
</script>

<script type="text/javascript">
    $(window).ready(() => {
        createBoxFilterDate(4); 
        getdataEmpRequestAll()

    });
</script>