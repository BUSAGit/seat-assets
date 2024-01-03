@extends('web::layouts.grids.12', ['viewname' => 'seat-assets::index'])

@section('page_header', 'Asset Checker')

@section('full')
    <div class="card">
        <div class="card-header">Select Ship Type And System</div>
        <div class="card-body">
            <div class="mb-3">
                <select multiple="multiple" id="dt-character-selector" class="form-control" style="width: 100%;">
                    <option value="444">444</option>
                </select>
            </div>
        </div>
    </div>
@stop
