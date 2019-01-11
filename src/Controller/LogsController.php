<?php

namespace Skeleton\Controller;

/**
 * Logs Controller
 *
 * @property \Skeleton\Model\Table\LogsTable $Logs
 *
 * @method \Skeleton\Model\Entity\Log[]
 */
class LogsController extends AppController
{
    public function index()
    {
        $this->load(['contain' => ['Users', 'HttpStatusCodes']]);
    }
}
