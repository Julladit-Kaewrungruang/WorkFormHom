<!-- <link href="<?= BASEPATH ?>include/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
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
                    <input type="text" id="inputSearch" onkeyup="getdataHistoryRequestEmp()" placeholder="Search..." class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4  cardCustom">

    <div class="card-header py-3 headerXX bg-body-secondary">
        <div class="float-end"><button class="btn btn-success btn-sm" onclick="ExportFileExcel('ExcelHistoryEmployeeWFH','Excel HistoryEmployee WFH')">Export</button></div>
        <h6 class="m-0 font-weight-bold text-black ">History Request</h6>
    </div>
    <div class="card-body TableScroll" id="App-history">
        <!-- <div class="table-responsive"> -->
        <table class="table ui text-black text-center tableHistoryRequest" id="table-ExcelHistoryEmployeeWFH" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan="2" class="text-">Request Date</th>
                    <th rowspan="2">No.Token</th>
                    <th rowspan="2">Type</th>
                    <th rowspan="2">Name Request</th>
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
            <tbody id="tbody-historyrequest">
                <tr>
                </tr>
            </tbody>
        </table>
        <!-- </div> -->
    </div>
</div>

<script type="text/javascript">
    $(window).ready(() => {
        createBoxFilterDate(2);
        getdataHistoryRequestEmp();
    });
</script>