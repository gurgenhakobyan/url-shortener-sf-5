<?php

namespace App\Controller;

use App\Service\URLManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RESTController extends AbstractController
{
    /**
     * @Route("/encode", name="encode", methods={"POST"})
     * @param Request $request
     * @param URLManager $urlManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function encode(Request $request, URLManager $urlManager)
    {
        $url = $this->getValidatedUrl($request);

        if (!$url)  return $this->urlInvalidResponse();

        else {
            $shortenedURL = $urlManager->encode($url);
            return $this->urlProcessedSuccessResponse($shortenedURL);
        }
    }

    /**
     * @Route("/decode", name="decode", methods={"POST"})
     * @param Request $request
     * @param URLManager $urlManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function decode(Request $request, URLManager $urlManager)
    {
        $url = $this->getValidatedUrl($request);

        if (!$url)  return $this->urlInvalidResponse();

        else {
            $decodedUrl = $urlManager->decode($url);

            if (!$decodedUrl) return $this->urlNotFoundResponse();

            return $this->urlProcessedSuccessResponse($decodedUrl);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function getValidatedUrl($request){
        $url = $request->request->get('url');

        return ($url != null && $url != '' && filter_var($url, FILTER_VALIDATE_URL) !== false) ? $url : false;

    }

    /**
     * @return JsonResponse
     */
    private function urlInvalidResponse(){
        return new JsonResponse(['success' => false, 'message' => 'Please enter a valid!' ], 400);
    }

    /**
     * @return JsonResponse
     */
    private function urlNotFoundResponse(){
        return new JsonResponse(['success' => false, 'message' => 'Requested URL is not found!' ], 404);
    }

    /**
     * @param string $processedUrl
     * @return JsonResponse
     */
    private function urlProcessedSuccessResponse($processedUrl){
        return new JsonResponse(['success' => true, 'message' => $processedUrl ], 200);
    }
}
