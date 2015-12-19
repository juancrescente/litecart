  <?php /*<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">*/ ?>
  <nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo document::ilink(''); ?>"><?php echo settings::get('store_name'); ?></a>
      </div>
      
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <?php foreach ($items as $item) { ?>
          <li class="<?php echo $item['type'] .'-'. $item['id']; ?>"><a href="<?php echo htmlspecialchars($item['link']); ?>"><?php echo $item['title']; ?></a></li>
          <?php } ?>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="btn-group">
            <button type="button" class="" data-toggle="dropdown" aria-expanded="false">
              <span class="pull-left"><?php echo functions::draw_fonticon('fa-shopping-cart'); ?> <?php echo language::translate('title_cart', 'Cart'); ?>: 2 item(s)</span>
              <span class="pull-right"><i class="fa fa-caret-down"></i></span>
            </button>
            <ul class="dropdown-menu cart-content" role="menu">
              <li>
                <a href="detail.html">
                  <b>Penn State College T-Shirt</b>
                  <span>x1 $528.96</span>
                </a>
              </li>
              <li>
                <a href="detail.html">
                  <b>Live Nation ACDC Gray T-Shirt</b>
                  <span>x1 $428.96</span>
                </a>
              </li>
              <li class="divider"></li>
              <li><a href="cart.html">Total: $957.92</a></li>
            </ul>
          </li>
        </ul>
      </div>
      
      <div class="">

      </div>
    </div>
  </nav>