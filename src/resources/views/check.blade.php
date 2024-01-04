@extends('web::layouts.grids.12', ['viewname' => 'seat-assets::check'])

@section('page_header', 'Asset Checker')

@section('full')
    <div class="card">
        <div class="card-header">Results</div>
        <div class="card-body">
            <h4 class="card-title">Found {{ $processedAssets->count() }} results</h4>
            <br>
            <p>
                This result was based on the search @foreach($assetsList as $asset){{$asset}}'s,@endforeach in @foreach($systemsList as $systems){{$systems}}@endforeach
            </p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Hull</th>
                        <th>Location</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($processedAssets as $asset)
                        <tr>
                            <td>
                                <img src="//images.evetech.net/types/{{ $asset['item_id'] }}/icon?size=32" class="img-circle eve-icon small-icon">
                                {{ $asset['hull'] }}
                            </td>
                            <td>{{ $asset['location_name'] }}</td>
                            <td>{{ $asset['belongs_to'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop