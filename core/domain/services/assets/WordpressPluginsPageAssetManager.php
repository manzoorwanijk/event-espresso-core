<?php

namespace EventEspresso\core\domain\services\assets;

use DomainException;
use EventEspresso\core\domain\DomainInterface;
use EventEspresso\core\domain\services\admin\ExitModal;
use EventEspresso\core\exceptions\InvalidDataTypeException;
use EventEspresso\core\exceptions\InvalidEntityException;
use EventEspresso\core\services\assets\AssetCollection;
use EventEspresso\core\services\assets\Registry;
use EventEspresso\core\services\collections\DuplicateCollectionIdentifierException;

/**
 * Class WpPluginsPageAssetManager
 * Description
 *
 * @package EventEspresso\core\domain\services\assets
 * @author  Brent Christensen
 * @since   $VID:$
 */
class WordpressPluginsPageAssetManager extends ReactAssetManager
{
    const JS_HANDLE_WP_PLUGINS_PAGE = 'eventespresso-core-app';

    /**
     * @var ExitModal $exit_modal
     */
    private $exit_modal;


    /**
     * WordpressPluginsPageAssetManager constructor.
     *
     * @param AssetCollection $assets
     * @param DomainInterface $domain
     * @param Registry        $registry
     * @param ExitModal       $exit_modal
     */
    public function __construct(
        AssetCollection $assets,
        DomainInterface $domain,
        Registry $registry,
        ExitModal $exit_modal
    ) {
        $this->exit_modal = $exit_modal;
        parent::__construct($domain, $assets, $registry);
    }


    /**
     * @inheritDoc
     */
    public function addAssets()
    {
        parent::addAssets();
        $this->registerJavascript();
        $this->registerStyleSheets();
        add_action('admin_enqueue_scripts', [$this, 'enqueueBrowserAssets'], 10);
    }


    /**
     * Register javascript assets
     *
     * @throws InvalidDataTypeException
     * @throws InvalidEntityException
     * @throws DuplicateCollectionIdentifierException
     * @throws DomainException
     */
    private function registerJavascript()
    {
        $this->addJs(
            WordpressPluginsPageAssetManager::JS_HANDLE_WP_PLUGINS_PAGE,
            [
                CoreAssetManager::JS_HANDLE_JS_CORE,
                ReactAssetManager::JS_HANDLE_REACT,
                ReactAssetManager::JS_HANDLE_REACT_DOM,
                'wp-components',
                'wp-i18n',
                'wp-url'
            ]
        )
        ->setRequiresTranslation()
        ->setInlineDataCallback(
            function () {
                wp_localize_script(
                    WordpressPluginsPageAssetManager::JS_HANDLE_WP_PLUGINS_PAGE,
                    'eeExitSurveyInfo',
                    $this->exit_modal->getExitSurveyInfo()
                );
                wp_add_inline_script(
                    WordpressPluginsPageAssetManager::JS_HANDLE_WP_PLUGINS_PAGE,
                    "
var eeDomain='wpPluginsPage';
        ",
                    'before'
                );
            }
        );
    }


    /**
     * Register CSS assets.
     *
     * @throws DuplicateCollectionIdentifierException
     * @throws InvalidDataTypeException
     * @throws InvalidEntityException
     * @throws DomainException
     */
    private function registerStyleSheets()
    {
        wp_enqueue_style('wp-components');
    }
}