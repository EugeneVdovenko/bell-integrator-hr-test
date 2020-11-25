<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookTranslation;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class BookController extends AbstractController
{
    /**
     * @Route("/book/", name="book_index", methods={"GET"})
     *
     * @param Request $request
     * @param BookRepository $bookRepository
     *
     * @return JsonResponse
     */
    public function index(Request $request, BookRepository $bookRepository): JsonResponse
    {
        $limit = $request->get('limit', null);

        return $this->response($bookRepository->findBy([], null, $limit));
    }

    /**
     * @Route("/book/create", name="book_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        $data = (new JsonEncoder)->decode($request->getContent(), JsonEncoder::FORMAT);

        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        $form->submit($data);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->response($book);
        }

        return $this->response([], 422, 'Data wrong');
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

    /**
     * @Route("/book/search", name="book_search", methods={"GET"})
     *
     * @param Request $request
     * @param BookRepository $bookRepository
     *
     * @return JsonResponse
     */
    public function search(Request $request, BookRepository $bookRepository): JsonResponse
    {
        $qb = $bookRepository->createQueryBuilder('t');

        $filter = $request->get('filter', []);

        if ($title = $filter['title'] ?? null) {
            $title = mb_strtolower($title);

            $qb
                ->leftJoin(BookTranslation::class, 'bt', Join::WITH, 't.id = bt.translatable_id')
                ->andWhere($qb->expr()->like('lower(bt.name)', ':title'))
                ->setParameter('title', "%{$title}%")
            ;
        }

        return $this->response($qb->getQuery()->getResult());
    }

    /**
     * @Route("/{_locale}/book/{id}",
     *     requirements={
     *         "_locale": "en|ru",
     *     }, name="book_get", methods={"GET"})
     *
     * @param Book $book
     *
     * @return JsonResponse
     */
    public function show(Book $book): JsonResponse
    {
        return $this->response($book);
    }
}
