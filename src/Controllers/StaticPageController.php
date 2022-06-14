<?php

namespace App\Controllers;

use App\Model\Page;
use App\View\View;

class StaticPageController extends AbstractController
{
    public function about()
    {
        return new View('about', [
            'title' => 'Страница о нас', 
            'user' => $this->user, 
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }

    /**
     * отображает статичную страницу по её id
     */
    public function pageById($idPage)
    {
        $page = Page::find($idPage);

        return new View('static', [
            'title' => $page->title,
            'text' => $page->text,
            'user' => $this->user,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }

    /**
     * отображает статичную страницу по slug
     */
    public function pageBySlug($slug)
    {
        $page = Page::where('slug', $slug)->get(['id', 'title', 'text', 'slug'])->first();

        return new View('static', [
            'title' => $page->title,
            'text' => $page->text,
            'user' => $this->user,
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }

    public function unsubscribe()
    {
        return new View('unsubscribe', [
            'title' => 'Страница отписки от расылки', 
            'user' => $this->user, 
            'listStaticPages' => Page::select('id', 'title', 'slug')->get()->toArray(),
        ]);
    }
}
