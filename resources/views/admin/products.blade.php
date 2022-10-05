<x-admin>

    <x-slot:title>Products</x-slot>

    <style>
        img {
            width: 3rem;
            height: 3rem;
        }
        td > div {
            margin-top: 0.7rem !important;
        }
    </style>

    @if ($errors->any())
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
        <li class="text-danger">{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#productModal">
        Add a Product
    </button>

    <div class="modal fade modal-lg" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form class="modal-content" method="POST" action="/admin/product/create">
            @csrf
            <div class="modal-header text-bg-dark">
              <h5 class="modal-title" id="exampleModalLabel">Add a Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Product Description</label>
                    <input type="text" class="form-control" id="description" name="description">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Product Category</label>
                    <select class="form-select" aria-label="Category Select" onchange="cSearch(this.value)" name="category_id">
                        <option value="" selected>Choose a Category</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subCategory" class="form-label">Product Sub-Category</label>
                    <select id="subCats" class="form-select" aria-label="Sub-Category Select" name="sub_category_id" disabled></select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Product Price</label>
                    <input type="number" class="form-control" name="price">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity">
                </div>
                <div class="mb-3">
                    <label for="size" class="form-label">Product Size</label>
                    <select name="size" id="size" class="form-select">
                        <option selected>Choose a size</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="text" class="form-control" name="image">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-dark">Add</button>
            </div>
          </form>
        </div>
    </div>

    <x-table>

        <x-slot:head>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Sub-Category</th>
                <th scope="col">Price</th>
                <th scope="col">Details</th>
            </tr>
        </x-slot>

        @foreach ($products as $p)
            
        <tr>

            <td scope="row"><img src="{{ $p->image }}" alt="image" class="img-fluid img-thumbnail"></td>
            <td><div>{{ $p->name }}</div></td>
            <td><div class="badge rounded-pill text-bg-dark">{{ $p->category->category_name }}</div></td>
            <td><div class="badge rounded-pill text-bg-secondary">{{ $p->subCategory->sub_category_name }}</div></td>
            <td><div>{{ $p->price }}$</div></td>
            <td>
                <button type="button" class="btn btn-secondary" onclick="document.location = '/admin/product/' + {{ $p->id }}">
                    View
                </button>
            </td>

        </tr>

        @endforeach

    </x-table>

    <script>
        function cSearch(id) {
            if (id != "") {
                $.ajax({
                url: '/admin/category/' + id + '/subCategories',
                data: {
                    id: id
                },
                type: 'GET',
                success: function(response) {
                    $('#subCats').html(response);
                    $('#subCats').removeAttr("disabled");
                }
                });
            } else {
                $('#subCats').html("");
                $('#subCats').attr("disabled",true);
            }
        }
    </script>

</x-admin>