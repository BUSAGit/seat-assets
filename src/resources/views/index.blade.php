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
                        @foreach ($systems as $system)
                            <option value="{{ $system->system_id }}" {{ old('system') == $system->system_id ? 'selected' : '' }}>{{ $system->name }}</option>
                        @endforeach
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
        $('#system').select2();
        $('#assets').select2();
    });
  </script>

@endpush