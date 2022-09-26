<x-admin>

    <x-slot:title>Users</x-slot>

    <style>
        td {
            font-size: x-large;
            font-weight: lighter;
        }
        th[scope = 'row'] {
            font-size: x-large;
        }
    </style>

    <x-table>
        
        <x-slot:head>

            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>

        </x-slot>
        @foreach ($users as $u)
        <tr>
          <th scope="row">{{ $u->id }}</th>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td><button type="button" class="btn btn-danger" value="{{ $u->id }}" onclick="ban(this.value)">
                  @if ($u->banned)
                  Unban 
                  @else
                  Ban
                  @endif
              </button></td>
        </tr>
        @endforeach
        
    </x-table>
      
    <script>
        function ban (id) {
            $.ajax({
                url: '/admin/users/ban',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id : id
                },
                type: 'PUT',
                success: function(response) {
                    document.location.reload();
                }
            });
        } 
    </script>

</x-admin>