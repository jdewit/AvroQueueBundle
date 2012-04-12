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
     * Advance the queue.
     *
     * @Route("/next", name="avro_queue_queue_next")
     */
    public function nextAction()
    {
        $session = $this->container->get('session');
        $queue = $session->get('queue');
        $id = array_shift($queue['ids']);
        $session->set('queue', array('route' => $queue['route'], 'ids' => $queue['ids']));
        $response = new RedirectResponse($this->container->get('router')->generate($queue['route'], array('id' => $id)));

        return $response;
    }

    /**
     * Cancel the queue.
     *
     * @Route("/cancel", name="avro_queue_queue_cancel")
     */
    public function cancelAction()
    {
        $this->container->get('session')->remove('queue');

        if ($this->container->get('request')->headers->get('referer') && $this->container->getParameter('avro_queue.use_referer')) {
            $response = new RedirectResponse($this->container->get('request')->headers->get('referer'));
        } else {
            $response = new RedirectResponse($this->container->get('router')->generate($this->container->getParameter('avro_queue.fallback_route')));
        }

        return $response;
    }
}

