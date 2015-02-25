<?php
interface CategoryRepository{
	public function All($orderBy = 'ASC');
	/**
	 * Insert category get id or not
	 */
	public function Insert($category,$type = null);
	/**
	 * Remove category
	 */
	public function Delete($category_id);
}
?>