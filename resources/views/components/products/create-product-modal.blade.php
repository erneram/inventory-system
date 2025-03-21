@props([
    'modalId' => 'createProductModal',
])
<div>
    <div class="container mt-10 mx-auto py-8  rounded-md">
        <h2 class=" text-xl text-white font-bold mb-4">Agregar nuevo producto</h2>
        <form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="grid grid-cols-2 gap-2">
                <div class="col-span-2">
                    <label for="name" class="block text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" required class="w-full border px-3 py-2 rounded">
                </div>
                <div class="col-span-2 ">
                    <label for="description" class="block text-gray-700">Descripción</label>
                    <textarea name="description" id="description" class="w-full border px-3 py-2 rounded"></textarea>
                </div>
                <div class="">
                    <label for="cost_price" class="block text-gray-700">Precio</label>
                    <input type="number" name="cost_price" id="cost_price" required class="w-full border px-3 py-2 rounded">
                </div>
                <div class="">
                    <label for="stock_quantity" class="block text-gray-700">Cantidad en almacen</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" required
                        class="w-full border px-3 py-2 rounded">
                </div>
                <div class="">
                    <label for="category_id" class="block text-gray-700">Categorias</label>
                    <select name="categories_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="col-span-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Añadir
                    Producto</button>
            </div>
        </form>
    </div>
</div>
<script>
function modalData(modalId) {
    return {
        open: false,
        category: null,
        name: '',
        type: '',
        id: '',
        handleOpenModal(detail) {
            if (detail.modalId === modalId) {
                this.open = true;
                if (detail.category) {
                    this.category = detail.category;
                    this.name = detail.category.name;
                    this.type = detail.category.type;
                    this.id = detail.category.id;
                } else {
                    this.category = null;
                    this.name = '';
                    this.type = '';
                    this.id = '';
                }r
            }
        }
    };
}
</script>
