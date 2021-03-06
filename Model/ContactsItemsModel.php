<?php

namespace Kanboard\Plugin\Contacts\Model;

use Kanboard\Core\Base;

/**
 * Contacts items model
 *
 * @package  model
 * @author   Martin Middeke
 */
class ContactsItemsModel extends Base
{
    /**
     * SQL table name for ContactsItems
     *
     * @var string
     */
    const TABLE = 'contacts_items';

    /**
     * Return all contact items
     *
     * @access public
     * @return array
     */
    public function getAllItems()
    {
        return $this->db->table(self::TABLE)->asc(self::TABLE.'.position')->findAll();
    }

    /**
     * Get item by id
     *
     * @access public
     * @param  integer  $item_id
     * @return array
     */
    public function getByID($item_id)
    {
        return $this->db->table(self::TABLE)->eq('id', $item_id)->findOne();
    }

    /**
     * Get id by position
     *
     * @access public
     * @param  integer  $position
     * @return array
     */
    public function getByPosition($position)
    {
        return $this->db->table(self::TABLE)->eq('position', $position)->findOne();
    }

    /**
     * Change item position
     *
     * @access public
     * @param  integer  $item_id
     * @param  string   $direction
     * @return boolean
     */
    public function changePosition($item_id, $direction)
    {
        if ($direction === 'up') $offset = -1;
        elseif ($direction === 'down') $offset = 1;
        else return false;
        $results = array();
        $old = $this->getByID($item_id);
        $old_position = $old['position'];
        $new_position = $old_position + $offset;
        $current_item = $this->getByPosition($new_position);
        $current_item_id = $current_item['id'];

        $results[] = $this->db->table(self::TABLE)->eq('id', $item_id)->update(array('position' => $new_position));
        $results[] = $this->db->table(self::TABLE)->eq('id', $current_item_id)->update(array('position' => $old_position));
        
        return !in_array(false, $results, true);
    }

    /**
     * Remove an item
     *
     * @access public
     * @param  integer  $contacts_id
     * @return bool
     */
    public function remove($item_id)
    {
        return $this->db->table(self::TABLE)->eq('id', $item_id)->remove();
    }

    /**
     * Update an item
     *
     * @access public
     * @param  array    $values    Form values
     * @return bool
     */
    public function update(array $values)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq('id', $values['id'])
            ->update($values);
    }

    /**
     * Save a new item
     *
     * @access public
     * @param  array    $values    Form values
     * @return boolean
     */
    public function save(array $values)
    {
        $max = $this->db->table(self::TABLE)->columns('max('.self::TABLE.'.position) maxid')->findOne();
        $values += array('position' => $max['maxid'] + 1);
        return $this->db
            ->table(self::TABLE)
            ->persist($values);
    }
}