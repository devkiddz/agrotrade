@extends('layouts.app')
@section('title', 'Create Investment Plan')

@section('styles')
<link href="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="mt-2">
    @include('admin.atlantis.layout.alert')
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Create New Investment Plan</h4>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Plans
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if($categories->isEmpty())
                                <small class="text-danger">No categories found. <a href="{{ route('admin.plans.categories') }}">Create a category first</a></small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="icon">Plan Icon (Optional)</label>
                                <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                                <small class="text-muted">Recommended size: 64x64px</small>
                            </div>

                            <div class="form-group">
                                <label for="min_amount">Minimum Investment <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $settings->currency }}</span>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="min_amount" name="min_amount" value="{{ old('min_amount') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="max_amount">Maximum Investment <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $settings->currency }}</span>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="max_amount" name="max_amount" value="{{ old('max_amount') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="roi_percentage">ROI Percentage <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" id="roi_percentage" name="roi_percentage" value="{{ old('roi_percentage') }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="roi_interval">ROI Interval <span class="text-danger">*</span></label>
                                <select class="form-control" id="roi_interval" name="roi_interval" required>
                                    <option value="hourly" {{ old('roi_interval') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                    <option value="daily" {{ old('roi_interval') == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('roi_interval') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('roi_interval') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="duration">Plan Duration <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="duration_unit" name="duration_unit" required>
                                            <option value="hours" {{ old('duration_unit') == 'hours' ? 'selected' : '' }}>Hours</option>
                                            <option value="days" {{ old('duration_unit') == 'days' ? 'selected' : '' }}>Days</option>
                                            <option value="weeks" {{ old('duration_unit') == 'weeks' ? 'selected' : '' }}>Weeks</option>
                                            <option value="months" {{ old('duration_unit') == 'months' ? 'selected' : '' }}>Months</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_featured">Featured Plan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Plan Description <span class="text-danger">*</span></label>
                        <textarea class="form-control summernote" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Create Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection
