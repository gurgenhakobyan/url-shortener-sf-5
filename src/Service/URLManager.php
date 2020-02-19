<?php 

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class URLManager
{
    private $params;
    private $cache;
    private $cachePrefix;
    private $shortUrlLength;
    private $shortUrlRoot;

    /**
     * URLManager constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->cache = new FilesystemAdapter();
        $this->cachePrefix = $this->params->get('cache_memory_prefix');
        $this->shortUrlLength = (int) $this->params->get('short_url_length');
        $this->shortUrlRoot = $this->params->get('short_url_root');
    }

    /**
     *
     * @param string $url
     * @return string
     */
    public function encode($url)
    {
        do {
            $randomString = $this->generateRandomString($this->shortUrlLength);
        } while($this->cache->getItem($this->cachePrefix.$randomString)->get() != null);

        $encodedUrl = $this->cache->getItem($this->cachePrefix.$randomString);
        $encodedUrl->set($url);
        $this->cache->save($encodedUrl);

        return $this->shortUrlRoot . '/' . $randomString;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function decode($url)
    {
        $urlPrefix = substr( $url, 0, strlen($this->shortUrlRoot) );

        //cutting url first part to see if it is the same as our short url
        if ($urlPrefix == $this->shortUrlRoot && strlen($url) == (strlen($this->shortUrlRoot) + 1 + $this->shortUrlLength)) {
            $requestedString = substr($url, strlen($this->shortUrlRoot) + 1, $this->shortUrlLength);
            $originalUrl = $this->cache->getItem($this->cachePrefix . $requestedString)->get();

            if ($originalUrl != null) {
                return $originalUrl;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        while (strlen($randomString) < $length) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}