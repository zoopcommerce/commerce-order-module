<?php

namespace Zoop\Order\Test;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Doctrine\ODM\MongoDB\DocumentManager;
use Zoop\Shard\Core\Events;
use Zoop\Shard\Manifest;
use Zoop\Shard\Serializer\Unserializer;
use Zoop\Store\DataModel\Store;

abstract class AbstractTest extends AbstractHttpControllerTestCase
{
    protected static $documentManager;
    protected static $noAuthDocumentManager;
    protected static $dbName;
    protected static $unserializer;
    protected static $manifest;
    protected static $store;

    public function setUp()
    {
        if (!isset(self::$documentManager)) {
            $this->setApplicationConfig(
                require __DIR__ . '/../../../test.application.config.php'
            );
            self::$documentManager = $this->getApplicationServiceLocator()
                ->get('shard.commerce.modelmanager');

            self::$noAuthDocumentManager = $this->getApplicationServiceLocator()
                ->get('doctrine.odm.documentmanager.noauth');

            $eventManager = self::$documentManager->getEventManager();
            $eventManager->addEventListener(Events::EXCEPTION, $this);
        }

        if (!isset(self::$dbName)) {
            self::$dbName = $this->getApplicationServiceLocator()
                ->get('config')['doctrine']['odm']['connection']['commerce']['dbname'];
        }

        if (!isset(self::$manifest)) {
            self::$manifest = $this->getApplicationServiceLocator()
                ->get('shard.commerce.manifest');
        }

        if (!isset(self::$unserializer)) {
            self::$unserializer = self::$manifest->getServiceManager()
                ->get('unserializer');
        }

        $this->calls = [];
    }

    /**
     * @return DocumentManager
     */
    public static function getDocumentManager()
    {
        return self::$documentManager;
    }

    /**
     * @return DocumentManager
     */
    public static function getNoAuthDocumentManager()
    {
        return self::$noAuthDocumentManager;
    }

    /**
     * @return string
     */
    public static function getDbName()
    {
        return self::$dbName;
    }

    /**
     * @return Manifest
     */
    public static function getManifest()
    {
        return self::$manifest;
    }

    /**
     * @return Unserializer
     */
    public static function getUnserializer()
    {
        return self::$unserializer;
    }

    /**
     * @return Store
     */
    public static function getStore()
    {
        $store = new Store;
        $store->setSlug('apple');
        $store->setName('Apple');
        $store->setIsActive(true);
        $store->setCanDisplay(true);

        return $store;
    }


    public static function tearDownAfterClass()
    {
        self::clearDatabase();
    }

    public static function clearDatabase()
    {
        if (isset(self::$documentManager) && isset(self::$dbName)) {
            $collections = self::$documentManager
                ->getConnection()
                ->selectDatabase(self::$dbName)
                ->listCollections();

            foreach ($collections as $collection) {
                /* @var $collection \MongoCollection */
                $collection->drop();
            }
        }
    }

    public function __call($name, $arguments)
    {
        die(var_dump($name, $arguments[0]));
        $this->calls[$name] = $arguments;
    }
}
