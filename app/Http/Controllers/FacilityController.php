<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeFacility;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
            ->where('users.id', auth()->user()->id)
            ->first();

        // Periksa apakah data pengguna dan karyawan ada atau tidak
        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
            return redirect('/facility');
        }

        $facilities = null;
        $employeefacilities = null;
        // Menambahkan filter tipe surat
        $typeFilter = $request->input('type_filter');

        $facilities = Facility::all();
        // Ambil data karyawan dan fasilitas dari database
        $employeeFacilityData = DB::table('employees')
        ->select('employees.id as employee_id', 'employees.firstname', 'employees.lastname', 'employees.position',
        'users.role', 'employee_facility.id as employee_facility_id', 'facilities.facility_name',
        'facilities.remain')
        ->leftJoin('users', 'employees.id', '=', 'users.employee_id')
        ->leftJoin('employee_facility', 'employees.id', '=', 'employee_facility.employee_id')
        ->leftJoin('facilities', 'employee_facility.facility_id', '=', 'facilities.facility_id')
        ->paginate(6)->appends(request()->query());

        if ($employee->role !== null) {
            $role = [
                '0' => 'Employee',
                '1' => 'Manager',
                '2' => 'Branch Manager',
                '3' => 'Human Resource',
            ];
            $employee->role = $role[$employee->role];
        }

        return view("facility.main", [
            'employee' => $employee,
            'facilities' => $facilities,
            'employeeFacilityData' => $employeeFacilityData,
            'typeFilter' => $typeFilter
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function addfacility()
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->where('users.id', auth()->user()->id)
        ->first();

        if ($employee->role != '3') {
        return redirect('/task');
        }

        return view("facility.addfacility", [
            'employee' => $employee,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request)
    {
        $request->validate([
            'facility_name' => 'required|string',
            'description' => 'nullable|string',
            'remain' => 'required|integer',
        ]);

        // Membuat instance baru dari model Facility
        $facility = new Facility;

        // Mengisi instance dengan data yang telah divalidasi dari permintaan
        $facility->facility_name = $request->input('facility_name');
        $facility->description = $request->input('description');
        $facility->remain = $request->input('remain');

        // Menyimpan data ke dalam basis data
        $facility->save();

        return redirect('/facility')->with('success', 'The facility was added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $facilities = Facility::where('facility_id', $id)->first();

        return view("facility.editfacility", [
            'facilities' => $facilities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        if ($request->input('description') !== null) {
            $request->validate(['description' => 'required|string']);
            $facility->update(['description' => $request->input('description')]);
        } elseif ($request->input('remain') !== null){
            $request->validate(['remain' => 'required|integer']);
            $facility->update(['remain' => $request->input('remain')]);
        }

        return redirect('/facility')->with('success', 'The facility detail was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();

        if ($employee->role != '3') {
        return redirect('/facility');
        }
        
        $facility->delete();

        return redirect('/facility')->with('success','The facility was deleted successfully');
    }

    public function employeeadd()
    {
        if (auth()->user()->role !== 3) {
            return redirect('/facility');
        }

        $employeeid = DB::table('users')
        ->join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.employee_id', 'employees.*')
        ->whereNot('users.role', 3)
        ->get();

        $employeeFacilityData = DB::table('employees')
            ->select('employees.id as employee_id', 'employees.firstname', 'employees.lastname', 'employees.position',
            'users.role', 'employee_facility.id as employee_facility_id', 'facilities.facility_name', 'facilities.remain')
            ->leftJoin('users', 'employees.id', '=', 'users.employee_id')
            ->leftJoin('employee_facility', 'employees.id', '=', 'employee_facility.employee_id')
            ->leftJoin('facilities', 'employee_facility.facility_id', '=', 'facilities.facility_id')
            ->get();
        $facilityid = DB::table('facilities')
        ->get();

        return view('facility.addemployee', [
            'employeeid' => $employeeid,
            'facilityid' => $facilityid,
            'employeeFacilityData' => $employeeFacilityData
        ]);
    }
    public function addEmployeeFacility(Request $request, Facility $facility, EmployeeFacility $employeeFacility)
    {
        $request->validate([
            'facility_id' => 'required|integer',
            'employee_id' => 'required|integer',
        ]);
        if ($request->has('delete')) {
            $facility_id = $request->input('facility_id');
            $employee_id = $request->input('employee_id');

            // Cari entri employee_facility yang sesuai
            $entry = $employeeFacility->where('facility_id', $facility_id)
                ->where('employee_id', $employee_id)
                ->first();

            if (!$entry) {
                // Handle jika entri employee_facility tidak ditemukan
                return redirect('/facility?type_filter=employee')->with('error', 'Employee not associated with this
                facility');
            }

            $facility = Facility::where('facility_id', $facility_id)->first();

            if ($facility) {
                // Tambahkan remain di fasilitas yang ditemukan
                $facility->increment('remain');
            } else {
                // Handle jika fasilitas tidak ditemukan
                return redirect('/facility?type_filter=employee')->with('error', 'Facility not found');
            }

            // Hapus data dari tabel employee_facility
            $entry->delete();

            return redirect('/facility?type_filter=employee')->with('success', 'The employee was removed from the facility successfully');
        } else {
            $facility_id = $request->input('facility_id');
            $employee_id = $request->input('employee_id');

            // Cari entri employee_facility yang sesuai
            $entry = $employeeFacility->where('facility_id', $facility_id)
                ->where('employee_id', $employee_id)
                ->first();

            if ($entry) {
                // Handle jika entri employee_facility sudah ada
                return redirect('/facility?type_filter=employee')->with('error', 'Employee already associated with this facility');
            }

            $facility = Facility::where('facility_id', $facility_id)->first();

            if ($facility) {
                // Kurangi remain di fasilitas yang ditemukan
                $facility->decrement('remain');
            } else {
                // Handle jika fasilitas tidak ditemukan
                return redirect('/facility?type_filter=employee')->with('error', 'Facility not found');
            }

            // Tambahkan data ke tabel employee_facility
            $employeeFacility->create([
                'facility_id' => $facility_id,
                'employee_id' => $employee_id,
            ]);

            return redirect('/facility?type_filter=employee')->with('success', 'The employee was added to the facility successfully');
        }
    }
}
