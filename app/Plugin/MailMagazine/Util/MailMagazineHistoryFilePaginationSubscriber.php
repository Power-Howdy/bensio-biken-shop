<?php

namespace Plugin\MailMagazine\Util;

use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailMagazineHistoryFilePaginationSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event)
    {
        $event->stopPropagation();
        $file = $event->target;
        if (!file_exists($file)) {
            $event->count = 0;
            $event->items = array();

            return;
        }

        $event->count = $event->options['total'];

        $skip = $event->getOffset();
        $fp = fopen($file, 'r');
        $count = $event->getLimit();

        $event->items = array();
        while ($line = fgets($fp)) {
            if ($skip-- > 0) {
                continue;
            }
            if ($count == 0) {
                break;
            }
            list($status, $customerId, $email, $name) = explode(',', str_replace(PHP_EOL, '', $line), 4);
            $event->items[] = array(
                'status' => $status,
                'customerId' => $customerId,
                'email' => $email,
                'name' => $name,
            );
            --$count;
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'knp_pager.items' => array('items', 1),
        );
    }
}
