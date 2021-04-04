<?php


namespace App\Data;


use App\Model\Model;
use Yiisoft\Arrays\ArrayableInterface;
use Yiisoft\Arrays\ArrayHelper;

trait ArrayableTrait
{
    use \Yiisoft\Arrays\ArrayableTrait;

    /**
     * @param array $fields
     * @param array $expand
     * @param bool $recursive
     * @return array
     */
    public function toArray(array $fields = [], array $expand = [], bool $recursive = true): array
    {
        $data = [];
        foreach ($this->resolveFields($fields, $expand) as $field => $definition) {
            $attribute = is_string($definition) ? $this->$definition : $definition($this, $field);
            if ($recursive) {
                $nestedFields = $this->extractFieldsFor($fields, $field);
                $nestedExpand = $this->extractFieldsFor($expand, $field);
                $attribute = $this->buildArrayField($attribute, $nestedFields, $nestedExpand);
            }
            $data[$field] = $attribute;
        }
        return $recursive ? ArrayHelper::toArray($data) : $data;
    }

    /**
     * @param $attribute
     * @param null $nestedFields
     * @param null $nestedExpand
     * @return mixed
     */
    protected function buildArrayField($attribute, $nestedFields = null, $nestedExpand = null): mixed
    {
        if ($attribute instanceof ArrayableInterface) {
            $attribute = $attribute->toArray($nestedFields, $nestedExpand);
        } else if ($attribute instanceof Model) {
            $attribute = $attribute->toArray();
        } else if (is_array($attribute)) {
            $tmpAttribute = [];
            foreach ($attribute as $key => $item) {
                $tmpAttribute[$key] = $this->buildArrayField($item);
            }
            $attribute = $tmpAttribute;
        }

        return $attribute;
    }
}
