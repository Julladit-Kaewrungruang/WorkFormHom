<!-- <script src="js/kanban.js"></script> -->
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
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-start fw-semibold todo" style="background-color:#fda4af;">To Do</div>
                <div class="card-body drop-zone" id="showtodo_todo" data-type="todo" style="background-color: #fecdd3;">
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-secondary" onclick="openModalNewtask('todo')"><i class="bi bi-clipboard-plus"></i> Add Task</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-start fw-semibold doing" style="background-color: #a5b4fc;">Doing
                </div>
                <div class="card-body drop-zone" id="showtodo_doing" data-type="doing" style="background-color: #c7d2fe;"></div>
                <div class="card-footer">
                    <button id="show-form-btn" type="button" class="btn btn-outline-secondary" onclick="openModalNewtask('doing')"><i class="bi bi-clipboard-plus"></i> Add Task</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-start fw-semibold done" style="background-color:#6ee7b7;">Done</div>
                <div class="card-body drop-zone" id="showtodo_done" data-type="done" style="background-color: #a7f3d0;">
                </div>
                <div class="card-footer">
                    <button id="create-card-btn" type="button" class="btn btn-outline-secondary" onclick="openModalNewtask('done')"><i class="bi bi-clipboard-plus"></i> Add Task</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-newtask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="my-form">
                        <h3>Enter Your Information</h3>
                        <div class="mb-3 d-none">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="taskType" name="taskType">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3 ">
                            <div class="" id="select_emp"></div>
                        </div>
                        <div class="mb-3">
                            <label for="aboutWork" class="form-label">About Work</label>
                            <input type="text" class="form-control" id="aboutWork" name="aboutWork">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar"></i></span>
                            <input type="text" id="filterDate" class="form-control" id="" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary" onclick="createTodo_()" form="my-form">Submit</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="card-container" class="row mt-5"></div>

    <script>
        const form = byId('my-form');
        let box = "";

        const myModal = new bootstrap.Modal(byId('modal-newtask'));

        function createTodo_() {

            CreateToDo(byId('name').value, $('#who___').val(), byId('aboutWork').value, byId('taskType').value);
        }
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = byId('name').value;
            // const who = byId('who___').value;
            let who = 0;
            const aboutWork = byId('aboutWork').value;
            let type = byId('taskType').value
            const card = `
                <div  class="card mb-2 task" draggable="true">
                    <div class="card-body">
                        <h5 class="card-title">${name}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">${who}</h6>
                        <p class="card-text">${aboutWork}</p>
                    </div>
                </div>
                <div class="card mb-2 task" draggable="true" data-token="${todoList.todo_token}">
                <div class="card-body">
                    <h5 class="card-title">${name}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">-</h6>
                    <p class="card-text">${aboutWork}</p>
                </div>
            </div>
            `;

            const cardContainer = byId(`showtodo_${type}`);
            cardContainer.insertAdjacentHTML('beforeend', card);
            form.reset();

            myModal.hide();

            // add drag and drop listeners to the new card
            const newCard = cardContainer.lastElementChild;
            newCard.addEventListener('dragstart', onDragStart);
            newCard.addEventListener('dragend', onDragEnd);
            // console.log($('who___').val())

        });

        function onDragStart() {
            draggingElem = this;
            console.log(this);
        }

        function onDragEnd() {
            console.log(this, box)
            draggingElem = null;
        }

        function onDrop() {
            if (draggingElem !== null) {
                this.append(draggingElem);
                console.log(this.dataset.type);
                UpdateTodoType(this.dataset.type, draggingElem.dataset.token);
                draggingElem = null;


            }
        }

        function onDragOver(event) {
            event.preventDefault();
        }

        function onDragEnter(event) {
            event.preventDefault();
        }

        function MoveWork() {
            const taskElems = Array.from(document.querySelectorAll('.task'));
            const dropZoneElems = Array.from(document.querySelectorAll('.drop-zone'));

            taskElems.forEach((taskElems) => {

                taskElems.addEventListener('dragstart', onDragStart);
                taskElems.addEventListener('dragend', onDragEnd);
            })

            dropZoneElems.forEach((dropZoneElems) => {

                dropZoneElems.addEventListener('dragover', onDragOver);
                dropZoneElems.addEventListener('dragenter', onDragEnter);
                dropZoneElems.addEventListener('drop', onDrop);
            });
        }
        MoveWork();
        createBoxFilterDateToDo()
    </script>

    <script type="text/javascript">
        $(window).ready(() => {
            $(`[data-id="who"]`).addClass('customBTN')
            getDataAddWork()
        });
    </script>