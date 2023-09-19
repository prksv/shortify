<?php

namespace Core\Shortify;

require_once __DIR__ . '/../../database.php';

use Core\Repositories\LinkRepository;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

class Shortify
{
    public string $url;
    private string $hostname;
    private string $prefix;
    private LinkRepository $linkRepository;

    public function __construct()
    {
        $this->hostname = config['hostname'];
        $this->prefix = config['prefix'];
        $this->linkRepository = new LinkRepository();
    }

    private function generateUrl(string $uuid): string
    {
        return "{$this->hostname}/{$this->prefix}/{$uuid}";
    }

    public function createLink(string $url, OODBBean|null $user): OODBBean
    {
        $link = $this->linkRepository->create($url, $user?->id);

        $this->url = $this->generateUrl($link->uuid);

        return $link;
    }

    public function getLinks(int $user_id = null): array|OODBBean
    {
        return array_values($this->linkRepository->getLinks($user_id));
    }

    public function findLink(string $uuid): ?OODBBean
    {
        $link = $this->linkRepository->findByUuid($uuid);

        if (!$link) {
            return null;
        }

        $this->url = $this->generateUrl($uuid);

        return $link;
    }

    public function increaseViews(OODBBean $link, int $amount = 1): ?OODBBean
    {
        return $this->linkRepository->increaseViews($link, $amount);
    }
}