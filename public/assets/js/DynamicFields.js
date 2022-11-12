document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'addField') {
        addField();
    }
    if (e.target && e.target.id === 'removeField') {
        removeField(e)
    }
    if (e.target && e.target.id === 'copyValue') {
        copyValue(e)
    }

})

function addField() {
    const dynamicFieldDiv = document.getElementById('dynamicFields');
    dynamicFieldDiv.appendChild(createInputField());

}

function removeField(e) {
    e.target.parentElement.parentElement.parentElement.remove()
}

function copyValue(e) {
    const container = e.target.parentElement;
    const fieldValue = container.querySelector('#fieldValue').innerHTML;
    navigator.clipboard.writeText(fieldValue);
}


function createInputField() {
    const template = document.getElementById('credentialInputField');
    const cloned = template.cloneNode(true);
    clearInputValue(cloned, 'field_name[]');
    clearInputValue(cloned, 'field_value[]');
    return cloned
}

function clearInputValue(element, id) {
    if (element.id === id) {
        element.value = "";
    } else if (element.children != null) {
        for (let i = 0; i < element.children.length; i++) {
            clearInputValue(element.children[i], id)
        }
    }

}

