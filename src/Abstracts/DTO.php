<?php
declare(strict_types=1);
namespace Ostah\LaravelCompo\Abstracts;

abstract class DTO
{
    private $data = [];
    protected $lockSetter = false;

    protected function setData($data)
    {
        $this->data = $data;
    }

    public function __set($name, $value)
    {
        if (!$this->lockSetter) {
            $this->data[$name] = $value;
        }
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public final function toArray(): array
    {
        return $this->data;
    }
}
