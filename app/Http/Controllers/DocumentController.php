<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Notifications\DocumentSentNotification;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource at Main Office.
     */
    public function index()
    {
        $documents = Document::all();
        $users = User::all();
        return view('admin.documents.index', compact('documents', 'users'));
    }

    /**
     * Display a listing of the resource at Other Offices.
     */
    public function indexOffice()
    {
        $documents = Document::where('recipient_office', auth()->user()->office)
            ->orWhere('recipient_user_id', auth()->id())
            ->get();

        return view('user.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'taxpayer_name' => 'required|string|max:255',
            'taxable_period' => 'required|string|max:255',
            'docket_owner' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'RDO' => 'required|string|max:255', 
            'date_received' => 'required|date',
        ]);

        $validatedData['status'] = 'pending';

        Document::create($validatedData);

        return redirect()->route('documents.index')->with('success', 'Document added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'document_type' => 'required|string|max:255',
            'taxpayer_name' => 'required|string|max:255',
            'taxable_period' => 'required|string|max:255',
            'docket_owner' => 'required|string|max:255',
            'RDO' => 'required|string|max:255',
            'date_received' => 'required|date',
        ]);
    
        $document->update($request->all());
    
        return redirect()->back()->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,finalized',
        ]);

        $document = Document::findOrFail($id);
        $document->status = $request->status;
        $document->save();

        return response()->json(['success' => true]);
    }

    /**
     * Send the document to the selected recipient.
     */
    public function send(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'recipient_office' => 'required|string|in:Assessment,Collection,Legal,Finance,AMRMD,RID,DPD',
        ]);

        $document = Document::findOrFail($request->document_id);
        $document->recipient_office = $request->recipient_office;
        $document->time_sent = now();
        $document->save();

        logger("Document updated: {$document->id}");

        $users = User::where('office', $request->recipient_office)->get();
        logger("Users to notify: " . $users->count());

        foreach ($users as $user) {
            $user->notify(new DocumentSentNotification($document));
            logger("Notification sent to user: {$user->name} ({$user->email})");
        }

        return redirect()->route('documents.index')->with('success', 'Document sent successfully!');
    }
}
