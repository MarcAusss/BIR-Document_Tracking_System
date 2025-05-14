<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Admin Dashboard.
     */
    public function adminDashboard()
    {
        // Fetch the total number of users
        $totalUsers = User::count();

        // Fetch the count of read notifications
        $receivedDocumentsCount = DB::table('notifications')
            ->whereNotNull('read_at')
            ->count();

        // Fetch other data for the dashboard
        $pendingDocumentsCount = Document::where('status', 'pending')->count();
        $totalDocuments = Document::count();
        $recentDocuments = Document::orderBy('updated_at', 'desc')->take(9)->get();
        $readNotificationsWithDocuments = DB::table('notifications')
            ->join('documents', 'notifications.data->document_id', '=', 'documents.id')
            ->select(
                'notifications.id as notification_id',
                'notifications.read_at',
                'documents.document_type',
                'documents.taxpayer_name',
                'documents.docket_owner',
                'documents.recipient_office',
                'documents.time_sent'
            )
            ->whereNotNull('notifications.read_at')
            ->orderBy('notifications.read_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('totalUsers', 'receivedDocumentsCount', 'totalDocuments', 'pendingDocumentsCount', 'recentDocuments', 'readNotificationsWithDocuments'));
    }

    /**
     * User Dashboard.
     */
    public function userDashboard()
    {
        $userOffice = auth()->user()->office;

        $documents = Document::where('recipient_office', $userOffice)->get();

        $documentCount = $documents->count();


        return view('user.dashboard', compact('documents', 'documentCount'));
    }

    /**
     * Redirect to appropriate dashboard based on role.
     */
    public function redirectToDashboard()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }

        abort(403, 'Unauthorized');
    }
}