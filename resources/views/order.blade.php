<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.styles')
    <title>Order #{{ $o->id }}</title>
    <style>
        .btn-dark {
            padding-top: 8px;
            padding-bottom: 4px;
        }
        img {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>
    @include('components.nav')
    <div class="container-fluid">
        <h1>Order #{{ $o->id }}</h1>
        <div>
            <h4 style="text-align: left !important">Information</h4>
            <x-table>
                <x-slot:head>
                    <tr>
                        <th scope="col">Creation Date</th>
                        <th scope="col">Update Date</th>
                        <th scope="col">Total Items</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                    </tr>
                </x-slot>
                <tr>
                    <td scope="row">{{ date('Y-m-d', strtotime($o->created_at)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($o->updated_at)) }}</td>
                    <td>{{ $o->no_of_items }}</td>
                    <td>{{ $o->total }}$</td>
                    <td>{{ $o->status }}</td>
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
    @include('components.script')
</body>
</html>