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
                <option value="">Choose...</option>
                <option>California</option>
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
                            <th>Dapartment</th>
                            <th>Date</th>
                            <th>Until</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-employee">
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>25/4/2023</td>
                            <td>26/4/2023</td>
                        </tr>
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>25/4/2023</td>
                            <td>26/4/2023</td>
                        </tr>
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>25/4/2023</td>
                            <td>26/4/2023</td>
                        </tr>
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>25/4/2023</td>
                            <td>26/4/2023</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(window).ready(() => {
        getemployee();
        createBoxFilterDate();


    });
</script>