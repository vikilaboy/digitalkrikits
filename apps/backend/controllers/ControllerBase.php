<?php

namespace DigitalKrikits\Backend\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\View;
use \Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    /**
     * Executes after instance
     */
    public function initialize()
    {
        $this->loadDefaultAssets();

        if ($this->request->isAjax()) {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }
        $this->view->setTemplateBefore('layout');

        Tag::setTitle('DigitalKrikits | ' . ucwords($this->router->getControllerName()));
    }

    /**
     * loadDefaultAssets method.
     *
     * @access private
     * @return void
     */
    private function loadDefaultAssets()
    {
        $this->assets
            ->addCss('//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', false)
            ->addCss('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', false)
            ->addCss('../css/realia-blue.css')
            ->addCss('../css/jumbotron-narrow.css')
            ->addCss('../css/custom.css');
        ;

        $this->assets
            ->addJs('//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false)
            ->addJs('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js', false)
            ->addJs('//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js', false);
    }

    /**
     * Method to delete objects
     *
     * @return mixed
     */
    protected function delete($id, $model = null)
    {
        $this->view->disable();

        if (empty($model)) {
            $class = PROJECT_BASE_NAMESPACE . '\Models\\' . ucfirst($this->router->getControllerName());
        } else {
            $class = PROJECT_BASE_NAMESPACE . '\Models\\' . ucfirst($model);
        }

        if (!class_exists($class)) {
            return false;
        }

        if (is_array($id)) {
            $ids = array_map(
                function ($key) {
                    return (int)$key;
                },
                $id
            );
            $object = $class::find('id IN (' . implode(',', $ids) . ')');
        } else {
            $id = $this->filter->sanitize($id, ['int']);
            $object = $class::findFirstById($id);
        }
        if (!$object) {
            $this->flashSession->error('Entry was not found');

            return $this->response->redirect($this->request->getHTTPReferer(), true);
        }

        if (!$object->delete()) {
            $this->displayModelErrors($object);
        } else {
            $this->flashSession->success('Entry was successfully deleted');
        }

        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    public function deleteAction($id)
    {
        $this->view->disable();

        return $this->delete($id);
    }

    public function show404Action()
    {
        return $this->view->pick('partials/show404');
    }
}