  <div class="container">
    <h2 class="product-cat-title">WholeScript Products:</h2>
    <div class="row wholescript_products">
        <?php         
        //$products_required = array("000000000300001022", "000000000300000009", "000000000300083087","000000000300001002", "000000000300000092", "000000000300005341", "000000000300005340", "000000000300000560", "000000000300000087");
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://testservices.wholescripts.com/api/Orders/ProductList',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_POSTFIELDS =>'{
            username: "276225",
            password: "fC1bM9bB1aQ5jM2j"
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic YOURCODE',
            'Content-Type: application/json'
          ),
        ));
        
        $fullscript_products = curl_exec($curl);
        $json_fullscript_products = json_decode($fullscript_products, true);
        
        foreach($json_fullscript_products as $product):
          $product_name = $product['productName'];
          $product_name_u = str_replace(' ', '%20', $product_name);
          $product_rprice = $product['retailPrice'];
          $product_wimage = $product['productImage'];
          $product_sku = $product['sku'];
          $product_url = "https://thedesignocracy.com/arisemd/ws-checkout/?pname=";
          $product_url = $product_url.urlencode($product_name)."&sku=".$product_sku;
        
          if(in_array($product_sku, $wholescript_products)):
        ?>

          <div class="col-md-3 col-sm-6">
            <div class="product-grid">
                <div class="product-image">
                    <a class="image" href="<?php echo $product_url; ?>" style="background-color:#F3F3F3;">
                        <img class="pic-1" src="<?php echo $product_wimage; ?>">
                    </a>
                    <a class="add-to-cart" href="<?php echo $product_url; ?>"> + </a>
                </div>
                <div class="product-content">
                    <h3 class="title"><?php echo $product_name; ?></h3>
                    <div class="price">$<?php echo $product_rprice; ?></div>
                    <div class="sku"><?php echo $product_sku; ?></div>
                </div>

                <div class="action-buttons">
                    <a class="btn-outline buy_now" href="<?php echo $product_url; ?>">Buy Now</a>
                </div>
            </div>
          </div>

        
        <?php
          endif;
        endforeach;
        curl_close($curl);

        ?>

    </div>
