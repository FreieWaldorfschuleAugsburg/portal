document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'addTextField') {
        addTextField();
    }
    if (e.target && e.target.id === 'addFileField') {
        addFileField();
    }
    if (e.target && e.target.id === 'removeField') {
        removeField(e)
    }
    if (e.target && e.target.id === 'copyValue') {
        copyValue(e)
    }

})

function addTextField() {
    const dynamicFieldDiv = document.getElementById('dynamicFields');
    dynamicFieldDiv.appendChild(createInputField('credentialInputFieldText'));
}

function addFileField() {
    const dynamicFieldDiv = document.getElementById('dynamicFields');
    dynamicFieldDiv.appendChild(createInputField('credentialInputFieldFile'));
}

function removeField(e) {
    e.target.parentElement.parentElement.parentElement.remove()
}

function copyValue(e) {
    const container = e.target.parentElement;
    const fieldValue = container.querySelector('#fieldValue').innerHTML;
    navigator.clipboard.writeText(fieldValue);
}

function createInputField(id) {
    const template = document.getElementById(id);
    const cloned = template.cloneNode(true);
    renameInputs(cloned, 'template_field_name[]', 'field_name[]');
    renameInputs(cloned, 'template_field_value[]', 'field_value[]');
    cloned.removeAttribute('id');
    cloned.style.display = 'grid';
    return cloned
}

function renameInputs(element, id, newId) {
    if (element.id === id) {
        element.id = newId;
        element.name = newId;
    } else if (element.children != null) {
        for (let i = 0; i < element.children.length; i++) {
            renameInputs(element.children[i], id, newId)
        }
    }

}

