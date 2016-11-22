<?php

namespace OCA\MailingLists;

\OCP\Util::addStyle('mailinglists', 'settings');
\OCP\Util::addScript('mailinglists', 'settings');

$tmpl = new \OCP\Template('mailinglists', 'part.admin');

return $tmpl->fetchPage();
