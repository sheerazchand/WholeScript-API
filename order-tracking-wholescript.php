<?php get_header(); ?>

<div class="container">
  <div class="orders wholescript-form">
    <div class="row">
      <form method="post" action="">
          <p>Please enter your order number for status!</p>
          <div class="col-md pr-0 pl-0">
            <label>Order#</label>
            <input type="text" name="orderno" placeholder="XAPI00000411" required/>
            <input type="submit" name="submit" value="Track Order" />
          </div>

      </form>
      <?php 

      if(isset($_POST['submit'])):
        $orderno = $_POST['orderno'];
        $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://testservices.wholescripts.com/api/Orders/Status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic YOUR_CODE_HERE'
            ),
          ));

          $response = curl_exec($curl);
          $json_orders = json_decode($response, true);

          foreach($json_orders as $order):
            $orderNumber = $order['orderNumber'];
            $shipMethod = $order['shipMethod'];
            $shipCharge = $order['shipCharge'];
            $discount = $order['discount'];
            $tax = $order['tax'];
            $orderTotal = $order['orderTotal'];

            if($orderno == $orderNumber):
              echo "<table>";
              echo "<tr><th>Order</th> <td>".$orderNumber."</td></tr>";
              echo "<tr><th>Shipping Method</th> <td>".$shipMethod."</td></tr>";
              echo "<tr><th>Shipping Charges</th> <td>".$shipCharge."</td></tr>";
              echo "<tr><th>Discount</th> <td>".$discount."</td></tr>";
              echo "<tr><th>TAX</th> <td>".$tax."</td></tr>";
              echo "<tr><th>Order Total</th> <td>".$orderTotal."</td></tr>";
              echo "</table>";
            endif;
            
          endforeach;

          curl_close($curl);
          //  echo $response;
        endif;
        ?>
    </div>
  </div>
</div>


<?php get_footer(); ?>
