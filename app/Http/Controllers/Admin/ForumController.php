<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Handlers\Admin\CategoryHandler;
use App\Http\Requests\Handlers\Admin\DiscussionHandler;
use App\Http\Requests\Handlers\Admin\SAASHandler;
use App\Models\Forum\Category;
use App\Models\Forum\Discussion;
use App\Models\Forum\Post;
use App\Models\SAAS\Studio;
use App\Repository\Eloquent\Admin\CategoryRepository;
use App\Repository\Eloquent\Admin\DiscussionRepository;
use App\Repository\Eloquent\Admin\PostRepository;
use App\Repository\Eloquent\Admin\SAASRepository;
use App\Services\Admin\CategoryService;
use App\Services\Admin\DiscussionService;
use App\Services\Admin\SAASService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForumController extends Controller
{
    public function categoriesIndex(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getCategories();

        $this->responseBuilder->setData('categories', $categories);

        return $this->responseBuilder->getResponse();
    }

    public function postsIndex(PostRepository $postRepository)
    {
        $posts = $postRepository->all();

        $this->responseBuilder->setData('posts', $posts);

        return $this->responseBuilder->getResponse();
    }

    public function discussionIndex(DiscussionRepository $discussionRepository)
    {
        $posts = $discussionRepository->all();

        $this->responseBuilder->setData('discussions', $posts);

        return $this->responseBuilder->getResponse();
    }

    public function getTopCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getTopCategories();

        $this->responseBuilder->setData('categories', $categories);

        return $this->responseBuilder->getResponse();
    }

    public function getSubCategoriesByParentID(CategoryRepository $categoryRepository, $id)
    {
        $categories = $categoryRepository->getCategoryChildren($id);

        $this->responseBuilder->setData('subcategories', $categories);

        return $this->responseBuilder->getResponse();
    }

    public function saveCategory(CategoryRepository $categoryRepository, CategoryService $categoryService, Request $request)
    {
        $categoryHandler = new CategoryHandler($request);
        $parameters = $categoryHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if ($request->category_id != null) {
            $check = $categoryRepository->find($request->category_id);
            if ($check == null) {
                $check = new Category();
            }
        } else {
            $check = new Category();
        }

        $saveCategory = $categoryService->saveCategory($parameters, $check);
        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('category',  $saveCategory);

        return $this->responseBuilder->getResponse();
    }

    public function saveDiscussion(DiscussionRepository $discussionRepository, DiscussionService $discussionService, Request $request)
    {
        $discussionHandler = new DiscussionHandler($request);
        $parameters = $discussionHandler->getParameters();

        if (!$parameters->isValid()) {
            $this->responseBuilder->setErrorMessagesFromMB($parameters->getMessageBag());
            return $this->responseBuilder->getResponse(Response::HTTP_BAD_REQUEST);
        }

        if ($request->discussion_id != null) {
            $check = $discussionRepository->find($request->discussion_id);
            if ($check == null) {
                $check = new Discussion();
                $post = new Post();
            } else {
               $post = $check->posts()->orderBy('created_at', 'DESC')->first();
            }
        } else {
            $check = new Discussion();
            $post = new Post();
        }

        $saveCategory = $discussionService->saveDiscussion($parameters, $check, $post);
        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));
        $this->responseBuilder->setData('category',  $saveCategory);

        return $this->responseBuilder->getResponse();
    }

    public function stickUnstick(Request $request)
    {
        foreach ($request->ids as $id) {
            $discussion = Discussion::find($id);
                $discussion->sticky = ($request->action === 'stick')? 1 : 0;
                $discussion->save();
        }

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));

        return $this->responseBuilder->getResponse();
    }

    public function deleteDiscussions(Request $request)
    {
        foreach ($request->ids as $id) {
            $discussion = Discussion::find($id);
            $posts = $discussion->posts()->get();
            foreach ($posts as $post) {
                $post->delete();
            }
            $discussion->delete();
        }

        $this->responseBuilder->setSuccessMessage(__('messages.save_correct'));

        return $this->responseBuilder->getResponse();
    }
}
