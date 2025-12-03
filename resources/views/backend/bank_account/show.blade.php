<!-- Modal Header -->
<div class="modal-header bg-dark text-white border-0">
    <h5 class="modal-title text-white" id="dataEditModalLabel">Product Information</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Name:</strong>
            <span id="product_name" class="text-primary">{{ $data->name }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Product Code:</strong>
            <span id="product_code">{{ $data->product_code }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Group:</strong>
            <span id="group_id">{{ $data->group ? $data->group->name : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Brand:</strong>
            <span id="brand_id">{{ $data->brand ? $data->brand->name : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Min Stock:</strong>
            <span id="min_stock">{{ $data->min_stock }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Profit Margin:</strong>
            <span id="profit_margin">{{ $data->profit_margin }}%</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>VAT:</strong>
            <span id="vat">{{ $data->vat }}%</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Discount:</strong>
            <span id="discount">{{ $data->discount }}%</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Net Price:</strong>
            <span id="net_price" class="fw-bold text-success">{{ $data->net_price }} BDT</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Sale Price:</strong>
            <span id="sale_price" class="fw-bold text-danger">{{ $data->sale_price }} BDT</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Unit:</strong>
            <span id="unit">{{ $data->unit }}</span>
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
