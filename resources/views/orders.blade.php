<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.styles')
    <title>My Orders</title>
</head>
<body>
    @include('components.nav')
    <x-table>

        <x-slot:head>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Creation Date</th>
                <th scope="col">Update Date</th>
                <th scope="col">Total Items</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </x-slot>
        @php $id = 1; @endphp
        @foreach ($orders as $o)
            <tr>
                <th scope="row">{{ $id++ }}</th>
                <td>{{ date('Y-m-d', strtotime($o->created_at)) }}</td>
                <td>{{ date('Y-m-d', strtotime($o->updated_at)) }}</td>
                <td>{{ $o->no_of_items }}</td>
                <td>{{ $o->total }}$</td>
                <td>{{ $o->status }}</td>
                <td><button type="button" class="btn-dark btn" onclick="view({{ $o->id }})">View</button></td>
            </tr>
        @endforeach

    </x-table>
    <script>
        function view(id) {
            document.location = '/order/' + id;
        }
    </script>
    @include('components.script')
</body>
</html>