<?php

namespace App\Http\Controllers;

use App\BasicError;
use App\Comment;
use App\CommentPost;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {

        $data = array();
        $postValid = Post::where('id', $id)->first();
        if ($postValid != null) {
            $post = Post::where('id', $id)->get();
            $postComments = Post::find($id)->comment()->paginate(2);

            foreach ($postComments as $postComment) {

                $arrayPush = array_push($data, array(
                        "data" => array(
                            "id" => $postComment->id,
                            "author" => array(
                                "id" => $postComment->user->id,
                                "name" => $postComment->user->name,
                                "email" => $postComment->user->email,
                            ),
                            "body" => $postComment->body,
                            "created_at" => (string)$postComment->created_at,
                            "updated_at" => (string)$postComment->updated_at
                        )
                    )
                );

            }
            $jsondata = json_decode($postComments->toJson());
            $arrayPush = array_push($data, array(

                    "links" => array(
                        "first" => $jsondata->first_page_url,
                        "last" => $jsondata->last_page_url,
                        "prev" => $jsondata->prev_page_url,
                        "next" => $jsondata->next_page_url,
                    ),

                    "meta" => array(
                        "current_page" => $jsondata->current_page,
                        "from" => $jsondata->from,
                        "last_page" => $jsondata->last_page,
                        "path" => $jsondata->path,
                        "per_page" => $jsondata->per_page,
                        "to" => $jsondata->to,
                        "total" => $jsondata->total
                    )
                )
            );


            return response($data)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(200, 'The posts');

        } else {

            return response('Post not found')
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(404, 'Post not found');
        }
    }


    public function postComment($postid)
    {

        $commentArray = array();
        $comments = Post::find($postid)->comment()->get();
        foreach ($comments as $comment) {

            $commentArray1 = array_push($commentArray,
                array(
                    "id" => $comment->id,
                    "author" => array(
                        "id" => $comment->user->id,
                        "name" => $comment->user->name,
                        "email" => $comment->user->email,
                    ),
                    "body" => $comment->body,
                    "created_at" => (string)$comment->created_at,
                    "updated_at" => (string)$comment->updated_at,
                )
            );


        }
        return $commentArray;
    }

    public function create(Request $request, $id)
    {
        $postValid = Post::where('id', $id)->first();
        $error = array();
        if ($postValid != null) {
            $data = json_decode($request->getContent(), true);

            if (isset($data["author"]["id"]) && (int)$data["author"]["id"] != null) {

                $user = User::where('id', $data["author"]["id"])->first();

                if ($user == null) {
                    $error = $this->error(401);

                    return response($error)
                        ->header('Content-Type', 'text/plain')
                        ->setStatusCode(401, $error["message"]);
                }
                $commentValid = Comment::where('id', $data["id"])->first();
                if ($commentValid == null) {

                    if (!$data["body"] == 0 &&
                        !$data["body"] == "" &&
                        !$data["body"] == null
                    ) {

                        $storeComments = array(
                            "id" => (int)$data["id"],
                            "author" => (int)$data["author"]["id"],
                            "body" => (string)$data["body"]
                        );

                        $storeComment = $this->storeComments($storeComments);
                        CommentPost::create([
                            'comment_id' => $storeComment->id,
                            'post_id' => $id,
                        ]);

                        return response("New comment created")
                            ->header('Content-Type', 'text/plain')
                            ->setStatusCode(200, 'New comment created');

                    } else {
                        $error = $this->validError(422, "body");
                        return response($error)
                            ->header('Content-Type', 'text/plain')
                            ->setStatusCode(422, $error["message"]);

                    }
                } else {
                    $error = $this->error(401);

                    return response($error)
                        ->header('Content-Type', 'text/plain')
                        ->setStatusCode(401, $error["message"]);

                }

            } else {

                $error = $this->error(401);

                return response($error)
                    ->header('Content-Type', 'text/plain')
                    ->setStatusCode(401, $error["message"]);
            }
        } else {
            $error = $this->error(404);

            return response($error)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(404, $error["message"]);
        }


    }

    public function storeComments($data)
    {
        return $post = Comment::create($data);
    }

    public function destroy($post_id, $comment_id)
    {

        $comment = Comment::where('id', $comment_id)->first();
        $post = Post::where('id', $post_id)->first();

        if ($comment != null && $post != null) {

            Comment::where('id', $comment_id)->get();

            Comment::find($comment_id)->post()->detach();

            Comment::where('id', $comment_id)->delete();

            return response("Delete a existing post")
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(200, 'Delete a existing post');

        } else {

            $error = $this->error(404);

            return response($error)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(404, $error["message"]);
        }

    }

    public function validError($code, $input)
    {

        $error = array(
            "code" => $code,
            "message" => "Validation error",
            "fields" => array(
                "title" => "The " . $input . " is required"
            )
        );

    }


    public function error($code)
    {

        $errorMSG = BasicError::where('code', $code)->get();

        $error = array();
        foreach ($errorMSG as $errors) {
            $error = array(
                "code" => $errors->code,
                "message" => $errors->message,
            );
        }

        return $error;
    }

}
