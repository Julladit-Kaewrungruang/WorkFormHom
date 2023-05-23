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
                    <input type="text" id="inputSearch" placeholder="Search..." class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-2 mb-2 ">
            <label for="state" class="form-label text-start">State</label>
            <select class="form-select" id="state" required>
                <option value="1">pv</option>
                <option value="2">pu</option>
                <option value="3">team</option>
            </select>
            <div class="invalid-feedback">
                Please provide a valid state.
            </div>
        </div>
    </div>

    <div class="card shadow mb-4  ">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table  text-black text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Emp_name</th>
                            <th>Position</th>
                            <th>DD/MM/YY</th>
                            <th>Do</th>
                            <th>Did</th>
                            <th>Done</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-myteam1">
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>2023-04-27</td>
                            <td>06</td>
                            <td>10</td>
                            <td>05</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(window).ready(() => {
        // $('#filterDate').daterangepicker();



        createBoxFilterDate();

        getdataTestTeam();


    });


</script>