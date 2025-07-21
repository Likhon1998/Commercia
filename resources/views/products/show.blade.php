<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">📦 Product Details</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-6">
        {{-- Product Section --}}
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Product Images --}}
            <div>
                @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                         class="w-full rounded-lg shadow" alt="Main image">
                @endif

                @if($product->images->count() > 1)
                    <div class="flex gap-2 mt-4">
                        @foreach($product->images->where('is_primary', false) as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 class="w-20 h-20 object-cover rounded border" alt="Extra">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mb-2"><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                <p class="text-md text-gray-700 mb-2"><strong>Price:</strong> ${{ $product->price }}</p>
                <p class="text-md text-gray-700 mb-2"><strong>Availability:</strong>
                    @if($product->stock_qty > 0)
                        <span class="text-green-600 font-semibold">{{ $product->stock_qty }} in stock</span>
                    @else
                        <span class="text-red-600 font-semibold">Out of stock</span>
                    @endif
                </p>

                @if($product->attributeValues->count())
                    <div class="mb-3">
                        <strong class="block text-sm text-gray-700">Attributes:</strong>
                        <ul class="list-disc pl-5 text-sm text-gray-600">
                            @foreach($product->attributeValues as $attr)
                                <li>{{ $attr->attribute->name }}: {{ $attr->value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-4">
                    <strong class="text-sm text-gray-700">Description:</strong>
                    <p class="text-sm text-gray-600 mt-1">{{ $product->description }}</p>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-6 flex gap-3">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                        🛒 Add to Cart
                    </button>
                    <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow text-sm">
                        ❤️ Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        {{-- Reviews Section --}}
        <div class="mt-12 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📝 Customer Reviews</h3>

            {{-- Add Review --}}
            @auth
                <form action="{{ route('reviews.store', $product) }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <textarea name="comment" rows="3" class="w-full p-3 border rounded focus:outline-none focus:ring"
                              placeholder="Write your review here..." required></textarea>
                    <button type="submit"
                            class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                        Submit Review
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-500 mb-4">Please <a href="{{ route('login') }}" class="text-blue-600">log in</a> to leave a review.</p>
            @endauth

            {{-- Display Reviews --}}
            @forelse($product->reviews as $review)
                <div class="mb-6 border-b pb-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-800">{{ $review->user->name ?? 'Unknown' }}</span>
                        <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>

                    {{-- Replies --}}
                    <div class="ml-4 mt-3 space-y-2">
                        @foreach($review->replies as $reply)
                            <div class="bg-gray-100 p-2 rounded">
                                <span class="text-xs text-gray-500">{{ $reply->user->name ?? 'Unknown' }} replied:</span>
                                <p class="text-sm text-gray-700">{{ $reply->reply }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Reply Form --}}
                    @auth
                        <form action="{{ route('reviews.reply', $review) }}" method="POST" class="mt-3 ml-4">
                            @csrf
                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                            <input type="text" name="reply" placeholder="Write a reply..."
                                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring text-sm" required>
                            <button type="submit"
                                    class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                Reply
                            </button>
                        </form>
                    @endauth
                </div>
            @empty
                <p class="text-gray-500 text-sm">No reviews yet. Be the first to review this product!</p>
            @endforelse
        </div>
    </div>
</x-layouts.sidebar>
