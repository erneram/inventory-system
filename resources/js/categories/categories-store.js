document.addEventListener('alpine:init', () => {
    Alpine.store('categoriesModalData', {
        isEdit: false,
        category: null,
        id: '',
        name: '',
        type: '',
        editPath: '',
        setData(data) {
            this.isEdit = data.isEdit;
            this.category = data.category || '';
            this.name = data.name || '';
            this.type = data.type || '';
            this.id = data.id || '';
            this.editPath = data.editPath || '';
        }
    });
    console.log($store.categoriesModalData)
});
