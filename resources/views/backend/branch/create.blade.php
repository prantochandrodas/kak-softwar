<div class="modal fade" id="dataCreateModal" tabindex="-1" aria-labelledby="dataCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 8px; border: 1px solid #ddd;">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #333333; border-bottom: 1px solid #ccc;">
                <h5 class="modal-title" id="dataCreateModalLabel" style="color: #ffffff;">
                    {{ __('messages.create_branch') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="dataCreateModalForm" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- name -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label fw-bold text-dark">{{ __('messages.name') }}: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="name" name="name"
                                placeholder="{{ __('messages.name') }}">
                            <div class="invalid-feedback name-error"></div>
                        </div>
                        <!-- email -->
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label fw-bold text-dark">{{ __('messages.email') }}: <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control border-dark" id="email" name="email"
                                placeholder="{{ __('messages.email') }}">
                            <div class="invalid-feedback email-error"></div>
                        </div>
                        <!-- Contact Number -->
                        <div class="col-md-12 mb-3">
                            <label for="contact_number"
                                class="form-label fw-bold text-dark">{{ __('messages.contact_number') }}: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="contact_number"
                                name="contact_number" placeholder="{{ __('messages.contact_number') }}">
                            <div class="invalid-feedback contact-number-error"></div>
                        </div>

                        <!-- Address-->
                        <div class="col-md-12 mb-3">
                            <label for="address"
                                class="form-label fw-bold text-dark">{{ __('messages.address') }}:</label>
                            <textarea name="address" id="address" cols="30" rows="5" class="form-control border-dark"
                                placeholder="{{ __('messages.address') }}"></textarea>
                            <div class="invalid-feedback address-error"></div>
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
                url: "{{ route('branch.store') }}", // Laravel route for storing data
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
                        if (errors.email) {
                            $(".email-error").text(errors.email[0]).show();
                        }
                        if (errors.contact_number) {
                            $(".contact-number-error").text(errors.contact_number[0])
                                .show();
                        }
                        if (errors.address) {
                            $(".address-error").text(errors.address[0]).show();
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
