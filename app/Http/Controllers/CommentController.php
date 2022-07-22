<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\task;
use App\Models\User;
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


        User::query()->whereHas('comments', function ($query) use ($request) {
            $query->where('comments.id', $request->parent_id);
        })->get()->each(function ($user) use ($comment) {
            $user->notify(new \App\Notifications\CommentReplyNotification($comment));
        });

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    public function delete($id)
    {
        Comment::query()->findOrFail($id)->delete();
        return response(null)->setStatusCode(Response::HTTP_OK);
    }

}
