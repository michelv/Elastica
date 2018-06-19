<?php
namespace Elastica\Query;

use Elastica\Exception\InvalidException;

/**
 * Terms lookup query.
 *
 * @author Michel Valdrighi <opensource@miche.lv>
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html#query-dsl-terms-lookup
 */
class LookupTerms extends AbstractQuery
{
    /**
     * Lookup terms.
     *
     * @var array Terms
     */
    protected $_terms;

    /**
     * Terms key.
     *
     * @var string Terms key
     */
    protected $_key;

    /**
     * Construct terms query.
     *
     * @param string $key   OPTIONAL Terms key
     * @param array  $terms OPTIONAL Terms list
     */
    public function __construct($key = '', array $terms = [])
    {
        $this->setTerms($key, $terms);
    }

    /**
     * Sets key and lookup terms for the query.
     *
     * @param string $key   Terms key
     * @param array  $terms Lookup terms for the query.
     *
     * @return $this
     */
    public function setTerms($key, array $terms)
    {
        $this->_key = $key;
        $this->_terms = $terms;

        return $this;
    }

    /**
     * Converts the terms object to an array.
     *
     * @see \Elastica\Query\AbstractQuery::toArray()
     *
     * @throws \Elastica\Exception\InvalidException If term key is empty or lookup terms array is invalid
     *
     * @return array Query array
     */
    public function toArray()
    {
        static $requiredKeys = ['index', 'type', 'id', 'path'];

        if (empty($this->_key)) {
            throw new InvalidException('Terms key has to be set');
        }

        if (count(array_diff($requiredKeys, array_keys($this->_terms)))) {
            throw new InvalidException('Lookup terms array requires those keys: index, type, id, path');
        }

        $this->setParam($this->_key, $this->_terms);

        return parent::toArray();
    }
}
