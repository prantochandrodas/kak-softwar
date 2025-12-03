<!-- Modal Header -->
<div class="modal-header bg-dark text-white border-0">
    <h5 class="modal-title text-white" id="dataEditModalLabel">Product Information</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Image:</strong>
            <span id="product_name" class="text-primary"><img src="{{ asset('uploads/products/' . $data->image) }}"
                    alt="{{ $data->name }}" style="max-width: 100px; max-height: 100px;"></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Name:</strong>
            <span id="product_name" class="text-primary">{{ $data->name }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Product Code:</strong>
            <span id="product_code">{{ $data->product_code }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Product Category:</strong>
            <span id="category_id">{{ $data->category ? $data->category->name : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Product Subcategory:</strong>
            <span id="subcategory_id">{{ $data->subcategory ? $data->subcategory->name : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Product Unit:</strong>
            <span id="unit">{{ $data->unit ? $data->unit->name : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Brand:</strong>
            <span id="brand_id">{{ $data->brand ? $data->brand->name : '-' }}</span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Purchase Price:</strong>
            <span id="purchase_price" class="fw-bold text-danger">{{ $data->purchase_price }} BDT</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Sale Price:</strong>
            <span id="sale_price" class="fw-bold text-danger">{{ $data->sale_price }} BDT</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Details:</strong>
            <span id="details" class="fw-bold text-danger">{!! $data->details !!}</span>
        </li>

    </ul>
</div>

<!-- Modal Footer -->
<div class="modal-footer border-0">
    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">Close</button>
</div>

<!-- Optional Custom CSS -->
<style>
    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }

    .list-group-item {
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
    }

    .modal-header h5 {
        font-weight: 600;
    }
</style>
