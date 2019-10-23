<?php

namespace App\Http\Controllers;

use App\NormalCategory;
use Illuminate\Http\Request;

class NormalCategoryController extends Controller
{
    public function __construct(NormalCategory $normalCategory)
    {
    	$this->normalCategory = $normalCategory;
    }

    public function manageNormalCategories()
    {
	    return view('pages.manage-normal-categories');
    }

	public function indexApi()
    {
        return $this->normalCategory->orderBy('updated_at', 'desc')->get();
    }

    public function storeApi(Request $request)
    {
    	$data = $request->validate([
    		'order' => 'integer',
    		'text' => '',
    		'is_active' => 'boolean'
    	]);

        if ($normalCategory = $this->normalCategory->create($data)) {
            activity()
                ->performedOn($normalCategory)
                ->causedBy($request->user())
                ->withProperties($normalCategory->toArray())
                ->log('created a normal category');

            return $normalCategory;
        }
    }

    public function edit($normalCategoryId)
    {
        return view('pages.edit-normal-category', compact('normalCategoryId'));
    }

    public function updateApi(Request $request, NormalCategory $normalCategory)
    {
    	$data = $request->validate([
    		'order' => 'integer',
    		'text' => '',
    		'is_active' => 'boolean'
    	]);

        $normalCategory->fill($data);

        if ($normalCategory->isDirty()) {
            if ($normalCategory->save()) {
                activity()
                    ->performedOn($normalCategory)
                    ->causedBy($request->user())
                    ->withProperties($normalCategory->toArray())
                    ->log('updated a normal category');
            }
        }
 
        return $normalCategory;
    }

    public function showApi(NormalCategory $normalCategory)
    {
        return $normalCategory;
    }


    public function selectOptions()
    {
    	return $this->normalCategory->get(['id','text']);
    }

    public function destroyApi(NormalCategory $normalCategory)
    {
        $logModel = $normalCategory;
        if ($normalCategory->delete()) {
            activity()
                ->performedOn($logModel)
                ->causedBy(request()->user())
                ->log('updated a normal category');
            return response()->json([
                'message' => 'deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'unable to delete'
        ], 409);
    }
}
