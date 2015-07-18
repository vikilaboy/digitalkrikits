<?php

namespace DigitalKrikits\Backend\Controllers;

use DigitalKrikits\Backend\Forms\VenueForm;
use DigitalKrikits\Models\Venue;
use DigitalKrikits\Models\VenueType;
use \Phalcon\Mvc\Controller;
use \Phalcon\Mvc\View;
use \Phalcon\Paginator\Adapter\Model;
use \Phalcon\Tag;
use \Phalcon\Mvc\Model\Criteria;
use \Phalcon\Utils\Slug;
use Phalcon\Image\Adapter\Imagick;

class VenueController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->setVars(
            [
                'items' => Venue::find(),
                'grid'  => [
                    'id'    => [
                        'title' => 'Id',
                        'order' => true
                    ],
                    'type'  => [
                        'title'  => 'Type',
                        'order'  => true,
                        'filter' => [
                            'type'     => 'select',
                            'sanitize' => 'int',
                            'values'   => VenueType::find(),
                            'using'    => ['id', 'name'],
                            'style'    => 'width: 100px;'
                        ]
                    ],
                    'name'  => [
                        'title'  => 'Name',
                        'order'  => true
                    ],
                    'address'  => [
                        'title'  => 'Address',
                        'order'  => true
                    ],
                    'dateAdd' => [
                        'title'  => 'Date add',
                        'order'  => true
                    ]
                ]
            ]);

    }

    /**
     * Method editAction
     */
    public function editAction($id)
    {
        if (!$object = Venue::findFirstById($id)) {
            $this->flashSession->error('Venue doesn\'t exist.');

            return $this->response->redirect($this->router->getControllerName());
        }

        $this->view->form = new VenueForm($object);
        $this->view->object     = $object;
        return $this->view->pick($this->router->getControllerName() . '/item');
    }

    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function saveAction()
    {
        //  Is not $_POST
        if (!$this->request->isPost()) {
            $this->view->disable();

            return $this->response->redirect($this->router->getControllerName());
        }

        $id = $this->request->getPost('id', 'int', null);

        if (!empty($id)) {
            $object = Venue::findFirstById($id);
        } else {
            $object = new Venue();
        }

        $form = new VenueForm($object);
        $form->bind($_POST, $object, ['id', 'csrf', 'name', 'address', 'idVenueType']);

        //  Form isn't valid
        if (!$form->isValid($this->request->getPost())) {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message->getMessage());
            }

            // Redirect to edit form if we have an ID in page, otherwise redirect to add a new item page
            return $this->response->redirect(
                $this->router->getControllerName() . (!is_null($id) ? '/edit/' . $id : '/new')
            );
        } else {
            if (!$object->save()) {
                foreach ($object->getMessages() as $message) {
                    $this->flashSession->error($message->getMessage());
                }

                return $this->dispatcher->forward(
                    ['controller' => $this->router->getControllerName(), 'action' => 'new']
                );
            } else {
                $this->flashSession->success('Data was successfully saved');

                return $this->response->redirect($this->router->getControllerName());
            }
        }
    }
    /**
     * Add new Product
     */
    public function newAction()
    {
        $this->view->form = new VenueForm();
        $this->view->pick($this->router->getControllerName() . '/item');
    }
}