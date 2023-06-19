<!-- <div class="row shadow-sm mx-2 my-1" style="border: 1px solid #e2e8f0;">
    <div class="row">
        <div class="cal ms-4 mt-2">
            <p class="fw-bold">ขออนุมัติ WFH</p>
        </div>
        <div class="row" id="Head-Detail">
            <div class="col my-2">
                <img src="">
                <div style="display: inline-block;">
                    <div class="ms-3">
                        <p>Name : </p>
                        <p>Email : </p>
                        <p>Position : </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <p>ID #require Number</p>
                <div class="row">
                    <p>เมื่อ</p>
                </div>
            </div>
            <div class="col">
                <p>จำนวน ... วัน</p>
            </div>
        </div>
    </div>
</div>
<div class="row  shadow-sm mx-2 my-1" style="border: 1px solid #e2e8f0;" id="FromeHisReq">
    <div class="col" style="height: 100%; width: 100%;">
        <div id="calendar" class="TaCal "></div>
    </div>
    <div class="col mt-3">
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th><input type="checkbox" name="foo" value="bar1" onClick="ClickAll1(this)" class="checkDate" id="btnCheckAll1"> All <br /></th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <tbody id="tbody-Detail">
                <tr>
                </tr>
            </tbody>
        </table>
        <div class="text-end me-2 " id="showBtnAll" style="display: none;">
            <button class="button-29" style="border-radius: 15px; " onclick="CancelReqDate(0,4,this)">Cancel All</button>
        </div>
    </div>
</div> -->

<div class=" row mx-2 my-1">
    <div class="col-md-12 mb-3">
        <div class="mt-2">
            <button class="btn btn-warning btn-sm" onclick="history.back()"><i class="fas fa-arrow-left"></i> BACK</button>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="boxWhite">
            <div class="row">
                <div class="col-md-12 ms-4 mt-2">
                    <p class="fw-bold">Request WFH</p>
                </div>
                <div class="col-md-12">
                    <div class="row" id="Head-Detail">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row  mx-2 my-1" id="App-request">
    <div class="col-md-6" style="height: 100%; width: 100%;">
        <div class="boxWhite p-2">
            <div id="calendar" class="TaCal "></div>
        </div>
        <div class="dot-container mt-2 text-right mb-5">
            <span class="dot1"></span> 
            <span>Approved</span>
            <span class="dot3 ml-2"></span> 
            <span>Requested</span>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="boxWhite p-2">
            <table class="table ">
                <thead>
                    <tr class="text-center">
                        <th><input type="checkbox" name="foo" value="bar1" onClick="ClickAll1(this)" class="checkDate" id="btnCheckAll1"> All <br /></th>
                        <th>Day</th>
                        <th>Detail</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tbody-Detail">

                </tbody>
            </table>
            <div class="text-end me-2 " id="showBtnAll" style="display: none;">
                <button class="btn btn-secondary  " style="border-radius: 15px; " onclick="CancelReqDate(0,4,this)">Cancel All</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).ready(() => {
        getdataDetailReq2('<?= $token ?>')
    });
</script>