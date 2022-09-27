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

    @if ($errors->any())
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
        <li class="text-danger">{{ $error }}</li>
        @endforeach
    </ul>
    @endif

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

        <div id="checkout" class="text-bg-dark">
            <button type="button" class="btn btn-lg btn-secondary" data-bs-toggle="modal" data-bs-target="#address">Checkout</button>
        </div>
  
        <div class="modal fade" id="address" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkoutLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="/order/new">
                    @csrf   
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Checkout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="address1">Address Line 1 <span class="text-danger">*</span></label>
                            <input type="text" name="address1" id="address1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="address2">Address Line 2</label>
                            <input type="text" name="address2" id="address2" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="city">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="city" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="state">State</label>
                            <input type="text" name="state" id="state" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <select name="country" class="form-select" id="country">
                                <option selected></option>
                                @include('components/countries')
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="postal">Postal Code <span class="text-danger">*</span></label>
                            <input type="number" name="postal" id="postal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="payment">Payment Method <span class="text-danger">*</span></label>
                            <div class="form-check" style="margin-right: 40px;">
                                <input class="" type="radio" name="payment" id="payment" value="cash" checked>
                                <label class="form-check-label" for="payment">
                                  Cash on Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Place Order</button>
                    </div>
                </form>
            </div>
        </div>

        @endif

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