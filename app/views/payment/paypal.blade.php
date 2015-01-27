<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="https://js.braintreegateway.com/v2/braintree.js"></script>
  </head>
  <body>
    <form id="checkout" method="post">
      <div id="dropin"></div>
      <input type="submit" value="Pay $10">
    </form>
    <script type="text/javascript">
        braintree.setup(
          "{{$client_token}}",
          'dropin', {
            container: 'dropin'
          });
    </script>
  </body>
</html>