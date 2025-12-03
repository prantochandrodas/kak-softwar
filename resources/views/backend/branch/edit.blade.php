<!-- Modal Header -->
<div class="modal-header" style="background-color: #333333; border-bottom: 1px solid #ccc;">
    <h5 class="modal-title" id="dataEditModalLabel" style="color: #ffffff;">{{ __('messages.edit_branch') }}</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <form id="dataEditModalForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <!-- name -->
            <div class="col-md-12 mb-3">
                <label for="name" class="form-label fw-bold text-dark">{{ __('messages.name') }}:</label>
                <input type="text" class="form-control border-dark" id="name" name="name"
                    placeholder="{{ __('messages.name') }}" value="{{ $data->name }}">
                <div class="invalid-feedback name-error"></div>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- email -->
            <div class="col-md-12 mb-3">
                <label for="email" class="form-label fw-bold text-dark">{{ __('messages.email') }}: <span
                        class="text-danger">*</span></label>
                <input type="email" class="form-control border-dark" id="email" name="email"
                    placeholder="{{ __('messages.email') }}" value="{{ $data->email }}">
                <div class="invalid-feedback email-error"></div>
            </div>
            <!-- Contact Number -->
            <div class="col-md-12 mb-3">
                <label for="contact_number" class="form-label fw-bold text-dark">{{ __('messages.contact_number') }}:
                    <span class="text-danger">*</span></label>
                <input type="text" class="form-control border-dark" id="contact_number" name="contact_number"
                    placeholder="{{ __('messages.contact_number') }}" value="{{ $data->contact_number }}">
                <div class="invalid-feedback contact-number-error"></div>
            </div>

            <!-- Address-->
            <div class="col-md-12 mb-3">
                <label for="address" class="form-label fw-bold text-dark">{{ __('messages.address') }}:</label>
                <textarea name="address" id="address" cols="30" rows="5" class="form-control border-dark"
                    placeholder="{{ __('messages.address') }}">{{ $data->address }}</textarea>
                <div class="invalid-feedback address-error"></div>
            </div>

        </div>


        <div class="col-md-12 mb-3">
            <label for="status" class="form-label fw-bold text-dark">{{ __('messages.status') }}:</label><br>

            <label class="switch">
                <input type="checkbox" id="status" name="status" value="1"
                    {{ isset($data->status) && $data->status == 1 ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>

            <div class="invalid-feedback status-error"></div>
        </div>

        <input type="hidden" value="{{ $data->id }}" id="slider_id">
        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn submit-btn"
                style="background-color: #FF4C29; color: #ffffff; border-radius: 5px;">
                {{ __('messages.update') }}
            </button>
        </div>
    </form>
</div>



</div>

<!-- Modal Footer -->
<div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #ccc;">
    <button type="button" class="btn" style="background-color: #FF4C29; color: #ffffff; border-radius: 5px;"
        data-bs-dismiss="modal">{{ __('messages.close') }}</button>
</div>

<script>
    $(document).ready(function() {

        $("#dataEditModalForm").on("submit", function(e) {

            showLoading();
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            let sliderId = $("#slider_id").val();

            $.ajax({
                url: "{{ route('branch.update', ':id') }}".replace(':id', sliderId),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".invalid-feedback").text("").hide(); // Clear previous errors
                },
                success: function(response) {
                    if (response.success) {
                        // Success message


                        // Reset form and close modal
                        $("#dataEditModalForm")[0].reset();
                        $("#dataEditModal").modal("hide");

                        hideLoading();
                        window.location.href =
                            "{{ route('branch.index') }}?added-successfully=" +
                            encodeURIComponent(response.message);

                    }
                },
                error: function(xhr) {
                    hideLoading();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Display validation errors
                        if (errors.name) {
                            $(".name-error").text(errors.name[0]).show();
                        }


                        // Auto-hide error messages after 3 seconds
                        setTimeout(function() {
                            $(".invalid-feedback").fadeOut();
                        }, 3000);
                    } else {
                        // Other errors (server/network)
                        $("#dataEditModal").modal("hide"); // Close modal
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message ||
                                'Something went wrong!',
                        });
                    }
                }
            });
        });
    });
</script>
