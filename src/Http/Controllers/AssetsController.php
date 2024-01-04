<?php

namespace Helious\SeatAssets\Http\Controllers;

use Seat\Eveapi\Models\Sde\SolarSystem;
use Seat\Eveapi\Models\Sde\InvGroup;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Eveapi\Models\Sde\StaStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\Eveapi\Models\Assets\CharacterAsset;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetsController extends Controller
{
    /**
     * Show the eligibility checker.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systems = SolarSystem::all();
        $assets = InvGroup::where('categoryID', 6)->get();
        return view('seat-assets::index', compact('systems', 'assets'));
    }

    /**
     * Check for assets.
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'system' => 'required',
            'assets' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect('assets')
                ->withErrors($validator)
                ->withInput();
        }
    
        $system = $request->input('system');
        $assets = $request->input('assets');

        // get all the invType ID's for the selected assets
        $assetIDs = InvType::whereIn('groupID', $assets)->pluck('typeID');
    
        // Filter stations and structures based on the system input
        $stationsInSystems = StaStation::whereIn('solarSystemID', $system)->pluck('stationName', 'stationID');
        $structuresInSystems = UniverseStructure::whereIn('solar_system_id', $system)->pluck('name', 'structure_id');

        // Combine the filtered station and structure data
        $filteredLocations = $stationsInSystems->union($structuresInSystems);

        // Fetch only the assets that are in the filtered locations
        $characterAssets = CharacterAsset::whereIn('type_id', $assetIDs)
            ->whereIn('location_id', $filteredLocations->keys())
            ->get();

        $processedAssets = collect();

        foreach ($characterAssets as $asset) {
            $locationName = $filteredLocations->get($asset->location_id) ?? 'Unknown';

            $processedAsset = [
                'item_id' => $asset->type->typeID,
                'hull' => $asset->type->typeName,
                'location_name' => $locationName,
                'belongs_to' => $asset->character->user->name
            ];

            $processedAssets->push($processedAsset);
        }

        // convert $system to a collection and get the names of the systems
        $systemsList = SolarSystem::whereIn('system_id', $system)->pluck('name');

        // convert $assets to a collection and get the names of the assets
        $assetsList = InvGroup::whereIn('groupID', $assets)->pluck('groupName');


        return view('seat-assets::check', compact('processedAssets', 'systemsList', 'assetsList'));

    }

    /**
     * Show the systems.
     *
     * @return \Illuminate\Http\Response
     */
    public function systems(Request $request) {
        if ($request->ajax()) {
            $searchTerm = $request->input('search', '');
    
            // Fetch systems based on the search term
            $systems = SolarSystem::where('name', 'LIKE', '%' . $searchTerm . '%')->get()->map(function ($system) {
                return ['system_id' => $system->system_id, 'name' => $system->name];
            });            
    
            return response()->json($systems);
        }
    
        return redirect()->route('seat-assets::index');
    }


}
