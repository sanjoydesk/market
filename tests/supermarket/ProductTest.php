<?php 

require './src/supermarket/Product.php';

class ProductTest extends PHPUnit_Framework_TestCase 
{
	private $product;
	private $productList = [
		['id' => 1, 'name' => 'Item A', 'price' => 50, 'discount_rate' => 130, 'number_of_item' => 3], 
		['id' => 2, 'name' => 'Item B', 'price' => 30, 'discount_rate' => 45, 'number_of_item' => 2],
		['id' => 3, 'name' => 'Item C', 'price' => 20, 'discount_rate' => 38, 'number_of_item' => 2],
		['id' => 4, 'name' => 'Item C', 'price' => 20, 'discount_rate' => 50, 'number_of_item' => 3],
		['id' => 5, 'name' => 'Item D', 'price' => 15, 'discount_rate' => 5, 'number_of_item' => 1]
	];

	public function setUp()
	{
		$this->product = new Product();
		$this->product->addAll($this->productList);
		/*$this->product->add(['id' => 1, 'name' => 'Item A', 'price' => 50, 'discount_rate' => 130, 'number_of_item' => 3]);
		print_r($this->product->getDiscount(1, 3)); echo "\n";*/

	}

    public function testProductObject()
    {
		$this->assertInstanceOf(Product::class, $this->product);
    }

    public function testGetProductMethod()
    {
    	$product = $this->product->get(1);
		$this->assertEquals(
			$product, 
			['id' => 1, 'name' => 'Item A', 'price' => 50, 'discount_rate' => 130, 'number_of_item' => 3]
		);

		$productTwo = $this->product->get(2);
		$this->assertEquals(
			$productTwo, 
			['id' => 2, 'name' => 'Item B', 'price' => 30, 'discount_rate' => 45, 'number_of_item' => 2]
		);

		$productThree = $this->product->get(3);
		$this->assertEquals(
			$productThree, 
			['id' => 3, 'name' => 'Item C', 'price' => 20, 'discount_rate' => 38, 'number_of_item' => 2]
		);

		$productFive = $this->product->get(5);
		$this->assertEquals(
			$productFive, 
			['id' => 5, 'name' => 'Item D', 'price' => 15, 'discount_rate' => 5, 'number_of_item' => 1]
		);
    }

    public function testAddMethodShouldAddNewProduct()
    {
    	$newProduct = ['id' => 6, 'name' => 'Item E', 'price' => 5, 'discount_rate' => 0, 'number_of_item' => 1];
    	$this->product->add($newProduct);
    	$productSix = $this->product->get(6);
    	$this->assertEmpty(!$productSix);
		$this->assertEquals($productSix, $newProduct);
		$this->assertEquals($productSix['name'], 'Item E');
		$this->assertEquals($productSix['price'], 5);
    }

    public function testHasProductMethod()
    {
        $this->assertTrue($this->product->has(1));
        $this->assertFalse($this->product->has(7));
    }

    public function testGetAllReturnsAllProducts()
    {
        $this->assertEquals($this->product->getAll(), $this->productList);
    }

    public function testProductADiscount()
    {
    	$this->assertEquals($this->product->getDiscount(1, 3), 130);
    }

    public function testProductBDiscount()
    {
    	$this->assertEquals($this->product->getDiscount(2, 2), 45);
    }

    public function testProductCDiscount()
    {
    	$this->assertEquals($this->product->getDiscount(3, 2), 38);
    	$this->assertEquals($this->product->getDiscount(4, 3), 50);
    }

    public function testProductDDiscount()
    {
    	$this->assertEquals($this->product->getDiscount(5, 1, 1), 5);
    }

    public function testProductDDiscountShouldReturnZeroWhenComboProductIdNotExists()
    {
    	$this->assertEquals($this->product->getDiscount(5, 0, 11), 0);
    }

    public function tearDown(){ }
}
//