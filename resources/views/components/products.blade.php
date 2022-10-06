<style>
    .hovered:hover > * {
        background: gray !important;
        color: white;
    }
</style>
<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
    @foreach ($products as $p)
    <div class="col hovered">
        <div class="card"><img class="card-img-top w-100 d-block fit-cover" style="height: 325px; background-color: white;" src="{{ $p->image }}" width="454" height="200" onclick="window.document.location = '/product/' + {{ $p->id }}" />
            <div class="card-body p-4">
                <p class="text-primary card-text mb-2"><span class="badge rounded-pill text-bg-dark">{{ $p->category->category_name }}</span>
                    <span class="badge rounded-pill text-bg-secondary">{{ $p->subCategory->sub_category_name }}</span></p>
                <h4 class="card-title mb-3">{{ $p->name }} ({{ $p->size }})</h4>
                <div class="d-flex" style="width:100%; justify-content:center;">
                    <button class="btn btn-dark" type="button" onclick="cart({{ $p->id }})">Add to cart &nbsp;&nbsp;&nbsp;{{ $p->price }}$</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
                    document.location.reload();
                },
                error: function(response) {
                    document.location = '/login';
                }
            });
    }
</script>