<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MontajController extends Controller
{
    public function index()
    {
        // order by more qty
        $data['devices'] = \App\Models\Montaj\Device::withSum(['sales' => function($query) {
            $query->where('status', 'new');
        }], 'qty')->orderBy('sales_sum_qty', 'desc')->get();

        $data['newSales'] = \App\Models\Montaj\Sales::with('device')
            ->where('status', 'new')
            ->orderBy('exit_date')
            ->get();
        return view('Montaj.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'devices' => 'required|array',
            'devices.*.selected' => 'sometimes|required|in:1',
            'devices.*.qty' => 'required_with:devices.*.selected|integer|min:1',
            'customer_name' => 'required|string'
        ]);

        $hasSelectedDevice = false;
        foreach ($request->devices as $deviceId => $data) {
            if (isset($data['selected'])) {
                $hasSelectedDevice = true;
                // Create record with deviceId and its quantity
                \App\Models\Montaj\Sales::create([
                    'device_id' => $deviceId,
                    'qty' => $data['qty'],
                    'customer_name' => $request->customer_name,
                    'exit_date' => $request->exit_date,
                ]);
            }
        }

        if (!$hasSelectedDevice) {
            return back()->withErrors(['devices' => 'لطفا حداقل یک دستگاه را انتخاب کنید']);
        }

        return redirect()->back()->with('success', 'اطلاعات با موفقیت ثبت شد');
    }

    public function toggleStatus(Request $request)
    {
        $ids = explode(',', $request->ids);
        $status = $request->status;

        // Update all sales with the given IDs
        \App\Models\Montaj\Sales::whereIn('id', $ids)
            ->update(['status' => $status]);

        return redirect()->back()->with('success', 'وضعیت با موفقیت تغییر کرد.');
    }
}
