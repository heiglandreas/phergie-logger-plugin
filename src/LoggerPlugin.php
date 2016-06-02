<?php
/**
 * Copyright (c) Andreas Heigl<andreas@heigl.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright 2016-2016 Andreas Heigl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     29.05.2016
 * @link      http://github.com/heiglandreas/org.heigl.phergie-log
 */

namespace Org_Heigl\Phergie\LoggerPlugin;

use Phergie\Irc\Event\EventInterface as Event;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Bot\React\PluginInterface;

class LoggerPlugin implements PluginInterface
{
    /** @var LoggerConfiguration */
    protected $config;

    public function __construct(LoggerConfiguration $config)
    {
        $this->config = $config;
    }

    public function getSubscribedEvents()
    {
        return array(
            'irc.received.each' => 'onReceive'
        );
    }

    public function onReceive(Event $event, Queue $queue)
    {
        $message = $this->config->getParser()->parse($event->getMessage());

        if (! isset($message['targets'])) {
            return;
        }
        if (! isset($message['params']['text'])) {
            return;
        }

        foreach($message['targets'] as $receiver) {
            try {
                $this->config->getLoggerForChannel($receiver)->info(
                    $message['nick'] . ': ' . $message['params']['text']
                );
            } catch (\Exception $e){}
        }
    }
}
