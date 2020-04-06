<?php

class Page extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        $data = ['title' => 'SharePosts'];
        $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = ['description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'];
        $this->view('pages/about', $data);
    }

}