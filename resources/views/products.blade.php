@php
    use App\Models\Category;
    use App\Models\SubCategory;
    $name = $_GET['name'] ?? "";
    $category = $_GET['category'] ?? "";
    $subCategory = $_GET['subCategory'] ?? "";
    $size = $_GET['size'] ?? "";
    $min = $_GET['min'] ?? "";
    $max = $_GET['max'] ?? "";
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.styles')
    <title>Products</title>
    <style>
        @media only screen and (max-width: 600px){
            form{width:100vw!important;margin-top:0;display:none;height:100vh;}#open{display:unset;position:fixed;top: 60px;left: 20px;}
            input[type="number"]{width: 100%;}
            #close{position:fixed; right: 20px; top: 60px;display:none;}
        }
        @media only screen and (min-width: 601px){form{display:flex;}
        main{margin-left:auto;margin-top:10px;}
        form{height:100vh;position:fixed;overflow:auto;display:block!important;}
        input[type="number"]{width: 100%;}
        .p-3{padding-top:0!important}
        main{width:76vw;display:flex!important;overflow-x:hidden;margin-left:auto;justify-content:center;}
        nav{display:block!important;}
        #open{display:none!important;}#close{display:none!important;}
        }
    </style>
</head>
<body>
    @include('components.nav')

    <svg id="open" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-list" viewBox="0 0 16 16" style="z-index: 1">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
      </svg>

    <form class="flex-column flex-shrink-0 p-3 text-bg-dark gap-1"
    style="width:22vw;"
    method="GET" action="/products/search"
    id="search">

        <hr>
        <h3>Search</h3>

        <svg id="close" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg>

        <hr>

        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $name }}">
        </div>

        <div class="mb-3">
            <label for="category">Main Category</label>
            <select name="category" id="category" class="form-select">
                <option value="" selected></option>
                @foreach (Category::with('subCategory')->get() as $c)
                    <option value="{{ $c->id }}" {!! ($c->id == $category) ? 'selected' : '' !!}>{{ $c->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="subCategory">Sub-Category</label>
            <select name="subCategory" id="subCategory" class="form-select">
                <option value=""></option>
                @foreach (SubCategory::distinct()->get(['sub_category_name']) as $s)
                    <option value="{{ $s->sub_category_name }}" {!! ($s->sub_category_name == $subCategory) ? 'selected' : '' !!}>{{ $s->sub_category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="size">Size</label>
            <select name="size" id="size" class="form-select">
                <option value=""></option>
                @foreach (['S','M','L','XL','XXL'] as $s)
                    <option value="{{ $s }}" {!! ($s == $size) ? 'selected' : '' !!}>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div><label>Price</label></div>

        <div class="row g-0 mb-3">

            <div class="col">
                <input type="number" name="min" class="form-control" placeholder="min" value="{{ $min }}">
            </div>
            <div class="col-sm-3">
                <label for=""> ~ </label>
            </div>
            <div class="col">
                <input type="number" name="max" class="form-control" placeholder="max" value="{{ $max }}">
            </div>

        </div>

        <div>
            <input type="reset" value="Remove Filters" class="btn btn-danger" onclick="window.document.location = '/products'">
        </div>

    </form>
    <main class="flex-nowrap">
      <div class="container-fluid pro">
        @if (!$products->count())
            <div class="d-flex align-items-center justify-content-center" style="height: 80vh">
                <h2>No Product was Found</h2>
            </div>
        @else
        @include('components.products')
        @endif
      </div>
    </main>
    @include('components.script')
    <script>
        $('input').keypress(function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                $('#search').submit();
            }
        });
        $('select, input').change(function () {
            $('#search').submit();
        });
    </script>
    <script>
        $('#close').click(function () {
            $('form').toggle();
            $('main').toggle();
            $('#close').toggle();
            $('#open').toggle();
            $('nav').toggle();
        });
        $('#open').click(function () {
            $('form').toggle();
            $('main').toggle();
            $('#close').toggle();
            $('#open').toggle();
            $('nav').toggle();
        });
    </script>
</body>
</html>