 <div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h3>Upload new theme (zip file)</h3>
                <p>Your new theme will be applied to users dashboard upon upload success.</p>
            </div>

        </div>
        <div class="text-center">
            <form method="post" action="{{route('theme.update')}}" enctype="multipart/form-data" id="themeForm">
                 @csrf
                <input type="file" name='theme' required>
                <button type="submit" class="px-4 btn btn-primary btn-sm" id="themeBtn">Save</button>
                @error('theme')
                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                @enderror
                @if (session()->has('error'))
                    <span class="text-danger d-block mt-2">{{ session('error') }}</span>
                @endif
            </form>
        </div>
    </div>
    <div class="mt-2 d-none" id="loadingTheme">
        <progress max="100"></progress>
        <p>Please wait while the theme is being uploaded, do not refresh this...</p>
    </div>
</div>
 <livewire:admin.theme-display />