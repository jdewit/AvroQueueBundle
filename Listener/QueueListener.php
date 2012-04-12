<?php
namespace Avro\QueueBundle\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/*
 * Redirects to a specified route if there are items in the queue session
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class QueueListener
{
    protected $router;

    public function __construct($router) 
    {
        $this->router = $router;
    }

    /**
     * Invoked after the response has been created.
     * 
     * @param FilterResponseEvent $event The event
     */
    public function init(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();
        $queue = $session->get('queue');

        if ($queue) {
            if (count($queue['ids']) > 0) {
                if ($queue['route'] == $request->get('_route')) {
                    if ('POST' === $request->getMethod()) {
                        $id = array_shift($queue['ids']);
                        $session->set('queue', array('route' => $queue['route'], 'ids' => $queue['ids']));
                        $response = new RedirectResponse($this->router->generate($queue['route'], array('id' => $id)));
             
                        $event->setResponse($response);
                    }  
                }
            } 
        }
    }
}
