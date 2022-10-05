<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
    @foreach ($products as $p)
    <div class="col">
        <div class="card"><img class="card-img-top w-100 d-block fit-cover text-bg-dark" style="height: 325px;" src="{{ $p->image }}" width="454" height="200" />
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