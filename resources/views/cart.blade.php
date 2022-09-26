<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.styles')
    <title>Cart</title>
    <style>
        #container {
            height: 80vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        img {
            width: 40px;
            height: 40px;
        }
        * {
            text-align: center;
        }
        #checkout {
            display: flex;
            justify-content: right;
            position: fixed;
            width: 100vw;
            border: 1px solid black;
            bottom: 0;
            padding: 20px;
        }
        #checkout button {
            padding: 20px;
        }
    </style>
</head>
<body>
    @include('components.nav')

        @if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0)

        <div id="container">

            <h2>Your Cart is Empty</h2>
        
            <button class="btn btn-dark" type="button" onclick="document.location = '/'">Add Some Products</button>

        </div>

        @else
        
        <x-table>

            <x-slot:head>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                </tr>
            </x-slot>

            @foreach ($_SESSION['cart'] as $pr)
                <tr>
                    <td scope="row"><img src="{{ $pr['product']->image }}" alt="image"></td>
                    <td>{{ $pr['product']->name }}</td>
                    <td>{{ $pr['product']->price }}$</td>
                    <td>x{{ $pr['quantity'] }}</td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="dlt({{ $pr['product']->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach

        </x-table>

        @endif

        <div id="checkout" class="text-bg-dark">
            <button type="button" class="btn btn-lg btn-secondary">Checkout</button>
        </div>

        <script>
            function dlt(id) {
                $.ajax({
                    url: '/cart/delete',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        id: id
                    },
                    type: 'POST',
                    success: function(response) {
                        document.location.reload();
                    }
                });
            }
        </script>

    @include('components.script')
</body>
</html>