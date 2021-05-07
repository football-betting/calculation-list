<?php
declare(strict_types=1);
namespace App\DataTransferObject;

/**
 * Auto generated data provider
 */
final class TippListDataProvider extends \Xervice\DataProvider\Business\Model\DataProvider\AbstractDataProvider implements \Xervice\DataProvider\Business\Model\DataProvider\DataProviderInterface
{
    /** @var string */
    protected $event;

    /** @var \App\DataTransferObject\TippDataProvider[] */
    protected $data = [];


    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }


    /**
     * @param string $event
     * @return TippListDataProvider
     */
    public function setEvent(string $event)
    {
        $this->event = $event;

        return $this;
    }


    /**
     * @return TippListDataProvider
     */
    public function unsetEvent()
    {
        $this->event = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasEvent()
    {
        return ($this->event !== null && $this->event !== []);
    }


    /**
     * @return \App\DataTransferObject\TippDataProvider[]
     */
    public function getData(): array
    {
        return $this->data;
    }


    /**
     * @param \App\DataTransferObject\TippDataProvider[] $data
     * @return TippListDataProvider
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * @return TippListDataProvider
     */
    public function unsetData()
    {
        $this->data = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasData()
    {
        return ($this->data !== null && $this->data !== []);
    }


    /**
     * @return array
     */
    protected function getElements(): array
    {
        return array (
          'event' =>
          array (
            'name' => 'event',
            'allownull' => false,
            'default' => '',
            'type' => 'string',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'data' =>
          array (
            'name' => 'data',
            'allownull' => false,
            'default' => '',
            'type' => '\\App\\DataTransferObject\\TippDataProvider[]',
            'is_collection' => true,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
        );
    }
}
