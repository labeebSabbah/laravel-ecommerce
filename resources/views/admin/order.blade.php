<?php 
    $stats = ['Processing', 'Delivered', 'Completed', 'Canceled'];
?>
<x-admin>

    <style>
        select {
            display: inline !important;
        }
        .btn-dark {
            padding-top: 8px;
            padding-bottom: 4px;
        }
        img {
            width: 3rem;
            height: 3rem;
        }
    </style>

    <x-slot:title>Order #{{ $o->id }}</x-slot>

    <div class="container-fluid">
        <form action="/admin/order/{{ $o->id }}/update" method="POST">
            @method('PUT')
            @csrf
            <h3><label for="status">Update Status</label></h3>
            <select name="status" id="status" class="form-select rounded-pill" style="width: 158px; height: 38px; margin: auto;">
                @foreach ($stats as $s)
                    <option value="{{ $s }}" <?php if ($s == $o->status) {echo 'selected';} ?>>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" name="id" value="{{ $o->id }}" class="btn btn-dark rounded-pill">Update</button>
        </form>
        <hr>
        <h3>Order Details</h3>
        <div>
            <h4 style="text-align: left !important">Information</h4>
            <x-table>
                <x-slot:head>
                    <tr>
                        <th scope="col">Customer</th>
                        <th scope="col">Creation Date</th>
                        <th scope="col">Total Items</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </x-slot>
                <tr>
                    <th scope="row">{{ $o->user->name }}</th>
                    <td>{{ date('Y-m-d', strtotime($o->created_at)) }}</td>
                    <td>{{ $o->no_of_items }}</td>
                    <td>{{ $o->total }}$</td>
                </tr>
            </x-table>
        </div>
        <div>
            <h4 style="text-align: left !important">Items</h4>
            <x-table>

                <x-slot:head>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </x-slot>

                @foreach (unserialize($o->items) as $p)
                    <tr>
                        <td scope="row"><img src="{{ $p['product']->image }}" alt="images"></td>
                        <td>{{ $p['product']->name }}</td>
                        <td>{{ $p['product']->price }}$</td>
                        <td>x{{ $p['quantity'] }}</td>
                    </tr>
                @endforeach

            </x-table>
        </div>
    </div>

</x-admin>