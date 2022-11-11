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


let fieldCount = 0
let dynamicFieldId = `field-${fieldCount}`

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


function createInputField(id) {
    const template = document.getElementById('credentialInputField');
    return template.cloneNode(true)
}
