<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 ">

    <div class="flex gap-5 items-center">

        <p class="font-inter-semibold text-h2-big lg:text-h1-small text-white"><?= lang('category.headings.view') ?></p>
    </div>
    <form method="post" id="categoryForm" class="flex flex-col gap-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5" id="category_container">
            <?php foreach ($categories

                           as $category): ?>
                <div id="categories" class="flex gap-2 font-inter-medium">
                    <input type="text" name="category[<?= $category->category_id ?>]"
                           id="category[<?= $category->category_id ?>]"
                           value="<?= $category->category_name ?>"
                           class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1 text-white">

                    <button type="button" id="deleteCategory"
                            class="p-3 bg-red-600 rounded text-white"><?= lang('buttons.remove') ?></button>

                </div>
            <?php endforeach; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <button class="p-3 bg-green-600 rounded text-white font-inter-medium" id="addCategory"
                    type="button"><?= lang('buttons.add') ?></button>
            <button class="p-3 bg-blue-600 rounded text-white font-inter-medium"
                    type="submit"><?= lang('buttons.save') ?></button>
        </div>
    </form>
</main>

<div id="category_template" class="flex gap-2 font-inter-medium hidden">
    <input type="text" name="new_category[]"
           id="new_category[]]"
           class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1 text-white">

    <button type="button" id="deleteCategory"
            class="p-3 bg-red-600 rounded text-white"><?= lang('buttons.remove') ?></button>

</div>


<script>
    document.addEventListener('click', (e) => {

            if (e.target && e.target.id === 'deleteCategory') {
                deleteCategory(e);
            }
            if (e.target && e.target.id === 'addCategory') {
                addCategory(e);
            }
        }
    )


    function addCategory(e) {
        const template = document.getElementById('category_template');
        template.classList.remove('hidden')
        const container = document.getElementById('category_container');
        const cloned = template.cloneNode(true);
        cloned.classList.remove('hidden');
        console.log(cloned.classList);
        container.appendChild(template.cloneNode(true));
        template.classList.add('hidden')
    }


    function deleteCategory(e) {
        const proceed = confirm("Sind Sie sicher? Es werden auch alle Einträge dieser Kategorie gelöscht!")
        if (proceed) {
            const categoryInputField = e.target.parentElement;
            const container = document.getElementById('category_container');
            container.removeChild(categoryInputField);
        }

    }


</script>