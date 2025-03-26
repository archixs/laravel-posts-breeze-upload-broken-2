<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List of All Posts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Create Post Button -->
                    <div class="mb-4 text-right">
                        <a href="/posts/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">Create New Post</a>
                    </div>

                    <!-- Post List -->
                    <div class="space-y-6">
                        @foreach($posts as $post)
                        <div class="border-b border-gray-300 dark:border-gray-700 pb-6">
                            <!-- Post Title and Content -->
                            <div class="space-y-2">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $post->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ $post->content }}</p>

                                <!-- Post Image (if any) -->
                                @if ($post->image_path)
                                <div class="my-4">
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="rounded-md shadow-md">
                                </div>
                                @endif
                            </div>

                            <!-- Comments Section -->
                            <div class="mt-4">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Comments</h4>
                                <div class="space-y-2 mt-2">
                                    @foreach($comments as $comment)
                                        @if ($comment->post_id == $post->id)
                                            <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }} By: {{ $comment->user->name }}</p>

                                            @if(auth()->user()->id == $comment->user_id || auth()->user()->id == $comment->user->id)
                                            
                                                <form action="/comments/{{ $comment->id }}/delete" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold transition duration-200">Delete</button>
                                                </form>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Comment Form -->
                            <div class="mt-4">
                                <form action="/posts/{{$post->id}}" method="post" class="flex space-x-2">
                                    @csrf
                                    <input type="text" name="comment" id="comment" class="border border-gray-300 dark:border-gray-600 rounded-lg p-2 flex-1 text-black" placeholder="Add a comment..." required>
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">Submit</button>
                                </form>
                            </div>

                            <a href="/posts/{{ $post->id }}/show">Show</a>
                            
                            <!-- Post Delete Button -->
                            <div class="mt-4 text-right">
                                <form action="/posts/{{ $post->id }}" method="post" class="inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>