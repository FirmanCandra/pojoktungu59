<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function markRead(int $id)
    {
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
        return back()->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    public function destroy(int $id)
    {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
