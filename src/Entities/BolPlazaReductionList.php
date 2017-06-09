<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaReduction
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $data
 * @property string $filename
 */
class BolPlazaReductionList {

    /** @var string */
    protected $data;

    /** @var string */
    protected $filename;

    public function __construct($data, $filename)
    {
        $this->data = $data;
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

}
