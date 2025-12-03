@extends('layouts.backend')

@section('main')
    <div class="modal show d-block" id="branchModal" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true"
        style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Branch</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.branch.assign.update') }}" method="POST" id="branchSelectForm">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
                        <div class="mb-3">
                            <label for="branch_id" class="form-label">Choose Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select" required
                                onchange="this.form.submit()">
                                <option value="">-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Select</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JS to auto-focus -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('branch_id').focus();
        });
    </script>
@endsection
