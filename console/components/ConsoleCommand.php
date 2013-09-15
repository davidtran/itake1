<?php

    class ConsoleCommand extends CConsoleCommand
    {

        public function run($args)
        {
            date_default_timezone_set('Asia/Jakarta');
            if (count($args) == 0)
            {
                $this->outputHelp();
            }
            else
            {
                $method = $args[0];
                if (method_exists($this, $method))
                {
                    $methodArgs = array_slice($args, 1);
                    Yii::log("Run console method: $method ");
                    try{
                        call_user_func_array(array($this,$method),$methodArgs);
                        echo 'OK';
                    }
                    catch(Exception $e){
                        echo $e->getMessage();
                        echo 'FAILED';
                        Yii::log("Failed console method: $method at ".date('Y-m-d H:i:s'));
                    }
                    
                    //$this->$method($methodArgs);
                }
                else
                {
                    $this->outputMethodIsNotExist();
                }
            }
        }

        protected function outputMethodIsNotExist()
        {
            $output = 'This command is not exist' . PHP_EOL;
            $output.=$this->outputHelp();
            echo $output;
        }

        protected function outputHelp()
        {
            return '';
        }

    }
