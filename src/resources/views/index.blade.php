@extends('web::layouts.grids.12', ['viewname' => 'seat-assets::index'])

@section('page_header', 'Asset Checker')

@section('full')
    <div class="card">
        <div class="card-header">Select Ship Type And System</div>
        <div class="card-body">
            <div class="alert alert-info text-center" role="alert">
                This is a work in progress and some searches may take a while to complete, please be patient. <i class="fas fa-info-circle"></i>
            </div>
            <div class="mb-3">
                <form action="{{route('seat-assets::check')}}" method="post">
                    @csrf
                    <label for="system">System</label>
                    <select multiple="multiple" id="system" name="system[]" class="form-control" style="width: 100%;">
   
                    </select>
                    <label for="assets" class="mt-2">Assets</label>
                    <select multiple="multiple" id="assets" name="assets[]" class="form-control" style="width: 100%;">
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->groupID }}" {{ old('asset') == $asset->groupID ? 'selected' : '' }}>{{ $asset->groupName }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-4">Check For Assets</button>
                </form>
            </div>
        </div>
    </div>
@stop

@push('javascript')

<script>
$(document).ready(function() {
    $('#system').select2({
        ajax: {
            url: '{{ route('seat-assets::systems') }}', // Use the Laravel route for the AJAX URL
            dataType: 'json',
            delay: 250, // Delay in milliseconds after typing before sending the AJAX request
            data: function (params) {
                return {
                    search: params.term // search term
                };
            },
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.system_id,
                            text: item.name
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1 // Minimum number of characters required to start the AJAX request
    });

    $('#assets').select2(); // Regular Select2 initialization for 'assets'
});
</script>


@endpush