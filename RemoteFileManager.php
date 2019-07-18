<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace RemoteFileManager;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Thelia\Module\BaseModule;
use Thelia\Tools\TokenProvider;

class RemoteFileManager extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'remotefilemanager';

    /**
     * @param ConnectionInterface|null $con
     * @throws \Exception
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        // Copy file manager in web space
        $fs = new Filesystem();

        try {
            $fs->mirror(__DIR__ . DS . "fm-dir", THELIA_WEB_DIR . 'fm-dir');

            // Create a new token
            $indexName = TokenProvider::generateToken();

            // Save it in module config
            self::setConfigValue('index-name', $indexName);

            // Rename index.php (or whatever its name is) with the new token.
            $fs->rename(THELIA_WEB_DIR . 'fm-dir' . DS . "index.php", THELIA_WEB_DIR . 'fm-dir' . DS . $indexName . ".php");

        } catch (\Exception $ex) {
            // Rethrow exception.
            throw $ex;
        }
    }

    /**
     * @param ConnectionInterface|null $con
     * @throws \Exception
     */
    public function postDeactivation(ConnectionInterface $con = null)
    {
        // Delete file manager from the web space.
        $fs = new Filesystem();

        $fs->remove(THELIA_WEB_DIR . 'fm-dir');
    }
}
