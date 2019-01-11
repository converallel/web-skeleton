<?php

namespace Skeleton\Controller;

/**
 * SearchHistories Controller
 *
 * @property \Skeleton\Model\Table\SearchHistoriesTable $SearchHistories
 *
 * @method \Skeleton\Model\Entity\SearchHistory[]
 */
class SearchHistoriesController extends AppController
{

    public function index()
    {
        $query = $this->SearchHistories->find()->orderDesc('searched_at')->limit(5);
        $this->load($query);
    }
}
