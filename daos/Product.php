<?php
namespace app\daos;
use app\base\BaseDao;
use yii\data\Pagination;
use yii\helpers\Json;
/**
 * 商品对应的Dao
 * @author xiawei
 */
class Product extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product';
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::tableName()
	 */
	protected function tableName() {
		return self::TABLE_NAME;
	}
	
	/**
	 * 单例
	 * @param string $className
	 * @return Product
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 通过查询条件获取对应的数据总数
	 * @param array $search 查询条件
	 * @return int
	 */
	public function countBySearch(array $search) {
		$condition = ['and'];
		if (!empty($search['name'])) {
			$condition[] = ['like', 'name', $search['name']];
		}
		if ($search['grounding'] != -1) {
			$condition[] = "grounding={$search['grounding']}";
		}
		if ($search['stock_price_min'] !== '') {
			$condition[] = "stock_price_min>={$search['stock_price_min']}";
		}
		if ($search['stock_price_max'] !== '') {
			$condition[] = "stock_price_max<={$search['stock_price_max']}";
		}
		if ($search['top_cat_id'] !== '') {
			$condition[] = "top_cat_id={$search['top_cat_id']}";
		}
		if ($search['cat_id'] !== '') {
			$condition[] = "cat_id={$search['cat_id']}";
		}
		
		return $this->createQuery()
			->from($this->tableName())
			->where($condition)
			->count('*', self::db());
	}
	
	/**
	 * 根据搜索条件分页查询数据
	 * @param array $search 搜索条件
	 * @param Pagination $pagination 分页组件
	 * @param string $select 查询字段
	 * @return array 返回数据 
	 */
	public function pageBySearch($search, Pagination $pagination) {
		$condition = ['and'];
		if (!empty($search['name'])) {
			$condition[] = ['like', 'p.name', $search['name']];
		}
		if ($search['grounding'] != -1) {
			$condition[] = "p.grounding={$search['grounding']}";
		}
		if ($search['stock_price_min'] !== '') {
			$condition[] = "p.stock_price_min>={$search['stock_price_min']}";
		}
		if ($search['stock_price_max'] !== '') {
			$condition[] = "p.stock_price_max<={$search['stock_price_max']}";
		}
		if ($search['top_cat_id'] != 0) {
			$condition[] = "p.top_cat_id={$search['top_cat_id']}";
		}
		if ($search['cat_id'] != 0) {
			$condition[] = "p.cat_id={$search['cat_id']}";
		}
		return $this->createQuery()
			->select(['p.id', 'p.name', 'p.stock_price', 'p.price', 'p.number', 'p.title_img', 'p.warn_number', 'p.show_buy_number', 'p.grounding', 'tpc.name as tpc_name', 'pc.name as pc_name', 'p.options'])
			->from($this->tableName().' p')
			->leftJoin(ProductCat::TABLE_NAME.' tpc', 'tpc.id=p.top_cat_id')
			->leftJoin(ProductCat::TABLE_NAME.' pc', 'pc.id=p.cat_id')
			->where($condition)
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all(self::db());
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::insert()
	 */
	public function insert($product) {
		//开启事务
		$transaction = self::db()->beginTransaction();
		$flag = true;
		//插入一个产品
		if (parent::insert($product)) {
			if (!empty($product['options'])) {
				$productId = self::db()->getLastInsertID();
				//获取对应的options
				$options = $product['options'];
				$options = Json::decode($options);
				//获取options对应的笛卡尔积
				$combOptions = $this->getCombOptions($options);
				foreach ($combOptions as $combOption) {
					$productStock = [
						'options' => $combOption,
						'product_id' => $productId,
						'md5_key' => md5($combOption),
						'num' => 0
					];
					if (!ProductStock::instance()->insert($productStock)) {
						$flag = false;
						break;
					}
				}
			}
		} else {
			$flag = false;
		}
		if ($flag) {
			$transaction->commit();
		} else {
			$transaction->rollBack();
		}
		return $flag;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::delete()
	 */
	public function delete($id) {
		//首先获取产品的选项
		$options = $this->scalarByPrimaryKey($id, 'options');
		if (empty($options)) {
			return $this->delete($id);
		} else {
			$transaction = self::db()->beginTransaction();
			if ($this->delete($id) && (ProductStock::instance()->deleteByColumn('product_id', $id) !== false)) {
				$transaction->commit();
				return true;
			}
			$transaction->rollBack();
			return false;
		}
	}
	
	/**
	 * 获取商品选项的笛卡尔积
	 * @param array $options 商品选项
	 * @return array
	 */
	private function getCombOptions($options) {
		$optionsArr = [];
		foreach ($options as $option) {
			$optionsArr[] = $option['value'];
		}
		return $this->getCombOptionArr($optionsArr);
	}
	
	private function getCombOptionArr($sets) {
		// 保存结果
		$result = [];
		// 循环遍历集合数据
		for($i=0,$count=count($sets); $i<$count-1; $i++){
			if($i==0) {
				$result = $sets[$i];
			}
			// 保存临时数据
			$tmp = array();
			// 结果与下一个集合计算笛卡尔积
			foreach($result as $res){
				foreach($sets[$i+1] as $set){
					$tmp[] = $res.','.$set;
				}
			}
			// 将笛卡尔积写入结果
			$result = $tmp;
		}
		return $result;
	}
	
	
	/**
	 * 获取商品库存
	 * @param int $id 对应的商品Id
	 * @return mixed|mixed|number|boolean|string
	 */
	public function getProductNum($id) {
		//获取对应的商品选项
		$product = $this->get($id, ['options', 'number']);
		if (empty($product['options'])) {
			return $product['number'];
		}
		return ProductStock::instance()->sumByColumn('product_id', $id, 'num');
	}
}