<!-- Modal Header -->
<div class="modal-header bg-dark text-white border-0">
    <h5 class="modal-title text-white" id="dataEditModalLabel">{{ __('messages.supplier_information') }}</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.supplier') }} {{ __('messages.name') }}:</strong>
            <span id="product_name" class="text-primary">{{ $data->name }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.email') }}:</strong>
            <span id="email">{{ $data->office_email }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.phone') }} {{ __('messages.number') }}:</strong>
            <span id="group_id">{{ $data->office_phone ? $data->office_phone : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.address') }} :</strong>
            <span id="brand_id">{{ $data->address ? $data->address : '-' }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.contact_person') }}:</strong>
            <span id="min_stock">{{ $data->contact_person }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.contact_person') }} {{ __('messages.phone') }}
                {{ __('messages.number') }}:</strong>
            <span id="profit_margin">{{ $data->contact_person_number }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.opening_balance') }}:</strong>
            <span id="vat">{{ $data->opening_balance }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.supplier') }} {{ __('messages.image') }}:</strong>
            <span id="discount"> <img
                    src="{{ $data->picture ? asset('uploads/supplier/' . $data->picture) : asset('uploads/supplier/default.png') }}"
                    style="width: 50px;" alt="Supplier Image"></span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.signature') }}:</strong>
            <span id="net_price" class="fw-bold text-success">
                <img src="{{ $data->signature ? asset('uploads/supplier/' . $data->signature) : asset('uploads/supplier/default-signature.png') }}"
                    style="width: 100px;" alt="Supplier Image">
            </span>
        </li>

    </ul>
</div>

<!-- Modal Footer -->
<div class="modal-footer border-0">
    <button type="button" class="btn btn-danger rounded-pill px-4"
        data-bs-dismiss="modal">{{ __('messages.close') }}</button>
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
