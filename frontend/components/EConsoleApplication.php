<?php

    class EConsoleApplication extends CConsoleApplication
    {

        private $_controller = false;

        public function getController()
        {
            if ($this->_controller === false)
                $this->_controller = new Controller('site');

            return $this->_controller;
        }

        public function getViewRenderer()
        {
            return null;
        }

        public function getViewPath()
        {
            return $this->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }

        public function getTheme()
        {
            return NULL;
        }

    }