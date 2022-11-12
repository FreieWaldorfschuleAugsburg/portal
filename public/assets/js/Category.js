document.addEventListener('click', (e) => {
        if (e.target && e.target.id === 'addCategory') {
            category();
        }
        if (e.target && e.target.id === 'removeCategory') {
            removeCategory(e);
        }
    }
)


function category() {

    const categoryDropdown = document.getElementById('category');
    const categoryInput = document.getElementById('category_input[]');

    if (categoryDropdown.hidden === false || categoryDropdown.hidden === false) {
        const container = document.getElementById('category_input_container');
        container.classList.add('w-full')
        categoryDropdown.hidden = true;
        categoryInput.hidden = false;
    } else {
        const inputTemplate = document.getElementById('category_input_template');
        const container = document.getElementById('category_input_container');
        container.classList.add('w-full')
        const cloned = inputTemplate.cloneNode(true);
        const addButton = cloned.querySelector('#addCategory');
        const removeButton = cloned.querySelector('#removeCategory')
        removeButton.hidden = false;
        cloned.removeChild(addButton);
        cloned.appendChild(removeButton);
        container.appendChild(cloned);
    }
}

function removeCategory(e) {
    e.target.parentElement.remove()
}