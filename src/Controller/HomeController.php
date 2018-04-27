<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;


    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/", name="home", methods="GET")
     */
    public function index(Request $request) : Response
    {
        $page = $request->query->get('page', 1);
        $perPage = 5;
        $posts = $this->postRepository->getAllForPage($page, $perPage);
        $total = count($this->postRepository->findAll());
        $pages = ceil($total/$perPage);

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods="GET")
     */
    public function show(Post $post): Response
    {
        return $this->render('home/show.html.twig', ['post' => $post]);
    }
}
