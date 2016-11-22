<?php

namespace OCA\MailingLists\Service;

interface IListService {
    public function loadAll();
    public function load($name);
    public function removeModerator($name, $moderator);
    public function addModerator($name, $moderator);
}