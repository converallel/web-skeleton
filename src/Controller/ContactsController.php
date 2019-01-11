<?php

namespace Skeleton\Controller;

/**
 * Contacts Controller
 *
 * @property \Skeleton\Model\Table\ContactsTable $Contacts
 *
 * @method \Skeleton\Model\Entity\Contact[]
 */
class ContactsController extends AppController
{
    public function index()
    {
        $query = $this->Contacts->find();
        $query
            ->select(['type', 'contacts' => $query->func()->JSON_ARRAYAGG(['contact' => 'identifier'])])
            ->where(['user_id' => $this->currentUser->id])
            ->group('type');

        $result = [];
        foreach ($query as $contact) {
            $result[strtolower($contact->type)] = json_decode($contact->contacts, true);
        }
        if ($this->usingApi) {
            return $this->setSerialized($result);
        }
        foreach ($result as $type => $contact)
            $this->set($type, $contact);
    }
}
