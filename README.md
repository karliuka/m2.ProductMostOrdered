# Magento2 ProductMostOrdered
Extension displays the top most ordered products(bestseller) for your stores.

### Home page
<img alt="Magento2 ProductMostOrdered" src="https://karliuka.github.io/m2/product-most-ordered/home-block.png" style="width:100%"/>
### Category page
<img alt="Magento2 ProductMostOrdered" src="https://karliuka.github.io/m2/product-most-ordered/category.png" style="width:100%"/>
## Install with Composer as you go

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-product-most-ordered
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy
	```
3. Display and configuration:

A shortcode to Homepage and to other CMS pages or CMS blocks.


    ```bash
	{{block class='Faonni\ProductMostOrdered\Block\ProductList' 
			template='Faonni_ProductMostOrdered::product/list/items.phtml' 
			title='Most Ordered Products' 
			num_products='6'
	}}
    ```
A Layout Update XML to all categories.

    ```bash
	<referenceBlock name="catalog.product.most.ordered">
		<action method="setTitle">
			<argument name="title" xsi:type="string" translate="true">Most Ordered Products of Category</argument>
		</action>
		<action method="setNumProducts">
			<argument name="num_products" xsi:type="string">6</argument>
		</action>
		<action method="setPeriod">
			<argument name="period" xsi:type="string">monthly</argument>
		</action>	
	</referenceBlock>
		```
