<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            selectable: true,
            select: async function(info) {
                const {
                    value: formValues
                } = await Swal.fire({
                    title: 'Add Event',
                    confirmButtonText: 'Submit',
                    showCloseButton: true,
                    showCancelButton: true,
                    html: `<input id="swalEvtTitle" class="form-control my-2" placeholder="Title"/>` +
                        `<textarea id="swalEvtDesc" class="form-control " placeholder="comment"></textarea>`,
                    focusConfirm: false,
                    preConfirm: () => {
                        const title = document.getElementById('swalEvtTitle').value;
                        const description = document.getElementById('swalEvtDesc').value;
                        console.log('Id : ', title.id);
                        if (!title) {
                            Swal.showValidationMessage('Please enter a title');
                        } else {
                            calendar.addEvent({
                                title: title,
                                start: info.start,
                                end: info.end,
                                allDay: info.allDay,
                                id: 'event' + new Date().valueOf(),
                                extendedProps: {
                                    description: description,
                                },

                            });
                        }

                    },

                });
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                info.el.style.borderColor = 'red';
                Swal.fire({
                    title: info.event.title,
                    icon: 'info',
                    html: `<p>${info.event.extendedProps.description}</p>`,
                    showCloseButton: true,
                    showCancelButton: true,
                    showDenyButton: true,
                    focusConfirm: false,
                    confirmButtonColor: '#dc3545',
                    denyButtonColor: '#1d4ed8',
                    confirmButtonText: 'delete',
                    denyButtonText: 'Edit',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const eventId = info.event.id;
                        const eventToRemove = calendar.getEventById(eventId);
                        if (eventToRemove) {
                            eventToRemove.remove();
                            Swal.fire({
                                title: 'Event deleted!',
                                icon: 'success',
                            });
                        }
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: 'Edit Event',
                            confirmButtonText: 'Submit',
                            showCloseButton: true,
                            showCancelButton: true,
                            html: '<input id="swalEvtTitle" class="form-control my-2" placeholder="Title" value="' + info.event.title + '">' +
                                '<textarea id="swalEvtDesc" class="form-control " placeholder="comment">' + info.event.extendedProps.description + '</textarea>',
                            focusConfirm: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const eventId = info.event.id;
                                const eventToUpdate = calendar.getEventById(eventId);
                                if (eventToUpdate) {
                                    const newTitle = document.getElementById('swalEvtTitle').value;
                                    const newDescription = document.getElementById('swalEvtDesc').value;
                                    eventToUpdate.setProp('title', newTitle);
                                    eventToUpdate.setExtendedProp('description', newDescription);
                                    Swal.fire({
                                        title: 'Event updated!',
                                        icon: 'success'
                                    });
                                }
                            }
                            calendar.refetchEvents();
                        });
                    }
                });
            }
        });
        calendar.render();
    });
</script>
<div class="card mx-2 my-2 py-3">
    <div id='calendar' class="mx-3 my-3" style="overflow: scroll;"></div>
</div>