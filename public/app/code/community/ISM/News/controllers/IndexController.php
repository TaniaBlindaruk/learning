<?php

class ISM_News_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $news = Mage::getModel('news/news')->getCollection();
        $viewUrl = Mage::getUrl('news/index/view');

        echo '<h1>News</h1>';
        foreach ($news as $item) {
            echo '<h2><a href="' . $viewUrl . '?id=' . $item->getId() . '">' . $item->getTitle() . '</a></h2>';
        }
    }

    public function viewAction()
    {
        $newsId = Mage::app()->getRequest()->getParam('id', 0);
        $news = Mage::getModel('news/news')->load($newsId);

        if ($news->getId() > 0) {
            echo '<h1>' . $news->getTitle() . '</h1>';
            echo '<div class="content">' . $news->getContent() . '</div>';
        } else {
            $this->_forward('noRoute');
        }
    }

}