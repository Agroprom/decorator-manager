<?php
namespace components\models;
use components\models\DataProvider;
use components\interfaces\DataProviderInterface;
use DateTime;
use Exception;

use​Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DecoratorManager
 *
 * @author agroprom
 */
/*
 * не очень понятно почему класс называется DecoratorManager, я бы назвал DataManager или как-то так исходя из контекста
 */
class DecoratorManager {
 
/*
 * $dataProvider выносим в свойство вместо наследования от класса
 * DecoratorManager в конструктор должен получать уже готовый датапровайдер
 * свойства делаем приватными
 * присвоение делаем в конструкторе
 * также можно написать для них гетеры и сетеры, если всё же понадобится их зачем-то менять или дёргать. 
 * Я не стал для экономии времени
 */    
    
    private $cache;
    private $logger;
    private $dataProvider;
          
    /**
     * 
     * @param DataProviderInterface $dataProvider
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cache, LoggerInterface $logger )
    {
        $this->dataProvider = $dataProvider;
        $this->cache = $cache;
        $this->logger = $logger;                
    }
     
    /**
     * 
     * @param array $input
     * @return type
     */    
    public function getResponse(array $input)
    {
        try {

            $cacheKey = json_encode($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
/**
 * Результат получаем из свойства датапровайдера
 */
            $result = $this->dataProvider->get($input);
  
            $cacheItem->set($result)
                ->expiresAt((new DateTime())->modify('+1 day')
                );
            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error');
        }
        return [];
    }    
    
    
}
