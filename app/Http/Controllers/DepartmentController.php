<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index() {
        // eloquent
        // $departments = Department::all();
        // paginate
        $departments = Department::paginate(3);

        // query builder
        // $departments = DB::table('departments')->get();
        // paginate
        // $departments = DB::table('departments')
        // ->join('users', 'departments.user_id', 'users.id')
        // ->select('departments.*', 'users.name')
        // ->paginate(3);

        $trashDepartments = Department::onlyTrashed()->paginate(3);

        return view('admin.department.index', compact('departments', 'trashDepartments'));
    }

    public function store(Request $request) {
        // dd($request->department_name);
        $request->validate([
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required' => 'Department name must be not empty',
            'department_name.max' => 'Department name must less than 256',
            'department_name.unique' => 'Duplicate name of department'
        ]);
        // eloquent
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();

        // query builder
        $data = array();
        $data['department_name'] = $request->department_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('departments')->insert($data);

        return redirect()->back()->with('success', 'Save completely');
    }

    public function edit($id) {
        // dd($id);

        // eloquent
        $department = Department::find($id);
        // dd($department);
        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id) {
        // dd($id, $request->department_name);
        $request->validate([
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required' => 'Department name must be not empty',
            'department_name.max' => 'Department name must less than 256',
            'department_name.unique' => 'Duplicate name of department'
        ]);

        Department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);

        return redirect()->route('department')->with('success', 'Update completely');
    }

    public function softdelete($id) {
        Department::find($id)->delete();
        return redirect()->back()->with('success', 'Update completely');
    }

    public function restore($id) {
        Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'Restore completely');
    }

    public function delete($id) {
        Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'Permanent Delete completely');
    }
}
