<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManageCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;
use Stevebauman\Purify\Facades\Purify;

class ManageCategoryController extends Controller
{
    public function categoryList()
    {
        $manageCategory = ManageCategory::latest()->get();
        return view('admin.category.list', compact('manageCategory'));
    }

    public function categoryCreate()
    {
        return view('admin.category.create');
    }

    public function categoryStore(Request $request)
    {
        $reqData = Purify::clean($request->except('_token', '_method'));

        $request->validate([
            'name' => 'required',
        ]);

        $capital_back = isset($reqData['capital_back']) ? 1 : 0;
        $status = isset($reqData['status']) ? 1 : 0;

        $data = new ManageCategory();
        $data->name = $reqData['name'];
        $data->capital_back = $capital_back;
        $data->status = $status;
        $data->save();

        return back()->with('success', 'Category has been Added');
    }

    public function categoryEdit($id)
    {
        $data = ManageCategory::findOrFail($id);
        return view('admin.category.edit', compact('data'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $data = ManageCategory::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

        $reqData = Purify::clean($request->except('_token', '_method'));

        $capital_back = isset($reqData['capital_back']) ? 1 : 0;
        $status = isset($reqData['status']) ? 1 : 0;

        $data->name = $reqData['name'];
        $data->capital_back = $capital_back;
        $data->status = $status;
        $data->save();

        return back()->with('success', 'Category has been Updated');
    }

    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            ManageCategory::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'User Status Has Been Active');
            return response()->json(['success' => 1]);
        }
    }

    public function inActiveMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            ManageCategory::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'User Status Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }
}