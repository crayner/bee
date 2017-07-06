<?php

namespace Busybee\SecurityBundle\Security;

use Busybee\SecurityBundle\Entity\Page;

trait DenyAccessUnlessGranted
{
    /**
     * Throws an exception unless the attributes are granted against the current authentication token and optionally
     * supplied object.
     *
     * @param mixed  $attributes The attributes
     * @param mixed  $object     The object
     * @param string $message    The message passed to the exception
     *
     * @throws AccessDeniedException
     */
    public function denyAccessUnlessGranted($attributes, $object = null, $message = null)
    {
        $message = is_null($message) ? $this->get('translator')->trans('security.access.denied', array(), 'BusybeeSecurityBundle') : $message;

        $request = $this->get('request_stack')->getCurrentRequest();
        $routeName = $request->get('_route');

        $page = $this->get('page.manager')->findOneByRoute($routeName, $attributes);

        $attributes = [];
        foreach ($page->getRoles() as $role)
            $attributes[] = $role;

        parent::denyAccessUnlessGranted($attributes, $object, $message);
    }
}
