<?php

namespace Zoop\Order\Test;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Doctrine\ODM\MongoDB\DocumentManager;

abstract class BaseTest extends AbstractHttpControllerTestCase
{
    protected static $documentManager;
    protected static $dbName;

    public function setUp()
    {
        if (!isset(self::$documentManager)) {
            $this->setApplicationConfig(
                require __DIR__ . '/../../../test.application.config.php'
            );
            self::$documentManager = $this->getApplicationServiceLocator()->get('shard.commerce.modelmanager');
        }
        
        if (!isset(self::$dbName)) {
            self::$dbName = $this->getApplicationServiceLocator()->get('config')['doctrine']['odm']['connection']['commerce']['dbname'];
        }
    }

    public static function tearDownAfterClass()
    {
        self::clearDatabase();
    }

    /**
     * Clears all test data from the mongo database
     */
    public static function clearDatabase()
    {
        if (isset(self::$documentManager)) {
            $collections = self::getDocumentManager()
                ->getConnection()
                ->selectDatabase(self::getDbName())
                ->listCollections();

            foreach ($collections as $collection) {
                /* @var $collection \MongoCollection */
                $collection->drop();
            }
        }
    }

    /**
     * @return DocumentManager
     */
    public static function getDocumentManager()
    {
        return self::$documentManager;
    }

    /**
     * @param DocumentManager $documentManager
     */
    public static function setDocumentManager(DocumentManager $documentManager)
    {
        self::$documentManager = $documentManager;
    }

    /**
     * 
     * @return string
     */
    public static function getDbName()
    {
        return self::$dbName;
    }

    /**
     * 
     * @param string $dbName
     */
    public static function setDbName($dbName)
    {
        self::$dbName = $dbName;
    }
}
