<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="author_index", methods={"GET"})
     */
    public function index(AuthorRepository $authorRepository): JsonResponse
    {
        return $this->response($authorRepository->findAll());
    }

    /**
     * @Route("/create", name="author_new", methods={"POST"})
     *
     * @param Request $request
     * @param AuthorRepository $authorRepository
     *
     * @return JsonResponse
     */
    public function new(Request $request, AuthorRepository $authorRepository): JsonResponse
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        $form->submit((new JsonEncoder())->decode($request->getContent(), JsonEncoder::FORMAT));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->response($author);
        }

        return $this->response([], 422, 'Data invalid');
    }

    protected function response($data, $status = 200, $message = 'OK'): JsonResponse
    {
        $response = [
            'data' => $data,
            'meta' => [
                'status' => $status,
            ],
        ];

        if ($status === 200) {
            $response['meta']['sucess'] = $message;
        } else {
            $response['meta']['errors'] = $message;
        }

        return $this->json($response);
    }
}
