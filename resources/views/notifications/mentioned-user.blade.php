<?php
$comment = App\Comment::find($notification->data['id']);
$type = $notification->data['commentable_type'] === 'articles' ? lang('Article') : lang('Discussion');
$commentable_id = $notification->data['commentable_id'];

if ($comment) {
    switch($comment->commentable_type) {
        case 'articles':
            $article = App\Article::find($commentable_id);
            $url = url($article->slug);
            break;
        case 'discussions':
            $discussion = App\Discussion::find($commentable_id);
            $url = url('discussion', ['id' => $discussion->id]);
            break;
    }
}

?>

<li :class="'{{ empty($notification->read_at) }}' ? 'bold' : ''">
    @if ($comment)
        <a class="text-info" href="{{ url('user', ['username' => $comment->user->name]) }}">{{ $comment->user->name }}</a>
        {{ lang('Mentioned') }} {{ lang('In') }}
        <a class="text-info" href="{{ $url }}">{{ $comment->commentable->title }}</a>
    @else
        <s>{{ strtolower($type) }} {{ lang('Deleted') }}</s>
    @endif
</li>
