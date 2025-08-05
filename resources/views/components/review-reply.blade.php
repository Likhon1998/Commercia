<div class="bg-gray-100 p-2 rounded ml-4">
    <div class="flex justify-between text-sm text-gray-600">
        <span>{{ $reply->user->name ?? 'Unknown' }} replied:</span>
        <span class="text-xs">{{ $reply->created_at->diffForHumans() }}</span>
    </div>

    {{-- Reply Content or Edit Form --}}
    @if(session('editing_reply') == $reply->id)
        {{-- Edit Form --}}
        <form action="{{ route('reviews.replies.update', $reply->id) }}" method="POST" class="mt-1">
            @csrf
            @method('PUT')
            <textarea name="reply" rows="2" class="w-full px-3 py-2 border rounded text-sm" required>{{ old('reply', $reply->reply) }}</textarea>
            <div class="mt-1 flex gap-2">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                    Save
                </button>
                <a href="{{ url()->previous() }}" class="text-xs text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    @else
        <p class="text-sm text-gray-700 mt-1">{{ $reply->reply }}</p>
    @endif

    {{-- Edit & Delete Buttons --}}
    @auth
        @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
            <div class="flex gap-2 mt-1">
                {{-- Edit --}}
                <form action="{{ route('reviews.replies.edit', $reply->id) }}" method="GET">
                    <button type="submit" class="text-blue-500 text-xs hover:underline">Edit</button>
                </form>

                {{-- Delete --}}
                <form action="{{ route('reviews.replies.destroy', $reply->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this reply?')"
                            class="text-red-500 text-xs hover:underline">
                        Delete
                    </button>
                </form>
            </div>
        @endif
    @endauth

    {{-- Nested Replies --}}
    @if($reply->replies && $reply->replies->count())
        <div class="mt-2 space-y-2">
            @foreach($reply->replies as $nestedReply)
                @include('components.review-reply', ['reply' => $nestedReply])
            @endforeach
        </div>
    @endif

    {{-- Nested Reply Form --}}
    @auth
        <form action="{{ route('reviews.reply', $reply) }}" method="POST" class="mt-2">
            @csrf
            <input type="hidden" name="review_id" value="{{ $reply->review_id }}">
            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
            <input type="text" name="reply" placeholder="Reply to this comment..."
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring text-sm" required>
            <button type="submit"
                    class="mt-1 bg-blue-400 hover:bg-blue-500 text-white px-2 py-1 rounded text-xs">
                Reply
            </button>
        </form>
    @endauth
</div>
