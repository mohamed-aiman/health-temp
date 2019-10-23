<?php

namespace App\Http\Controllers;

use App\GradingCategory;
use Illuminate\Http\Request;

class GradingCategoryController extends Controller
{
    public function __construct(GradingCategory $gradingCategory)
    {
    	$this->gradingCategory = $gradingCategory;
    }

    public function manageGradingCategories()
    {
	    return view('pages.manage-grading-categories');
    }

	public function indexApi()
    {
        return $this->gradingCategory->orderBy('updated_at', 'desc')->get();
    }

    public function storeApi(Request $request)
    {
    	$data = $request->validate([
    		'order' => 'integer',
    		'text' => '',
    		'is_active' => 'boolean'
    	]);

        if ($gradingCategory = $this->gradingCategory->create($data)) {
                activity()
                   ->performedOn($gradingCategory)
                   ->causedBy($request->user())
                   ->withProperties($gradingCategory->toArray())
                   ->log('created grading category');

            return $gradingCategory;
        }

    }

    public function edit($gradingCategoryId)
    {
        return view('pages.edit-grading-category', compact('gradingCategoryId'));
    }

    public function updateApi(Request $request, GradingCategory $gradingCategory)
    {
    	$data = $request->validate([
    		'order' => 'integer',
    		'text' => '',
    		'is_active' => 'boolean'
    	]);

        $gradingCategory->fill($data);

        if ($gradingCategory->isDirty()) {
            if ($gradingCategory->save()) {
                $gradingCategory = $gradingCategory->fresh();
                activity()
                   ->performedOn($gradingCategory)
                   ->causedBy($request->user())
                   ->withProperties($gradingCategory->toArray())
                   ->log('updated grading category');
            }
        }
 
        return $gradingCategory;
    }

    public function showApi(GradingCategory $gradingCategory)
    {
        return $gradingCategory;
    }


    public function selectOptions()
    {
    	return $this->gradingCategory->get(['id','text']);
    }

    public function destroyApi(Request $request, GradingCategory $gradingCategory)
    {
        $logModel = $gradingCategory;
        if ($gradingCategory->delete()) {
            activity()
                ->performedOn($logModel)
                ->causedBy($request->user())
                ->log('deleted  grading category');
            return response()->json([
                'message' => 'deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'unable to delete'
        ], 409);
    }
}
