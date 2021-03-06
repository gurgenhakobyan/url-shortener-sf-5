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
        $em = $this->getDoctrine()->getManager();

        $existingUrlList = $em->getRepository(UrlMapper::class)->findAll();
        $urlMapper = new UrlMapper();

        $form = $this->createForm(UrlMapperType::class, $urlMapper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $currentDate = new \DateTime('now');
            $expirationDate = clone $currentDate;
            $expirationDate->add(new \DateInterval($this->getParameter('expiration_time')));

            $urlMapper->setDateAdded($currentDate);
            $urlMapper->setDateExpiration($expirationDate);
            $urlMapper->setShortenedUrl($urlManager->shorten());

            $em->persist($urlMapper);
            $em->flush();

        }

        return $this->render('index.html.twig', [
            'urlForm' => $form->createView(),
            'shortUrlList' => $existingUrlList,
            'shortUrlPrefix' => $this->getParameter('short_url')
        ]);
    }
}
