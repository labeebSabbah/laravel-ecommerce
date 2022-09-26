<x-admin>

    <x-slot:title>Categories</x-slot>

    <style>
        @media only screen and (min-width: 601px) {
            .btn-dark[data-bs-toggle="modal"] {
                margin: 0 1.2em;
            }
        }
        @media only screen and (max-width: 600px) {
            .btn-dark[data-bs-toggle="modal"] {
                margin: 1em 0;
            }
        }
    </style>

    @if ($errors->any())
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
        <li class="text-danger">{{ $error }}</li>
        @endforeach
    </ul>
    @endif
  

    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#categoryModal">
        Create a Category
    </button>

    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#subModal">
        Create a Sub-Category
    </button>
      
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form class="modal-content" method="POST" action="/admin/category/create">
            @csrf
            <div class="modal-header text-bg-dark">
              <h5 class="modal-title" id="exampleModalLabel">Create a Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-dark">Create</button>
            </div>
          </form>
        </div>
    </div>

    <div class="modal fade" id="subModal" tabindex="-1" aria-labelledby="subModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form class="modal-content" method="POST" action="/admin/subCategory/create">
            @csrf
            <div class="modal-header text-bg-dark">
              <h5 class="modal-title" id="exampleModalLabel">Create a Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Sub-Category Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="category">Category</label>
                    <select name="category_id" id="category">
                        <option value="" selected>Choose a Category</option>
                        @foreach ($cats as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-dark">Create</button>
            </div>
          </form>
        </div>
    </div>
            
    <x-table>
        
        <x-slot:head>

            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th>Sub-Categories</th>
                <th scope="col">Actions</th>
            </tr>

        </x-slot>
        @foreach ($cats as $c)
        <tr>
            <th scope="row">{{ $c->id }}</th>
            <td><span class="badge rounded-pill text-bg-dark">{{ $c->category_name }}</span></td>
            <td>
                @foreach ($c->subCategory as $sub)
                <span class="badge rounded-pill text-bg-secondary">{{ $sub->sub_category_name }} </span>
                @endforeach
            </td>
            <td>
                <button class="btn btn-primary" type="button" value="{{ $c->id }}" onclick="edit(this.value)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                    </svg>
                </button>
                <button class="btn btn-danger" type="button" value="{{ $c->id }}" onclick="dlt(this.value)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                    </svg>
                </button>
            </td>
        </tr>
        @endforeach

    </x-table>

    <script>

        function dlt(id) {
            $.ajax({
                url: '/admin/category/' + id + '/delete',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id : id
                },
                type: 'DELETE',
                success: function(response) {
                    document.location.reload();
                }
            });
        }

        function edit(id) {
            document.location = '/admin/category/' + id;
        }

    </script>

</x-admin>