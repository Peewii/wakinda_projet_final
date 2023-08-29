document.querySelectorAll('.btn-remove-collection')
    .forEach(btn => {
        btn.addEventListener('click', e => {
            deleteItem(e.target.closest('li'));
        });
    });


document.querySelectorAll('.btn-add-collection')
    .forEach(button => {
        button.addEventListener('click', addCollectionInput)
    });

function addCollectionInput(e) {
    const inputContent = document.querySelector('.' + e.target.dataset.collectionHolderClass);
  
        const item = document.createElement('li');
        item.classList.add('col-md-4');

        item.innerHTML = inputContent
            .dataset
            .prototype
            .replace(
                /__name__/g,
                inputContent.dataset.index
            );

        const closeBtn = document.createElement('button');
        closeBtn.classList.add('btn', 'btn-danger', 'text-light');
        closeBtn.setAttribute('type', 'button');
        closeBtn.innerHTML = '<i class="bi bi-x-octagon-fill"></i>';

        item.prepend(closeBtn);

        closeBtn.addEventListener('click', e => {
            deleteItem(item);
        });

        inputContent.appendChild(item);

        inputContent.dataset.index++;
}

function deleteItem(element) {
    element.remove();
}