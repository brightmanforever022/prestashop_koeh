<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Listens for Exceptions thrown from within the Transport system.
 *
 * @author     Chris Corbyn
 */
interface NewsletterPro_Swift_Events_TransportExceptionListener extends NewsletterPro_Swift_Events_EventListener
{
    /**
     * Invoked as a TransportException is thrown in the Transport system.
     *
     * @param NewsletterPro_Swift_Events_TransportExceptionEvent $evt
     */
    public function exceptionThrown(NewsletterPro_Swift_Events_TransportExceptionEvent $evt);
}
