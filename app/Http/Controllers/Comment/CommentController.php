<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\task;
use App\Models\User;
use App\Notifications\CommentReplyNotification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'own_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
        ]);

        task::query()->find($request->task_id)->comments()->create([
            'body' => $request->body,
            'own_id' => $request->own_id,
        ]);

        return response(null)->setStatusCode(Response::HTTP_CREATED);
    }

    public function reply(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'parent_id' => 'required|exists:comments,id',
            'own_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
        ]);

        $comment = task::query()->find($request->task_id)->comments()->create([
            'body' => $request->body,
            'own_id' => $request->own_id,
            'parent_id' => $request->parent_id,
        ]);

        User::query()->whereHas('comments', fn ($q) => $q->where('comments.id', $request->parent_id))
            ->get()->each(fn ($user) => $user->notify(new CommentReplyNotification($comment)));

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    public function getComments(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        return response(Comment::query()->with(['replies', 'owner'])->whereHas('commentable',
            fn ($query) => $query->where('tasks.id', $request->query('task_id'))
        )->get());
    }

    public function delete($id)
    {
        Comment::query()->findOrFail($id)->delete();

        return response(null)->setStatusCode(Response::HTTP_OK);
    }
}
