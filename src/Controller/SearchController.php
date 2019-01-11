<?php

namespace Skeleton\Controller;

use Cake\ElasticSearch\QueryBuilder;
use Cake\Event\Event;
use Cake\Http\Exception\BadRequestException;
use Cake\Utility\Inflector;

/**
 * Search Controller
 *
 * @property \Skeleton\Model\Index\ActivitiesIndex $Activities
 * @property \Skeleton\Model\Index\ActivitiesIndex $Events
 * @property \Skeleton\Model\Index\ActivitiesIndex $Tags
 * @property \Skeleton\Model\Index\ActivitiesIndex $Users
 * @property \Skeleton\Model\Table\SearchHistoriesTable $SearchHistories
 *
 */
class SearchController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->loadModel('Activities', 'Elastic');
//        $this->loadModel('Events', 'Elastic');
        $this->loadModel('Tags', 'Elastic');
        $this->loadModel('Users', 'Elastic');
        $this->loadModel('SearchHistories');
    }

    public function index($type = null)
    {
        $this->load($this->Activities->find());
    }

    public function search($type = null, $search_string = '')
    {
        if (!in_array($type, ['activities', 'events', 'location', 'tags', 'users'])) {
            throw new BadRequestException("Unrecognized type: $type");
        }

        if (empty($search_string)) {
            throw new BadRequestException("Search string can't be empty.");
        }

        // record this search
        $this->SearchHistories->query()->insert(['user_id', 'type', 'query'], ['integer', 'string', 'string'])
            ->values([
                'user_id' => $this->currentUser->id,
                'type' => Inflector::singularize($type),
                'query' => $search_string
            ])
            ->epilog("ON DUPLICATE KEY UPDATE searched_at = '" . timestamp() . "'")
            ->execute();

        // retrieve search results
        switch ($type) {
            case 'activities':
                $fields = ['title', 'details'];
                break;
            case 'tags':
                $fields = ['name'];
                break;
            case 'users':
                $fields = ['name'];
                break;
            default:
                throw new BadRequestException("Unrecognized type: $type");
        }

        $query = $this->{ucfirst($type)}->find()->where(function (QueryBuilder $builder) use ($fields, $search_string) {
            $expressions = [];
            foreach ($fields as $field => $regexp) {
                if (is_int($field)) {
                    $field = $regexp;
                    $regexp = ".*$search_string.*";
                }
                $expressions[] = $builder->regexp($field, $regexp);
            }
            return $builder->or_($expressions);
        });

        $this->load($query);
    }

    public function delete($id = null)
    {
        $this->Activities->deleteAll([]);
    }
}
