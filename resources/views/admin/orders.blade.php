<x-admin>

    <x-slot:title>Orders</x-slot>

    <x-table>

        <x-slot:head>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Creation Date</th>
                <th scope="col">Total Items</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>

        @foreach ($orders as $o)
            <tr>
                <th scope="row">{{ $o->id }}</th>
                <td>{{ $o->user->name }}</td>
                <td>{{ date('Y-m-d', strtotime($o->created_at)) }}</td>
                <td>{{ $o->no_of_items }}</td>
                <td>{{ $o->total }}$</td>
                <td>{{ $o->status }}</td>
                <td><button class="btn btn-dark" type="button" value="{{ $o->id }}" onclick="view(this.value)">View</button></td>
            </tr>
        @endforeach

    </x-table>

    <script>
        function view(id) {
            document.location = '/admin/order/' + id;
        }
    </script>

</x-admin>