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
                        
                        <th>Day</th>
                        <th>Detail</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tbody-Detail">

                </tbody>

            </table>
            <div class="text-end me-2 " id="showBtnAll" style="display: none;">
                <button class="btn btn-success " style="border-radius: 15px; " onclick="GetApproveBtn(0,2,this)">Approve All</button>
                <button type="submit" class="btn btn-danger " style="border-radius: 15px;" id="Allreject-btn" onclick="GetApproveBtn(0,3,this)">Reject All</button>
            </div>
        </div>
    </div>
</div>


<!-- <?php echo $token; ?> -->
<script type="text/javascript">
    $(window).ready(() => {
        getdataDetailReqAll('<?= $token ?>')
    });
</script>