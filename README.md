AvroQueueBundle
-----------------
Queue up requests.

This bundle implements a listener that redirects to specific route for as 
long as there are id's in the session.

Usage
-----
Simply add the id's of the entity you want to add to the queue and the 
path you want to redirect to

``` php
//controller.php
    $selected = $request->request->get('selected'); // array of ids
    $session = $request->getSession();
    $session->set('queue', array('path' => 'avro_crm_crew_edit', 'ids' => $selected));

    return new RedirectResponse($this->container->get('router')->generate('avro_crm_crew_edit', array('id' => reset($selected))));
```

Add the queue notice to your view

``` php
//layout.html.twig
    {% if app.session.get('queue') is defined %}
        {% if app.session.get('queue').ids | length > 0 %}
            <div id="queueContainer" class="well pull-right">
                <p>You have {{ app.session.get('queue').ids | length }} item{% if app.session.get('queue').ids | length > 1 %}s{% endif %} in queue.</p>
                <div class="center-align">
                    <a class="btn" href="{{ path('avro_queue_queue_cancel') }}">Cancel<a>
                    <a class="btn btn-primary" href="{{ path('avro_queue_queue_next') }}">Next</a>
                </div>
            </div>
        {% endif %}
    {% endif %}
```

Add routing file
``` php
// app/routing.yml
AvroQueueBundle:
    resource: "@AvroQueueBundle/Resources/config/routing.yml"
```
Configuration
-------------

``` yml
// config.yml
avro_queue:
    fallback_route: avro_demo_test_index #When a user follows the cancel route to remove the queue from the session, 
        # the user will redirected to the previous url. You must specify a fallback route 
        # (probably your homepage) in case there is no refferal url set.
    use_referer: true # only use fallback route if false
```

Installation
------------

Add the `Avro` namespace to your autoloader:

``` php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Avro' => __DIR__.'/../vendor/bundles',
));
```

Enable the bundle in the kernel:

``` php
// app/AppKernel.php

    new Avro\QueueBundle\AvroQueueBundle
```

```
[AvroQueueBundle]
    git=git://github.com/Avro/QueueBundle.git
    target=bundles/Avro/QueueBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

