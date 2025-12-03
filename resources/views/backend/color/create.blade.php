<div class="modal fade" id="dataCreateModal" tabindex="-1" aria-labelledby="dataCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 8px; border: 1px solid #ddd;">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #333333; border-bottom: 1px solid #ccc;">
                <h5 class="modal-title" id="dataCreateModalLabel" style="color: #ffffff;">
                    {{ __('messages.create_color') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="dataCreateModalForm" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- color_name -->
                        <div class="col-md-12 mb-3">
                            <label for="color_name" class="form-label fw-bold text-dark">{{ __('messages.color') }}
                                {{ __('messages.name') }}: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="color_name" name="color_name"
                                placeholder="{{ __('messages.color') }} {{ __('messages.name') }}">
                            <div class="invalid-feedback color-name-error"></div>
                        </div>
                        <!-- color_name -->
                        <div class="col-md-12 mb-3">
                            <label for="color_code" class="form-label fw-bold text-dark">{{ __('messages.color') }}
                                {{ __('messages.code') }}: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="color_code" name="color_code"
                                placeholder="{{ __('messages.color') }} {{ __('messages.code') }}">
                            <div class="invalid-feedback color-code-error"></div>
                        </div>
                    </div>




                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn submit-btn"
                            style="background-color: #FF4C29; color: #ffffff; border-radius: 5px;">
                            {{ __('messages.create') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #ccc;">
                <button type="button" class="btn"
                    style="background-color: #FF4C29; color: #ffffff; border-radius: 5px;"
                    data-bs-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#dataCreateModalForm").on("submit", function(e) {
            showLoading();
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('color.store') }}", // Laravel route for storing data
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

                        console.log(response);
                        // Reset form and close modal
                        $("#dataCreateModalForm")[0].reset();
                        $("#dataCreateModal").modal("hide");

                        hideLoading();
                        window.location.href =
                            "{{ route('color.index') }}?added-successfully=" +
                            encodeURIComponent(response.message);

                    }
                },
                error: function(xhr) {
                    hideLoading();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Display validation errors

                        if (errors.color_name) {
                            $(".color-name-error").text(errors.color_name[0]).show();
                        }
                        if (errors.color_code) {
                            $(".color-code-error").text(errors.color_code[0]).show();
                        }



                        // Auto-hide error messages after 3 seconds
                        setTimeout(function() {
                            $(".invalid-feedback").fadeOut();
                        }, 3000);
                    } else {
                        // Other errors (server/network)
                        $("#dataCreateModal").modal("hide"); // Close modal
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
