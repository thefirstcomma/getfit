<?php 

?>

<style type="text/css">
	.entry-header {
		display: none;
	}
</style>

<div class="px-4 px-lg-0">
  <!-- For demo purpose -->
  <div class="container text-white py-5 text-center">
    <h1 class="display-4">Shopping Cart</h1>
    <p class="lead mb-0">Build a fully structred shopping cart page using Bootstrap 4. </p>
    <p class="lead">Snippet by <a href="https://bootstrapious.com/snippets" class="text-white font-italic">
            <u>Bootstrapious</u></a>
    </p>
  </div>
  <!-- End -->

  <div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Product</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Price</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Quantity</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Remove</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row" class="border-0">
                    <div class="p-2">
                      <img src="http://localhost:8888/cs4800/wp-content/uploads/2019/12/66b432c13355afbfae9effff8002cd7b23beba64e1a7368345c7cfffb1f0217c.png" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">Dress 1</a></h5><span class="text-muted font-weight-normal font-italic d-block">Category: Dress</span>
                      </div>
                    </div>
                  </th>
                  <td class="border-0 align-middle"><strong>$1 M</strong></td>
                  <td class="border-0 align-middle"><strong>3</strong></td>
                  <td class="border-0 align-middle"><a href="#" class="text-dark"><i class="fa fa-trash"></i></a></td>
                </tr>
                <tr>
                  <th scope="row">
                    <div class="p-2">
                      <img src="http://localhost:8888/cs4800/wp-content/uploads/2019/12/6e0156767353df08689712f788d4ea4edcc92e28f57225f237b9c49967376c22.png" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"><a href="#" class="text-dark d-inline-block">Dress 2</a></h5><span class="text-muted font-weight-normal font-italic">Category: Dress</span>
                      </div>
                    </div>
                  </th>
                  <td class="align-middle"><strong>$1 M</strong></td>
                  <td class="align-middle"><strong>3</strong></td>
                  <td class="align-middle"><a href="#" class="text-dark"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <div class="p-2">
                      <img src="http://localhost:8888/cs4800/wp-content/uploads/2019/12/2b9f7c43f4d042116f4f20c4b24756c0922ec2beea8f0f52d6b9fa35bb9cd45d.png" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block">Dress 3</a></h5><span class="text-muted font-weight-normal font-italic">Category: Dress</span>
                      </div>
                    </div>
                    <td class="align-middle"><strong>$1 M</strong></td>
                    <td class="align-middle"><strong>3</strong></td>
                    <td class="align-middle"><a href="#" class="text-dark"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- End -->
        </div>
      </div>

      <div class="row py-5 p-4 bg-white rounded shadow-sm">
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
          <div class="p-4">
            <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
            <div class="input-group mb-4 border rounded-pill p-2">
              <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
              <div class="input-group-append border-0">
                <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
              </div>
            </div>
          </div>
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
          <div class="p-4">
            <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
            <textarea name="" cols="30" rows="2" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
          <div class="p-4">
            <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
            <ul class="list-unstyled mb-4">
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>$3 M</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>$600,000.00</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>$20 M</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                <h5 class="font-weight-bold">$23.6 M</h5>
              </li>
            </ul><a href="<?= home_url('/cart/checkout/') ?>" class="btn btn-dark rounded-pill py-2 btn-block">Procceed to checkout</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
