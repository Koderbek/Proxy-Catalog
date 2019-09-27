<?php

namespace App\Controller;

use App\Entity\Proxy;
use App\Form\ImportCsvType;
use App\Form\ProxyType;
use App\Service\ImportService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proxy")
 */
class ProxyController extends AbstractController
{
    /** @var ImportService $importService */
    protected $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * @Route("/", name="proxy_index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_EDITOR')")
     */
    public function index(): Response
    {
        $proxies = $this->getDoctrine()
            ->getRepository(Proxy::class)
            ->findAll();

        return $this->render('proxy/index.html.twig', [
            'proxies' => $proxies,
        ]);
    }

    /**
     * @Route("/new", name="proxy_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_EDITOR')")
     */
    public function new(Request $request): Response
    {
        $proxy = new Proxy();
        $form = $this->createForm(ProxyType::class, $proxy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proxy);
            $entityManager->flush();

            return $this->redirectToRoute('proxy_index');
        }

        return $this->render('proxy/new.html.twig', [
            'proxy' => $proxy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proxy_show", methods={"GET"}, requirements={"id": "\d+"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function show(Proxy $proxy): Response
    {
        return $this->render('proxy/show.html.twig', [
            'proxy' => $proxy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="proxy_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Proxy $proxy): Response
    {
        $form = $this->createForm(ProxyType::class, $proxy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proxy_index');
        }

        return $this->render('proxy/edit.html.twig', [
            'proxy' => $proxy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proxy_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Proxy $proxy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proxy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($proxy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('proxy_index');
    }

    /**
     * @Route("/import", name="proxy_import", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_EDITOR')")
     */
    public function import(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImportCsvType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->getData();
            $this->importService->parseCSV($file['file']);

            return $this->redirectToRoute('proxy_index');
        }

        return $this->render('proxy/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
