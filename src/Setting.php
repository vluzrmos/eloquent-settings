<?php

namespace Vluzrmos\EloquentSettings;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Vluzrmos\EloquentSettings\Models\Option;

class Setting
{

    /**
     * @var Option|EloquentBuilder|QueryBuilder|null
     */
    protected $options;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var bool|null
     */
    protected $loaded;

    /**
     * @var bool|null
     */
    protected $unsaved;

    /**
     * @param Option $options
     */
    public function __construct(Option $options)
    {
        $this->options = $options;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return array
     */
    public function get($key, $default = null)
    {
        return array_get($this->getData(), $key, $default);
    }

    /**
     * @return array
     */
    protected function getData()
    {
        if (!$this->loaded) {
            $this->data = $this->parseCollection($this->options->all());

            $this->loaded = true;
        }

        return $this->data;
    }

    /**
     * @param Collection $collection
     *
     * @return array
     */
    protected function parseCollection(Collection $collection)
    {
        $data = [];

        foreach ($collection as $option) {
            array_set($data, $option->key, $option->value);
        }

        return $data;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value = null)
    {
        $data = $this->getData();

        $rows = is_array($key) ? $key : [$key => $value];

        foreach ($rows as $k => $v) {
            array_set($data, $k, $v);
        }

        $this->data = $data;
        $this->unsaved = true;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_has($this->all(), $key);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->getData();
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function forget($key)
    {
        array_forget($this->data, $key);

        $this->unsaved = true;
    }

    /**
     * @param $keys
     *
     * @return array
     */
    public function only($keys)
    {
        if (!is_array($keys)) {
            $keys = func_get_args();
        }

        return array_only($this->getData(), $keys);
    }

    /**
     * @param array|string $keys
     *
     * @return array
     */
    public function except($keys)
    {
        if (!is_array($keys)) {
            $keys = func_get_args();
        }

        return array_except($this->getData(), $keys);
    }

    /**
     * Store settings in the database.
     */
    public function save()
    {
        if ($this->unsaved) {
            $all = $this->getData();

            $data = array_dot($all);

            foreach ($data as $key => $value) {
                $this->options->updateOrCreate(compact('key'), compact('key', 'value'));
            }

            $this->options->whereNotIn('key', array_keys($data))->delete();

            $this->unsaved = false;
        }
    }
}