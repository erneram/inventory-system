window.Alpine.store('categoriesModalData', {
    isEdit: false,
    category: null,
    id: '',
    name: '',
    type: '',
    editPath: '',
    setData(data) {
        debugger;
        this.isEdit = data.isEdit;
        this.category = data.category || null;
        this.name = data.name || '';
        this.type = data.type || '';
        this.id = data.id || '';
        this.editPath = data.editPath || '';
        // console.log('Store updated:', this);
    }
});

// console.log('Store categoriesModalData inicializado:', window.Alpine.store('categoriesModalData'));
