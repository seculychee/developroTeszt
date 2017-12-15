<?php

namespace App\Http\Controllers;

use App\BasicError;
use App\Comment;
use App\CommentPost;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::paginate(2);
        $data = array();

            foreach ($posts as $post) {
                $comment = $this->postComment($post->id);
                $arrayPush = array_push($data, array(
                        "data" => array(
                            "id" => $post->id,
                            "slug" => $post->slug,
                            "author" => array(
                                "id" => $post->user->id,
                                "name" => $post->user->name,
                                "email" => $post->user->email,
                            ),
                            "title" => $post->title,
                            "body" => $post->body,
                            "created_at" => (string)$post->created_at,
                            "comments" => $comment,
                            "updated_at" => (string)$post->updated_at
                        ),
                    )
                );
            }

            $jsondata = json_decode($posts->toJson());
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

    public function create(Request $request)
    {
        $error = array();
        $data = json_decode($request->getContent(), true);

        if (isset($data["author"]["id"]) && (int)$data["author"]["id"] != null) {

            $user = User::where('id', $data["author"]["id"])->first();
            if ($user == null) {
                $error = $this->validError(401, "body");

                return response($error)
                    ->header('Content-Type', 'text/plain')
                    ->setStatusCode(401, $error["message"]);

            }
            $commentID = 0;
            foreach ($data["comments"] as $comments) {

                $comment = Comment::where('id', $comments["id"])->first();

                $post = Post::where('id', $data["id"])->first();
                if ($post == null) {


                    if (!$data["title"] == 0 &&
                        !$data["title"] == "" &&
                        !$data["title"] == null
                    ) {
                        if (!$data["body"] == 0 &&
                            !$data["body"] == "" &&
                            !$data["body"] == null
                        ) {

                            $storePost = array(
                                "id" => (int)$data["id"],
                                "slug" => (string)$data["slug"],
                                "author" => (int)$data["author"]["id"],
                                "title" => (string)$data["title"],
                                "body" => (string)$data["body"],
                                "comments" => $commentID
                            );

                            if ($comment == null) {

                                if (!$comments["body"] == 0 &&
                                    !$comments["body"] == "" &&
                                    !$comments["body"] == null
                                ) {
                                    $commentID = $comments["id"];
                                    $storeComments = array(
                                        "id" => (int)$comments["id"],
                                        "author" => (int)$comments["author"]["id"],
                                        "body" => (string)$comments["body"]
                                    );
                                    $storeComment = $this->storeComments($storeComments);
                                } else {
                                    $error = $this->validError(422, "body");

                                    return response($error)
                                        ->header('Content-Type', 'text/plain')
                                        ->setStatusCode(422, $error["message"]);
                                }
                            } else {
                                $error = $this->validError(422, "body");

                                return response($error)
                                    ->header('Content-Type', 'text/plain')
                                    ->setStatusCode(422, $error["message"]);
                            }
                        } else {
                            return response("Unknow error")
                                ->header('Content-Type', 'text/plain')
                                ->setStatusCode(555, 'Unknow error');
                        }
                    } else {
                        $error = $this->validError(422, "title");

                        return response($error)
                            ->header('Content-Type', 'text/plain')
                            ->setStatusCode(422, $error["message"]);

                    }
                    $store = $this->storePost($storePost);
                    $post = Post::find($store->id);
                    $post->comment()->attach($commentID);

                    return response("ok")
                        ->header('Content-Type', 'text/plain')
                        ->setStatusCode(200, 'New post created');

                } else {
                    return response("Unknow error")
                        ->header('Content-Type', 'text/plain')
                        ->setStatusCode(555, 'Unknow error');
                }
            }
            return response("ok")
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(200, 'New post created');

        } else {
            $error = $this->error(401);

            return response($error)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(401, $error["message"]);
        }


    }

    public function show($id)
    {
        $error = array();
        $postValid = Post::where('id', $id)->first();

        if ($postValid != null) {
            $posts = Post::where('id', $id)->get();

            $data = array();
            foreach ($posts as $post) {

                $comment = $this->postComment($post->id);

                $arrayPush = array_push($data, array(
                        "data" => array(
                            "id" => $post->id,
                            "slug" => $post->slug,
                            "author" => array(
                                "id" => $post->user->id,
                                "name" => $post->user->name,
                                "email" => $post->user->email,
                            ),
                            "title" => $post->title,
                            "body" => $post->body,
                            "created_at" => (string)$post->created_at,
                            "comments" => $comment,
                            "updated_at" => (string)$post->updated_at
                        )
                    )
                );
            }

            return response($data)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(200, 'The posts');

        } else {

            $error = $this->error(404);

            return response($error)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(404, $error["message"]);
        }
    }

    public function edit(Request $request, $id)
    {

        $data = json_decode($request->getContent(), true);
        $postValid = Post::where('id', $id)->first();
        $error = array();

        if ($postValid != null) {


            if (isset($data["author"]["id"]) && (int)$data["author"]["id"] != null) {

                $user = User::where('id', $data["author"]["id"])->first();
                if ($user == null) {

                    $error = $this->error(401);

                    return response($error)
                        ->header('Content-Type', 'text/plain')
                        ->setStatusCode(401, $error["message"]);
                }

                $commentID = 0;
                foreach ($data["comments"] as $comments) {


                    $commentID = $comments["id"];
                    if (!$comments["body"] == 0 &&
                        !$comments["body"] == "" &&
                        !$comments["body"] == null
                    ) {
                        $storeComments = array(
                            "id" => (int)$comments["id"],
                            "author" => (int)$comments["author"]["id"],
                            "body" => (string)$comments["body"]
                        );
                        $comment = Comment::where('id', $comments["id"])->first();
                        if ($comment == null) {
                            $storeComment = $this->storeComments($storeComments);

                            CommentPost::create([
                                'post_id' => $id,
                                'comment_id' => $commentID,
                            ]);

                        } else {
                            Comment::where('id', $commentID)->update($storeComments);
                        }

                    } else {
                        $error = $this->validError(422, "body");
                        return response($error)
                            ->header('Content-Type', 'text/plain')
                            ->setStatusCode(422, $error["message"]);
                    }
                }

                if (!$data["title"] == 0 &&
                    !$data["title"] == "" &&
                    !$data["title"] == null
                ) {
                    if (!$data["body"] == 0 &&
                        !$data["body"] == "" &&
                        !$data["body"] == null
                    ) {
                        $storePost = array(
                            "id" => (int)$data["id"],
                            "slug" => (string)$data["slug"],
                            "author" => (int)$data["author"]["id"],
                            "title" => (string)$data["title"],
                            "body" => (string)$data["body"],
                            "comments" => $commentID
                        );
                        $postUpdate = Post::where('id', $id)->update($storePost);

                    } else {

                        $error = $this->validError(422, "body");
                        return response($error)
                            ->header('Content-Type', 'text/plain')
                            ->setStatusCode(422, $error["message"]);

                    }

                    return response("Existing post updated")
                        ->header('Content-Type', 'text/plain')
                        ->setStatusCode(200, 'Existing post updated');
                } else {

                    $error = $this->validError(422, "title");
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
            $error = $this->error(404);

            return response($error)
                ->header('Content-Type', 'text/plain')
                ->setStatusCode(404, $error["message"]);
        }


    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->get();
        $postComments = Post::find($id)->comment()->get();
        foreach ($postComments as $postComment) {
            $commentDelete = Comment::where('id', $postComment->id)->delete();
        }
        $commentPagi = Post::find($id)->comment()->detach();
        Post::where('id', $id)->delete();

        return response("Delete a existing post")
            ->header('Content-Type', 'text/plain')
            ->setStatusCode(200, 'Delete a existing post');
    }

    public function storePost($data)

    {
        return $post = Post::create($data);
    }

    public function storeComments($data)

    {
        return $post = Comment::create($data);
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

    public function validError($code, $input)
    {
        $error = array(
            "code" => $code,
            "message" => "Validation error",
            "fields" => array(
                "title" => "The " . $input . " is required"
            )
        );
        return $error;
    }


}
