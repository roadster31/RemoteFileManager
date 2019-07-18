<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 18/07/2019 18:29
 */
namespace RemoteFileManager\Hook;

use RemoteFileManager\RemoteFileManager;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class HookManager extends BaseHook
{
    public function onModuleConfigure(HookRenderEvent $event)
    {
        $fmUrl = URL::getInstance()->absoluteUrl(
            sprintf(
                "/fm-dir/%s.php", RemoteFileManager::getConfigValue('index-name')
            ),
            null,
            URL::PATH_TO_FILE
        );

        $event->add(
            $this->render('remote-file-manager/module-configuration.html', ['indexUrl' => $fmUrl])
        );
    }
}
