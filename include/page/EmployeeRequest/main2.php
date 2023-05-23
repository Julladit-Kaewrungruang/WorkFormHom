<div class="row shadow-sm mx-2 my-1" style="border: 1px solid #e2e8f0;">
    <div class="row">
        <div class="cal ms-4 mt-2">
            <p class="fw-bold">ขออนุมัติ WFH</p>
        </div>
        <div class="row" id="Head-Detail">
            <div class="col my-2">
                <img src="https://scontent.fbkk22-2.fna.fbcdn.net/v/t1.6435-9/191543486_160153532789962_6812547792119709092_n.jpg?stp=cp0_dst-jpg_e15_p320x320_q65&_nc_cat=105&ccb=1-7&_nc_sid=110474&_nc_ohc=v7R7vn2aHbUAX9R6Cb2&_nc_ht=scontent.fbkk22-2.fna&oh=00_AfBieaKwvliV_8he-u9eMuntRu6Ag8M7a4NHyRqBkQUdIw&oe=64923745" style="width: 20%; height: auto; border-radius: 10px;" class="mb-5 ms-3">
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
                    <th><input type="checkbox" name="foo" value="bar1" onClick="checkAll(this)"> All <br /></th>
                    <th>Detail</th>
                    <th>#Req Number</th>
                </tr>
            </thead>
            <tbody id="tbody-Detail">
                <tr class="text-center">
                    <td><input type="checkbox" name="foo" value="bar1"> </td>
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
            <button class="btn btn-success button-30" style="border-radius: 15px; " onclick=" GetApproveBtn()">Approve All</button>
            <button type="submit" class="btn btn-danger button-31" style="border-radius: 15px;" id="Allreject-btn" onclick="  GetRejectBtn()">Reject All</button>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            defaultView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            events: [{
                    title: 'Event1',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },
                {
                    title: 'Sajjathanasakul',
                    start: '2023-05-23T08:00:00',
                    end: '2023-05-23T17:00:00',
                },
                {
                    title: 'Sajjathanasakul',
                    start: '2023-05-23',
                    end: '2023-05-23',
                },
                {
                    title: 'Sajjathanasakul',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },
                {
                    title: 'Event2',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },
                {
                    title: 'Event2',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },
                {
                    title: 'Event2',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },
                {
                    title: 'Event2',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },

                {
                    title: 'Event2',
                    start: '2023-05-22T08:00:00',
                    end: '2023-05-22T17:00:00',
                },
                {
                    title: 'Event2',
                    start: '2023-05-29'
                },
                {
                    title: 'Sajjathanasakul',
                    start: '2023-05-30'
                },
            ],
            eventColor: '#378006',
            eventRender: function(info) {
                var dotEl = document.createElement('div');
                dotEl.className = 'event-dot';

                info.el.querySelector('.fc-event-title').appendChild(dotEl);
            }
        });

        calendar.render();
    });

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
        var ShowBtn = document.getElementById("showBtnAll");

        if (elem.checked) { // เปลี่ยนจาก celem เป็น elem
            ShowBtn.style.display = "block";

        } else {
            ShowBtn.style.display = "none";

        }
    }
</script>
<script type="text/javascript">
    $(window).ready(() => {
        // getdataHeadDetailReq()
        getdataHeadDetailReq()
        getdataDetailReq('<?= $token ?>')


    });
</script>