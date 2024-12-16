<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as ProductRequest;

class RequestController extends Controller
{
    // Bekleyen talepler
    public function index()
    {
        $requests = ProductRequest::where('status', 'pending')->get();

        return view('admin.requests.index', compact('requests'));
    }

    // Onaylanmış talepler
    public function approvedRequests()
    {
        $approvedRequests = ProductRequest::where('status', 'approved')->get();

        return view('admin.requests.approved', compact('approvedRequests'));
    }

    // Durum güncelleme ve silme
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $productRequest = ProductRequest::findOrFail($id);
        $productRequest->status = $request->status;

        // Durum güncelle
        if ($request->status === 'approved') {
            $productRequest->save();

            return back()->with('success', __('messages.request_updated'));
        }

        // Reddedildiyse sil
        if ($request->status === 'rejected') {
            $productRequest->delete();

            return back()->with('success', __('messages.request_rejected_and_deleted'));
        }
    }

}
