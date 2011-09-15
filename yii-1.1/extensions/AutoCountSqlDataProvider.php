<?php

/**
 * AutoCountSqlDataProvider extends the CSqlDataProvider. It adds the ability
 * to use pagination without first counting all the rows, thus increasing the
 * performance when browsing large tables.
 */
class AutoCountSqlDataProvider extends CSqlDataProvider
{
	/**
	 * A flag that indicates more rows available.
	 */
	public $hasMore;

	private $totalItemCount;
	private $rows;
	private $force_count;

	/**
	 * Constructor.
	 * @param string $table the name of the table to read rows from. 
	 * @param CDbCriteria $criteria the db criteria to apply when reading from the table.
	 * @param boolean $force_count whether to force counting the available rows.
	 * @param array $config parameters to pass to the parent.
	 */
	public function __construct($table, $criteria, $force_count, $config=array())
	{
		$config['params'] = $criteria->params;
		$sql = Yii::app()->getDb()->getCommandBuilder()->createFindCommand($table, $criteria)->text;
		parent::__construct($sql, $config);

		$this->force_count = $force_count;

		if ($force_count)
		{
			$this->totalItemCount = Yii::app()->getDb()->getCommandBuilder()->createCountCommand($table, $criteria)->queryScalar();
		}
		else
		{
			$pageSize = $this->pagination->pageSize;
			$this->pagination = new Pagination();
			$this->pagination->validateCurrentPage = false;
			$this->pagination->pageSize = $pageSize;
		}
	}

	/**
	 * Override the default getTotalItemCount of CDataProvider.
	 * @return integer total number of possible data items.
	 */
	public function getTotalItemCount($refresh=false)
	{
		return $this->totalItemCount;
	}

	/**
	 * Extend fetchData of CSqlDataProvider. Update hasMore and totalItemCount
	 * accordingly.
	 * @return array list of data items
	 */
	public function fetchData()
	{
		if (isset($this->rows))
		{
			return $this->rows;
		}
		$this->rows = parent::fetchData();
		if ($this->force_count)
		{
			return $this->rows;
		}

		if (count($this->rows) > $this->pagination->pageSize)
		{
			$this->hasMore = true;
			array_pop($this->rows);
		}
		else
		{
			$this->hasMore = false;
		}
		$this->totalItemCount = $this->pagination->offset + count($this->rows);
		$this->pagination->itemCount = $this->totalItemCount + ($this->hasMore ? 1 : 0);
		return $this->rows;
	}
}

/**
 * Pagination extends CPagination. It is used when AutoCountSqlDataProvider does
 * not count the available rows.
 */
class Pagination extends CPagination
{
	/**
	 * @return integer the limit of the data plus one (for checking if there are
	 * more rows).
	 */
	public function getLimit()
	{
		return parent::getLimit()+1;
	}
}
