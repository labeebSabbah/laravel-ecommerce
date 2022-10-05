@php
    use App\Models\Category;
    use App\Models\SubCategory;
    $sizes = ['S','M','L','XL','XXL'];
@endphp
<x-admin>

    <x-slot:title>Product #{{ $p->id }}</x-slot:title>

    <style>

        #product {
            display:flex;
        }

        @media only screen and (max-width: 600px) {
            #product{flex-direction:column;}
            #sp{display:none;}
            #mp{display:block;}
        }

        @media only screen and (min-width: 601px) {
            #product{flex-direction:row-reverse;justify-content:center;gap:20px;}
            #sp{display:table-cell;}
            #mp{display:none;}
        }

    </style>

    <div class="mb-3">
        <button class="btn btn-dark" type="button" onclick="window.document.location = '/admin/products'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
              </svg>
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
            </svg>
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
            </svg>
        </button>
    </div>

    <div class="modal fade" id="deleteModal" tabinindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-bg-dark">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Type in "CoNfIrM" to Delete The Product</p>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="confirm">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="dlt({{ $p->id }})">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form class="modal-content" method="POST" action="/admin/product/{{ $p->id }}/edit">
            @csrf
            @method('PUT')
            <div class="modal-header text-bg-dark">
              <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $p->name }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Product Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ $p->description }}">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Product Category</label>
                    <select class="form-select" aria-label="Category Select" onchange="cSearch(this.value)" name="category_id">
                        @foreach (Category::with('subCategory')->get() as $c)
                            <option value="{{ $c->id }}" {!! ($c->id == $p->category_id) ? 'selected' : '' !!}>{{ $c->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subCategory" class="form-label">Product Sub-Category</label>
                    <select id="subCats" class="form-select" aria-label="Sub-Category Select" name="sub_category_id">
                        @foreach (SubCategory::where('category_id', $p->category_id)->get() as $s)
                            <option value="{{ $s->id }}" {!! ($s->id == $p->sub_category_id) ? 'selected' : '' !!}>{{ $s->sub_category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Product Price</label>
                    <input type="number" class="form-control" name="price" value="{{ $p->price }}">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="{{ $p->quantity }}">
                </div>
                <div class="mb-3">
                    <label for="size" class="form-label">Product Size</label>
                    <select name="size" id="size" class="form-select">
                        @foreach ($sizes as $s)
                            <option value="{{ $s }}" {!! ($s == $p->size) ? 'selected' : '' !!}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="text" class="form-control" name="image" value="{{ $p->image }}">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-dark" name="id" value="{{ $p->id }}">Add</button>
            </div>
          </form>
        </div>
    </div>

    <div id="product">
        <div id="mp">
            <img src="{{ $p->image }}" alt="image" width="200" height="200">
            <p>Image of the Product</p>
        </div>
        <div>
            <x-table>
                
                <x-slot:head>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </x-slot>

                <tr>
                    <th scope="row" class="text-bg-dark">Name</th>
                    <td>{{ $p->name }}</td>
                    <td rowspan="7" id="sp"><img src="{{ $p->image }}" alt="image" width="385" height="540"></td>
                </tr>
                <tr>
                    <th scope="row" class="text-bg-dark">Description</th>
                    <td>{{ $p->description }}</td>
                </tr>

                <tr>
                    <th scope="row" class="text-bg-dark">Price</th>
                    <td>{{ $p->price }}$</td>
                </tr>

                <tr>
                    <th scope="row" class="text-bg-dark">Category</th>
                    <td><span class="badge rounded-pill text-bg-dark">{{ $p->category->category_name }}</span></td>
                </tr>

                <tr>
                    <th scope="row" class="text-bg-dark">Sub-Category</th>
                    <td><span class="badge rounded-pill text-bg-secondary">{{ $p->subCategory->sub_category_name }}</span></td>
                </tr>

                <tr>
                    <th scope="row" class="text-bg-dark">Quantity</th>
                    <td>
                        {{ $p->quantity }}
                         {!!
                          ($p->quantity > 0) ? '<span class="badge rounded-pill text-bg-success">In Stock</span>' 
                          : '<span class="badge rounded-pill text-bg-danger">Out of Stock</span>'
                          !!} 
                    </td>
                </tr>

                <tr>
                    <th scope="row" class="text-bg-dark">Size</th>
                    <td>{{ $p->size }}</td>
                </tr>

            </x-table>
        </div>
    </div>

    <script>
        function dlt(id) {
            if($('#confirm').val() === "CoNfIrM") {
                $.ajax({
                    url: '/admin/product/'+id+'/delete',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        id: id
                    },
                    type: 'DELETE',
                    success: function(r) {
                        window.document.location = '/admin/products';
                    }
                });
            }
        }
    </script>

</x-admin>