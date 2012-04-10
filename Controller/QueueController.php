<?php

namespace Avro\QueueBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Queue controller.
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 * @Route("/queue")
 */
class QueueController extends ContainerAware
{
    /**
     * Cancel the queue.
     *
     * @Route("/queue/cancel", name="avro_queue_queue_cancel")
     */
    public function cancelAction()
    {
        $this->container->get('session')->remove('queue');
        $response = new RedirectResponse($this->container->get('request')->headers->get('referrer'));

        return $response;
    }
}

