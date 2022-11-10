
const inputFieldHTML = `<div class="grid grid-cols-2 gap-3"><div class="flex flex-col gap-1 w-full"><label for="field_name[]" class="font-inter-medium text-gray-400">Feldname</label><input type="text" name="field_name[]" id="field_name[]" class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none"></div><div class="flex flex-col gap-1 w-full"><label for="field_value[]" class="font-inter-medium text-gray-400">Wert</label><input type="text" name="field_value[]" id="field_value[]" class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none"></div></div>`
const addFieldButton = document.getElementById('addField');
addFieldButton.addEventListener('click', () => addField());
const removeFieldButton = document.getElementById('removeField');
removeFieldButton.addEventListener('click', () => removeField())
let fieldCount = 0
let dynamicFieldId = `field-${fieldCount}`
function addField() {
    const dynamicFieldDiv = document.getElementById('dynamicFields');
    dynamicFieldDiv.appendChild(createInputField());

}

function removeField() {
    const dynamicFieldDiv = document.getElementById('dynamicFields');
    const wrapper = document.getElementById(dynamicFieldId);
    dynamicFieldDiv.removeChild(wrapper);

}

function createInputField() {
    const wrapper = document.createElement('div');
    wrapper.id = dynamicFieldId
    wrapper.innerHTML = inputFieldHTML;
    fieldCount++
    return wrapper;
}
