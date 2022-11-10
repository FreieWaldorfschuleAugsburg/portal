const button = document.getElementById('addField');

const inputFieldHTML = ' <div class="grid grid-cols-2 gap-3">\n' +
    '                        <div class="flex flex-col gap-1 w-full">\n' +
    '                            <label for="title"\n' +
    '                                   class="font-inter-medium text-gray-400"><?= lang(\'credential.fields.fieldname\') ?></label>\n' +
    '                            <input type="text" name="field_name[]" id="field_name[]"\n' +
    '                                   class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none">\n' +
    '                        </div>\n' +
    '\n' +
    '                        <div class="flex flex-col gap-1 w-full">\n' +
    '                            <label for="title"\n' +
    '                                   class="font-inter-medium text-gray-400"><?= lang(\'credential.fields.value\') ?></label>\n' +
    '                            <input type="text" name="value[]" id="value[]"\n' +
    '                                   class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none">\n' +
    '                        </div>\n' +
    '                    </div>'


button.addEventListener(event => {
    addField();
})

function addField() {
    $('dynamicFields').append(inputFieldHTML)

}

function removeField() {

}







