<div class="container-fluid">
    <div class="row">
        <div class="col-xl-9 d-flex">
            <div class="customInputFilterDate">
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar"></i></span>
                    <input type="text" id="filterDate" class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="customInputFilterDate ml-2">
                <div class="input-group mb-2">
                    <input type="text" id="inputSearch" onkeyup="getemployee()" placeholder="Search..." class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>

                </div>
            </div>
        </div>
        <div class="col-3 mb-2 " id="SeletePostion">
            <!-- <select class="form-select" id="filterDepartment" name="filterDepartment">

        </select> -->
            <!-- <label for="state" class="form-label text-start" >Section</label>
            <select class="form-select" id="filterDepartment" required>
                <option value="">Choose...</option>
                <option>California</option>
            </select>
            <div class="invalid-feedback">
                Please provide a valid state.
            </div>
        </div> -->
        </div>
        <div class="col-12">
            <div class="card shadow mb-4  ">
                <div class="card-header py-3 headerXX bg-body-secondary">
                    <div class="float-end"><button class="btn btn-success btn-sm" onclick="ExportFileExcel('ExcelEmployeeWFH','Excel Employee WFH')">Export</button></div>
                    <h6 class="m-0 font-weight-bold text-black ">Employee</h6>
                </div>
                <div class="card-body TableScrollEmp" id="showtable-emp">
                    <div class="table-responsive">
                        <table class="table ui text-black text-center overflow-auto tableEmployee " id="table-ExcelEmployeeWFH" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                             
                                    <th>Emp_name</th> 
                                    <th>Emp_code</th> 
                                    <th>Dapartment</th>
                                    <th>Position</th>
                                    <th>Date</th>
                                    <th>Detail</th>
                                    <th>Type</th>     
                                    <th>Status</th>     
                                    
                                </tr>
                            </thead>
                            <tbody id="tbody-employee">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(window).ready(() => {

        getEmployeePosition(1);
        createBoxFilterDate(3);
        //  getemployee();

    });
</script>