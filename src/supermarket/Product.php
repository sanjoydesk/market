<?php 

class Product
{
	private $products = [];

	/*
	* Add a single product to the object
	* 
	* @item - Add a single array of product.
	* @return - Returns current object for method chaining.
	*/
    public function add($item)
    {
    	$this->products[] = $item;

    	return $this;
    }

    /*
    * Add all array of products to the object.
    *
    * @products - Array of Products
    *
    * @return - Return current object for method chaining.
    */
    public function addAll($products)
    {
    	$this->products = $products;

    	return $this;
    }

    /*
	* Check if product Exists.
	* 
	* @productId - Product ID
	* @return - bool  true or false
    */
    public function has($productId)
    {
    	$product = $this->findProduct($productId);
    	return !empty($product) ? true : false;
    }

    /*
    * Loop through the product lists and find if product exists 
    * @productId - int
    * @return - Returns array
    */
    private function findProduct($productId)
    {
    	$product = [];
    	foreach ($this->products as $key => $value) {
    		if ($value['id'] === $productId) {
    			$product = $value;
    		}
    	}

    	return $product;
    }

    /*
	* Get Product by ID.
	* 
	* @productId - Product ID
	* @return - Product array
    */
    public function get($productId)
    {
    	return $this->findProduct($productId);
    }

    /*
    * Get All products
    *
    * @return - array of products.
    */
    public function getAll()
    {
    	return $this->products;
    }

    /*
    * This method will return the discount on the product.
    * 
	* @productKey - product ID
	* @numberOfItem - For how many number of item discount is available
	* @comboProductId - Combo Product ID. Discount on combo product. Default empty. 
	* 
	* @return int discount amount
    */
    public function getDiscount($productKey, $numberOfItem, $comboProductId = '')
    {
    	$discount = 0;
    	foreach ($this->products as $key => $value) {
    		if ($value['id'] === $productKey && $value['number_of_item'] == $numberOfItem){
    			$discount = $value['discount_rate'];
    		} else if ($value['id'] === $productKey && !empty($comboProductId)) {
    			$comboProduct = array_filter($this->products, function ($value) use($comboProductId) {
				    return $value['id'] === $comboProductId;
				});

    			if (!empty($comboProduct)) {
    				$discount = 5;
    			}
    		}
    	}

    	return $discount;
    }
}
