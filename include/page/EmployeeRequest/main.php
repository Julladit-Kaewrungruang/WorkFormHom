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
    </div>
    <div class="card shadow mb-4 ">
        <div class="card-header py-3 headerXX bg-body-secondary">
            <h6 class="m-0 font-weight-bold text-black ">Request</h6>
        </div>
        <div class="card-body ">

            <div class="table-responsive">
                <table class="table  text-black text-center overflow-auto" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Request Date</th>
                            <th>No.Token</th>
                            <th>Name Request</th>
                            <th>position</th>
                            <th>Request</th>
                            <th>Approved in month</th>

                        </tr>
                    </thead>
                    <tbody id="tbody-emprequest">
                        <tr>
                          
                        </tr>
                    </tbody>

            </div>
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

    // const approveBtns = document.querySelectorAll('#approve-btn');
    // const rejectBtns = document.querySelectorAll('#reject-btn');

    // // สร้าง Event Listener สำหรับปุ่ม Approve
    // approveBtns.forEach(approveBtn => {
    //     approveBtn.addEventListener('click', () => {
    //         // เลือกแถวที่มีการติ๊กเช็คบล็อค
    //         const checkedRows = document.querySelectorAll('input[name="foo"]:checked');

    //         // วนลูปผ่านแถวที่มีการติ๊กเช็คบล็อคและดึงข้อมูลในแต่ละแถว
    //         checkedRows.forEach(checkedRow => {
    //             const row = checkedRow.parentNode.parentNode;
    //             const no = row.cells[1].textContent;
    //             const empName = row.cells[2].textContent;
    //             const department = row.cells[3].textContent;
    //             const date = row.cells[4].textContent;

    //             // นำข้อมูลไปใช้งานต่อได้ตามต้องการ
    //             console.log(`No.: ${no}, Emp_name: ${empName}, Department: ${department}, Date: ${date}, Action: Approve`);
    //         });
    //     });
    // });

    // // สร้าง Event Listener สำหรับปุ่ม Reject
    // rejectBtns.forEach(rejectBtn => {
    //     rejectBtn.addEventListener('click', () => {
    //         // เลือกแถวที่มีการติ๊กเช็คบล็อค
    //         const checkedRows = document.querySelectorAll('input[name="foo"]:checked');

    //         // วนลูปผ่านแถวที่มีการติ๊กเช็คบล็อคและดึงข้อมูลในแต่ละแถว
    //         checkedRows.forEach(checkedRow => {
    //             const row = checkedRow.parentNode.parentNode;
    //             const no = row.cells[1].textContent;
    //             const empName = row.cells[2].textContent;
    //             const department = row.cells[3].textContent;
    //             const date = row.cells[4].textContent;

    //             // นำข้อมูลไปใช้งานต่อได้ตามต้องการ
    //             console.log(`No.: ${no}, Emp_name: ${empName}, Department: ${department}, Date: ${date}, Action: Reject`);
    //         });
    //     });
    // });
</script>

<script type="text/javascript">
    $(window).ready(() => {
        getdataEmpRequest()
        createBoxFilterDate();
    });
</script>