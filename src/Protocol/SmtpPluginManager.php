<?php
/**
 * @see       https://github.com/zendframework/zend-mail for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-mail/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Mail\Protocol;

use Psr\Container\ContainerInterface;

/**
 * Plugin manager implementation for SMTP extensions.
 *
 * Enforces that SMTP extensions retrieved are instances of Smtp. Additionally,
 * it registers a number of default extensions available.
 */
class SmtpPluginManager implements ContainerInterface
{
    /**
     * Default set of plugins
     *
     * @var array
     */
    protected $plugins = [
        Smtp\Auth\Crammd5::class => Smtp\Auth\Crammd5::class,
        'crammd5' => Smtp\Auth\Crammd5::class,

        Smtp\Auth\Login::class => Smtp\Auth\Login::class,
        'login' => Smtp\Auth\Login::class,

        Smtp\Auth\Plain::class => Smtp\Auth\Plain::class,
        'plain' => Smtp\Auth\Plain::class,

        Smtp::class => Smtp::class,
        'smtp' => Smtp::class,
    ];

    /**
     * Do we have the plugin?
     *
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->plugins);
    }

    /**
     * Retrieve the smtp plugin
     *
     * @param string $id
     * @param array $options
     * @return AbstractProtocol
     */
    public function get($id, array $options = null)
    {
        $class = $this->plugins[$id];
        return new $class($options);
    }
}
