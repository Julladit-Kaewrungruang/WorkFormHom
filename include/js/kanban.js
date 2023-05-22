(() => {
    let draggingElem;

    function onDragStart() {
        draggingElem = this;
        console.log(this);
    }

    function onDrop() {
        this.append(draggingElem);
        draggingElem = null;
    }

    function onDragOver(event) {
        event.preventDefault();
    }

    function onDragEnter(event) {
        event.preventDefault();
    }


    function run() {
        const taskElems = Array.from(document.querySelectorAll('.task'));
        const dropZoneElems = Array.from(document.querySelectorAll('.drop-zone'));

        taskElems.forEach((taskElems) => {
            taskElems.addEventListener('dragstart', onDragStart);
        })

        dropZoneElems.forEach((dropZoneElems) => {
            dropZoneElems.addEventListener('drop', onDrop);
            dropZoneElems.addEventListener('dragover', onDragOver);
            dropZoneElems.addEventListener('dragenter', onDragEnter);
        })
    }
    run();
})();