<div class="row shadow-sm mx-2 my-1" style="border: 1px solid #e2e8f0;">
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
<div class="row  shadow-sm mx-2 my-1" style="border: 1px solid #e2e8f0;">
    <div class="col" style="height: 100%; width: 100%;">
        <div id="calendar" class="TaCal "></div>
    </div>
    <div class="col mt-3">
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th><input type="checkbox" name="foo" value="bar1" onClick="ClickAll1(this)" class="checkDate" id="btnCheckAll1"> All <br /></th>
                    <th>Detail</th>
                    <th>#Req Number</th>
                </tr>
            </thead>
            <tbody id="tbody-Detail">
                <tr class="text-center">
                    <td><input type="checkbox" name="foo" value="bar1" class="checkDate"> </td>
                    <td>2023-04-27</td>
                    <td> <button type="submit" class="btn btn-success" style="border-radius: 15px;" id="approve-btn">Approve</button>
                        <button type="submit" class="btn btn-danger" style="border-radius: 15px;" id="reject-btn">Reject</button>
                    </td>
                </tr>
                <tr class="text-center">
                    <td><input type="checkbox" name="foo" value="bar1"></td>
                    <td>2023-04-27</td>
                    <td> <button type="submit" class="btn btn-success" style="border-radius: 15px;" id="approve-btn">Approve</button>
                        <button type="submit" class="btn btn-danger" style="border-radius: 15px;" id="reject-btn">Reject</button>
                    </td>
                </tr>
                <tr class="text-center">
                    <td><input type="checkbox" name="foo" value="bar1"></td>
                    <td>2023-04-27</td>
                    <td> <button type="submit" class="btn btn-success" style="border-radius: 15px;" id="approve-btn">Approve</button>
                        <button type="submit" class="btn btn-danger" style="border-radius: 15px;" id="reject-btn">Reject</button>
                    </td>
                </tr>
                <tr class="text-center">
                    <td><input type="checkbox" name="foo" value="bar1"></td>
                    <td>2023-04-27</td>
                    <td> <button type="submit" class="btn btn-success" style="border-radius: 15px;" id="approve-btn">Approve</button>
                        <button type="submit" class="btn btn-danger" style="border-radius: 15px;" id="reject-btn">Reject</button>
                    </td>
                </tr>
                <tr class="text-center">
                    <td><input type="checkbox" name="foo" value="bar1"></td>
                    <td>2023-04-27</td>
                    <td> <button type="submit" class="btn btn-success" style="border-radius: 15px;" id="approve-btn">Approve</button>
                        <button type="submit" class="btn btn-danger" style="border-radius: 15px;" id="reject-btn">Reject</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-end me-2 " id="showBtnAll" style="display: none;">
            <button class="btn btn-success button-30" style="border-radius: 15px; " onclick="GetApproveBtn(0,2,this)">Approve All</button>
            <button type="submit" class="btn btn-danger button-31" style="border-radius: 15px;" id="Allreject-btn" onclick="GetApproveBtn(0,3,this)">Reject All</button>
        </div>
    </div>
</div>


<!-- <?php echo $token ; ?> -->
<script type="text/javascript">
    $(window).ready(() => {
        getdataDetailReq('<?= $token ?>')  
    });
</script>