<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // /**
    //  * Display chat list and messages
    //  *
    //  * @param int|null $chatId The ID of the current chat to display
    //  * @return \Illuminate\View\View
    //  */
    // public function index($chatId = null)
    // {
    //     $user = Auth::user();

    //     // Get all chats where this user is involved, ordered by latest message
    //     $chats = $user->chats()
    //         ->with(['details' => function($query) {
    //             $query->latest('date_time');
    //         }])
    //         ->get()
    //         ->sortByDesc(function($chat) {
    //             return $chat->details->first()->date_time ?? $chat->date_time_created;
    //         });

    //     $currentChat = null;
    //     $otherUser = null;

    //     if ($chatId) {
    //         $currentChat = $chats->where('chat_id', $chatId)->first();

    //         if ($currentChat) {
    //             // Get the other user in this chat
    //             $otherUser = $currentChat->users->where('user_id', '!=', $user->user_id)->first();

    //             // Load messages for this chat
    //             $currentChat->load(['details.user' => function($query) {
    //                 $query->select('user_id', 'name', 'role');
    //             }]);
    //         }
    //     }

    //     return view('chat.index', compact('chats', 'currentChat', 'otherUser'));
    // }

    // /**
    //  * Start a new chat with another user
    //  *
    //  * @param int $userId The ID of the user to chat with
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function startChat($userId)
    // {
    //     $otherUser = User::findOrFail($userId);
    //     $currentUser = Auth::user();

    //     // Verify the other user is a driver if current user is regular
    //     if ($currentUser->isRegularUser() && !$otherUser->isDriver()) {
    //         abort(403, 'You can only chat with drivers');
    //     }

    //     // Verify the other user is regular if current user is driver
    //     if ($currentUser->isDriver() && !$otherUser->isRegularUser()) {
    //         abort(403, 'Drivers can only chat with regular users');
    //     }

    //     // Check if chat already exists
    //     $existingChat = $this->findExistingChat($currentUser, $otherUser);

    //     if (!$existingChat) {
    //         // Create new chat
    //         $chat = Chat::create([
    //             'date_time_created' => now()
    //         ]);

    //         // Add initial message
    //         $welcomeMessage = $currentUser->isDriver()
    //             ? "Hello, I'm your driver {$currentUser->name}"
    //             : "Hello driver, I need assistance with my order";

    //         ChatDetail::create([
    //             'chat_id' => $chat->chat_id,
    //             'user_id' => $currentUser->user_id,
    //             'detail_chat' => $welcomeMessage,
    //             'date_time' => now()
    //         ]);

    //         return redirect()->route('chat.show', $chat->chat_id);
    //     }

    //     return redirect()->route('chat.show', $existingChat->chat_id);
    // }

    // /**
    //  * Send a message in a chat
    //  *
    //  * @param Request $request The HTTP request
    //  * @param int $chatId The ID of the chat
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function sendMessage(Request $request, $chatId)
    // {
    //     $request->validate([
    //         'message' => 'required|string|max:500',
    //         'photo' => 'nullable|image|max:2048'
    //     ]);

    //     $chat = Chat::findOrFail($chatId);
    //     $user = Auth::user();

    //     // Verify user is part of this chat
    //     if (!$chat->users->contains($user->user_id)) {
    //         abort(403, 'You are not part of this chat');
    //     }

    //     $photoPath = null;
    //     if ($request->hasFile('photo')) {
    //         $photoPath = $request->file('photo')->store('chat_photos', 'public');
    //     }

    //     $message = ChatDetail::create([
    //         'user_id' => $user->user_id,
    //         'chat_id' => $chat->chat_id,
    //         'detail_chat' => $request->message,
    //         'photos' => $photoPath,
    //         'date_time' => now()
    //     ]);

    //     // For realtime functionality (we'll implement this later)
    //     // broadcast(new NewMessage($message))->toOthers();

    //     return back()->with('success', 'Message sent');
    // }

    // /**
    //  * Find existing chat between two users
    //  *
    //  * @param User $user1 First user
    //  * @param User $user2 Second user
    //  * @return Chat|null The existing chat or null if not found
    //  */
    // protected function findExistingChat($user1, $user2)
    // {
    //     return Chat::whereHas('details', function($query) use ($user1) {
    //             $query->where('user_id', $user1->user_id);
    //         })
    //         ->whereHas('details', function($query) use ($user2) {
    //             $query->where('user_id', $user2->user_id);
    //         })
    //         ->first();
    // }
}
