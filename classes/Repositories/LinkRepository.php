<?php

namespace Core\Repositories;

use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class LinkRepository
{
    public function findByUuid(string $uuid): OODBBean|null
    {
        return R::findOne('links', 'uuid = ?', [$uuid]);
    }

    public function create(string $url, int $user_id = null, int $views = 0): OODBBean|null
    {
        $link = R::dispense('links');

        $link->url = $url;
        $link->user_id = $user_id;
        $link->views = $views;
        $link->uuid = uniqid();

        try {
            R::store($link);
        } catch (\Throwable $e) {
            return null;
        }

        return $link;
    }

    public function increaseViews(OODBBean $link, int $amount): ?OODBBean
    {
        $link->views += $amount;

        try {
            R::store($link);
        } catch (\Throwable $e) {
            return null;
        }

        return $link;
    }

    public function getLinks(int $user_id = null): array|OODBBean
    {
        return R::findAll('links', 'where user_id = ? ORDER BY id DESC', [$user_id]);
    }
}