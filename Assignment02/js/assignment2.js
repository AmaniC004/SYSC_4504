window.onload = () => {
    let addNoteBtn = document.getElementById('highlight');
    let hideNoteBtn = document.getElementById('hide');
    hideNoteBtn.style.display = 'none'; // Use display instead of visibility

    addNoteBtn.addEventListener('click', function () {
        traverseDOM(document.body);

        function traverseDOM(element) {
            if (element.children.length > 0) {
                for (let child of element.children) {
                    traverseDOM(child);
                }
            }

            if (element.tagName !== 'SCRIPT' && element.tagName !== 'STYLE' && element.tagName !== 'SPAN') {
                createSpan(element);
            }
        }

        function createSpan(element) {
            let span = document.createElement('span');
            span.textContent = `${element.tagName}`;
            span.className = 'hoverNode';
            span.style.backgroundColor = "yellow";
            span.style.color = "black";
            span.style.padding = "2px";
            span.style.marginLeft = "5px";
            span.style.fontSize = "0.8em";
            span.style.cursor = "pointer";

            span.addEventListener('click', function (event) {
                event.stopPropagation();
                alert(
                    `TAG: ${element.tagName}\nClass: ${element.className}\nID: ${element.id}\ninnerHTML: ${element.innerHTML}`
                );
            });

            element.appendChild(span);
        }

        addNoteBtn.style.display = 'none';
        hideNoteBtn.style.display = 'inline-block';
    });

    hideNoteBtn.addEventListener('click', function () {
        document.querySelectorAll('.hoverNode').forEach(elem => elem.remove());
        addNoteBtn.style.display = 'inline-block';
        hideNoteBtn.style.display = 'none';
    });
};
