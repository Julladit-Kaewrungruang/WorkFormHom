<div class="container-fluid">
    <div class="row">
        <div class="col-xl-10"></div>
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
                            <th>Dapartment</th>
                            <th>Do</th>
                            <th>Did</th>
                            <th>Done</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-myteam">
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>06</td>
                            <td>10</td>
                            <td>05</td>


                        </tr>
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>06</td>
                            <td>10</td>
                            <td>05</td>
                        </tr>
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
                            <td>06</td>
                            <td>10</td>
                            <td>05</td>

                        </tr>
                        <tr>
                            <td>Julladit</td>
                            <td>CS</td>
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
        getdataMyTeam();
    });
</script>