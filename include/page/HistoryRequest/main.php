<!-- <link href="<?= BASEPATH ?>include/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<div class="card shadow mb-4  cardCustom">
    <div class="card-header py-3 headerXX bg-body-secondary">
        <h6 class="m-0 font-weight-bold text-black ">History Request</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table  text-black text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Token</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tbody-historyrequest">
                    <tr>
                        <td>2023-04-26</td>
                        <td>2023-04-27</td>
                        <td class="text-center fw-semibold  bg-success-subtle">Approve</td>

                    </tr>
                    <tr>
                        <td>2023-04-28</td>
                        <td>2023-04-29</td>
                        <td class=" bg_Approve text-center fw-semibold bg_result_R bg-danger-subtle">Reject</td>

                    </tr>
                    <tr>
                        <td>2023-05-02</td>
                        <td>2023-05-03</td>
                        <td class="text-center fw-semibold bg_result_A bg-warning-subtle">Request</td>

                    </tr>
                    <tr>
                        <td>2023-05-12</td>
                        <td>2023-05-13</td>
                        <td class="text-center fw-semibold bg_result_R">Reject</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(window).ready(() => {
        getdataHistoryRequestEmp();
    });
</script>