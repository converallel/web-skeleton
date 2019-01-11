<?php

namespace Skeleton\Controller;

/**
 * Files Controller
 *
 * @property \Skeleton\Model\Table\FilesTable $Files
 *
 * @method \Skeleton\Model\Entity\File[]
 */
class FilesController extends AppController
{

    public function index()
    {
        $query = $this->Files->find()
            ->select(['id,', 'url', 'size', 'notes', 'created_at'])
            ->where(['user_id' => $this->currentUser->id])
            ->orderDesc('created_at');
        $this->load($query);
    }

    public function add()
    {
        $this->addMany();
    }
}
