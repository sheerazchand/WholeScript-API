<?php get_header(); 
error_reporting(E_ALL);
ini_set('display_errors', 'On');
?>

<div class="container">
  <div class="wholescript-form">
    <form method="post" action="">
      <p>Please fill the following fields to complete the order for <strong class="product_name"><?php echo $_GET['pname']; ?></strong></p>
      <div class="row">
        <div class="col-md">
          <label>First Name</label>
          <input name="fname" type="text" placeholder="John" required />
        </div>    
        <div class="col-md">
          <label>Last Name</label>
          <input name="lname" type="text" placeholder="Doe" required/>
        </div>
      </div>

      <div class="row">
        <div class="col-md">
          <label>Address 1</label>
          <input name="address1" type="text" placeholder="123 Main St" required/>
        </div>
        <div class="col-md">
          <label>Address 2</label>
          <input name="address2" type="text" placeholder="Ocala Town"/>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md">
          <label>City</label>
          <input name="city" type="text" placeholder="Orlando" required/>
        </div>
        <div class="col-md">
          <label>State</label>
          <input name="state" type="text"  placeholder="FL" required />
        </div>
        <div class="col-md">
          <label>Zip Code</label>
          <input name="zip" type="number" placeholder="32819" required />
        </div>
      </div>
      
      <div class="row">
        <div class="col-md">
          <label>Quantity</label>
          <input type="number" name="quantity" min="1" required />
        </div>
        <div class="col-md">
          <label>Order Notes</label>
          <input name="notes" type="text" />
        </div>
      </div>

      <input type="submit" name="submit" value="Submit Order" />
      <input name="sku" class="product_sku" type="hidden" value="<?php echo $_GET['sku']; ?>" />

    </form>


    <?php

    if(isset($_POST['submit'])):

      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $address1 = $_POST['address1'];
      $address2 = $_POST['address2'];
      $city = $_POST['city'];
      $state = $_POST['state'];
      $zip = $_POST['zip'];
      $number = $_POST['quantity'];
      $notes = $_POST['notes'];
      $sku = $_POST['sku'];


      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://testservices.wholescripts.com/api/Orders/Submit',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "ShippingAddress": {
              "FName": "'.$fname.'",
              "LName": "'.$lname.'",
              "Address1": "'.$address1.'",
              "Address2": "'.$address2.'",
              "City": "'.$city.'",
              "State": "'.$state.'",
              "Zip": "'.$zip.'"
          },
          "Notes": "test notes",
          "Items": [
              {
                  "Sku": "'.$sku.'",
                  "Quantity": '.$number.'
              }
          ],
          "ShippingMethod": "STANDARD"
      }
      ',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Basic YOUR_CODE_HERE',
          'Content-Type: application/json'
        ),
      ));

      $ws_response = curl_exec($curl);
      $ws_json_response = json_decode($ws_response, true);
      
      if($ws_json_response['success']=="true"):
        $order_number = $ws_json_response['orderNumber'];
        echo "<p class='success_message'>Your order is placed successfully, your order# is: ".$order_number."</p>";
      endif;

      if($ws_json_response['msg'] == "Invalid shipping address" || $ws_json_response['success']!="true"):
        $error_message = $ws_json_response['msg'];
        echo "<p class='error_message'>There is an error occurred while order submission, ".$error_message."!</p>";
      endif;

      curl_close($curl);

    endif;

    ?>

  </div>
</div>

<?php get_footer(); ?>
