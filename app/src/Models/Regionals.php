<?php
namespace Membership\Models;

use Membership\Models;

class Regionals extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'regionals';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'id';

    /**
     * {@inheritdoc}
     */
    protected $destructive = true;

    /**
     * {@inheritdoc}
     */
    protected $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;

    public function getProvinces()
    {
        return $this->get([$this->primary, 'regional_name'], function ($query) {
            $query->whereNull('parent_id')
                ->where('city_code', '=', '00')
                ->orderBy($this->primary);
        })->fetchAll();
    }

    public function getCities($provinceId)
    {
        return $this->get([$this->primary, 'regional_name'], function ($query) use ($provinceId) {
            $query->where('parent_id', '=', (int) $provinceId)
                ->orderBy('city_code');
        });
    }
}
