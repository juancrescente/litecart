  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
          <li>
            <div class="form-inline">
              <div class="input-group" data-toggle="tooltip" title="<?php echo language::translate('title_cart', 'Cart'); ?>">
                <a class="input-group-addon" href="<?php echo document::href_ilink('checkout'); ?>"><?php echo functions::draw_fonticon('fa-shopping-cart'); ?></a>
                <?php //include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
                <div class="form-control">
                  <div type="button" data-toggle="dropdown" aria-expanded="false">
                    <span class="pull-left"><span class="num-items">2</span> item(s)</span>
                    <span class="pull-right" style="margin-left: 1em;"><i class="fa fa-caret-down"></i></span>
                  </div>
                  <ul class="items dropdown-menu" role="menu">
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
                    <li><a href="<?php echo document::href_ilink('checkout'); ?>"><?php echo language::translate('title_total'); ?>: <span class="cart-total-formatted">$957.92</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>