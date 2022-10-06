<!DOCTYPE html>
<html lang="en">
<head>
    <x-styles />
    <title>{{ $p->name }}</title>
    <style>
        #back {position:fixed;top:60px;left: 20px;}
    </style>
    <style>

        #product {
            width: 100%;
            display:flex;
        }

        @media only screen and (max-width: 600px) {
            #product{flex-direction:column;}
            #sp{display:none;}
            #mp{display:block;}
        }

        @media only screen and (min-width: 601px) {
            #product{flex-direction:row-reverse;justify-content:center;gap:20px;align-items:center;}
            #sp{display:table-cell;}
            #mp{display:none;}
        }

    </style>
</head>
<body>
    <x-nav />

    <div class="container-fluid">
        <button type="button" onclick="window.document.location= '/products'" class="btn btn-dark mt-3" id="back">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
        </button>

        <div id="product">

            <button type="button" class="btn btn-dark" onclick="cart({{ $p->id }})">Add to Cart</button>

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

    </div>

    <script>
        function cart(id) {
                $.ajax({
                    url: '/cart/add',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        id: id
                    },
                    type: 'POST',
                    success: function(response) {
                        document.location = '/products';
                    },
                    error: function(response) {
                        document.location = '/login';
                    }
                });
        }
    </script>

    <x-script />
</body>
</html>