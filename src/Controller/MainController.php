<?php

namespace App\Controller;

use App\Entity\UrlMapper;
use App\Form\Type\UrlMapperType;
use App\Service\URLManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @param Request $request
     * @param URLManager $urlManager
     * @return Response
     * @throws \Exception
     */
    public function indexAction(Request $request, URLManager $urlManager)
    {
        $urlMapper = new UrlMapper();

        $form = $this->createForm(UrlMapperType::class, $urlMapper);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $urlMapper->setDateAdded(new \DateTime('now'));
            $urlMapper->setDateAdded(new \DateTime('next month')); //todo add to config
            $urlMapper->setShortenedUrl($urlManager->shorten($urlMapper->getInputUrl()));

            $em->persist($urlMapper);
            $em->flush();

        }

        return $this->render('index.html.twig', [
            'urlForm' => $form->createView()
        ]);
    }
}
