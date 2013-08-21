<?php

class FacebookCommand extends ConsoleCommand
{

    public function postQueue()
    {
        FacebookPostQueueUtil::processQueueList();
    }

}