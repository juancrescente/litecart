<?php

  document::$snippets['head_tags']['chartist'] = '<link rel="stylesheet" href="'. WS_DIR_EXT .'chartist/chartist.min.css" />';
  document::$snippets['foot_tags']['chartist'] = '<script src="'. WS_DIR_EXT .'chartist/chartist.min.js"></script>';

  $widget_sales_cache_id = cache::cache_id('widget_sales');
  if (cache::capture($widget_sales_cache_id, 'file', 300)) {

  $order_statuses = array();
  $orders_status_query = database::query(
    "select id from ". DB_TABLE_ORDER_STATUSES ." where is_sale;"
  );
  while ($order_status = database::fetch($orders_status_query)) {
    $order_statuses[] = (int)$order_status['id'];
  }
?>
<div class="row">
  <div class="widget col-md-5">
<?php
  $monthly_sales = array();
  $monthly_tax = array();
  for ($timestamp = strtotime('-11 months'); date('Y-m', $timestamp) <= date('Y-m'); $timestamp = strtotime('+1 month', $timestamp)) {

    $orders_query = database::query(
      "select sum(payment_due - tax_total) as total_sales from ". DB_TABLE_ORDERS ."
      where order_status_id in ('". implode("', '", $order_statuses) ."')
      and date_created >= '". date('Y-m-d H:i:s', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp))) ."'
      and date_created <= '". date('Y-m-d H:i:s', mktime(23, 59, 59, date('m', $timestamp), date('t', $timestamp), date('Y', $timestamp))) ."';"
    );
    $orders = database::fetch($orders_query);

    $monthly_sales[date('Y-m', $timestamp)] = (int)$orders['total_sales'];
    }
?>
    <div id="chart-sales-monthly" style="height: 250px;" title="<?php echo language::translate('title_monthly_sales', 'Monthly Sales'); ?>"></div>
    <script>
      var data = {
        labels: <?php echo json_encode(array_keys($monthly_sales)); ?>,
        series: <?php echo json_encode(array(array_values($monthly_sales))); ?>
      };

      var options = {
        seriesBarDistance: 10,
        showArea: true,
        lineSmooth: true
      };

      var responsiveOptions = [
        ['screen and (max-width: 640px)', {
          seriesBarDistance: 5,
          axisX: {
            labelInterpolationFnc: function (value) {
              return value[0];
            }
          }
        }]
      ];

      new Chartist.Line('#chart-sales-monthly', data, options, responsiveOptions);
    </script>
  </div>

  <div class="widget col-md-5">
<?php
    $daily_sales = array();
  for ($timestamp = strtotime('-29 days'); date('Y-m-d', $timestamp) <= date('Y-m-d'); $timestamp = strtotime('+1 day', $timestamp)) {

    $orders_query = database::query(
      "select sum(payment_due - tax_total) as total_sales, tax_total as total_tax from ". DB_TABLE_ORDERS ."
      where order_status_id in ('". implode("', '", $order_statuses) ."')
      and date_created >= '". date('Y-m-d H:i:s', mktime(0, 0, 0, date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp))) ."'
      and date_created <= '". date('Y-m-d H:i:s', mktime(23, 59, 59, date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp))) ."';"
    );
    $orders = database::fetch($orders_query);

    $daily_sales[date('d', $timestamp)] = (int)$orders['total_sales'];
    }
?>
    <div id="chart-sales-daily" style="height: 250px" title="<?php echo language::translate('title_daily_sales', 'Daily Sales'); ?>"></div>
    <script>
      var data = {
        labels: <?php echo json_encode(array_keys($daily_sales)); ?>,
        series: <?php echo json_encode(array(array_values($daily_sales))); ?>
      };

      var options = {
        seriesBarDistance: 10
      };

      var responsiveOptions = [
        ['screen and (max-width: 640px)', {
          seriesBarDistance: 5,
          axisX: {
            labelInterpolationFnc: function (value) {
              return value[0];
            }
          }
        }]
      ];

      new Chartist.Bar('#chart-sales-daily', data, options, responsiveOptions);
    </script>
  </div>

  <div class="widget col-md-2">
<?php
    $orders_query = database::query(
      "select avg(payment_due - tax_total) as total_sales, tax_total as total_tax, weekday(date_created) as weekday from ". DB_TABLE_ORDERS ."
      where order_status_id in ('". implode("', '", $order_statuses) ."')
      group by weekday(date_created);"
    );

    if (!function_exists('mb_ucfirst')) {
      function mb_ucfirst($str) {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
      }
    }

    $weekday = array(
      '0' => ucfirst(language::strftime('%A', strtotime('Monday'))),
      '1' => ucfirst(language::strftime('%A', strtotime('Tuesday'))),
      '2' => ucfirst(language::strftime('%A', strtotime('Wednesday'))),
      '3' => ucfirst(language::strftime('%A', strtotime('Thursday'))),
      '4' => ucfirst(language::strftime('%A', strtotime('Friday'))),
      '5' => ucfirst(language::strftime('%A', strtotime('Saturday'))),
      '6' => ucfirst(language::strftime('%A', strtotime('Sunday'))),
    );

    $weekday_sales = array_combine(array_values($weekday), array(0,0,0,0,0,0,0));
    while($order = database::fetch($orders_query)) {
      $weekday_sales[$weekday[$order['weekday']]] = (float)$order['total_sales'];
    }

?>
    <div id="chart-sales-weekday" style="height: 200px; margin: 25px 0;" title="<?php echo language::translate('title_sales_by_weekday', 'Sales by Weekday'); ?>"></div>
    <script>
      var data = {
        labels: <?php echo json_encode(array_keys($weekday_sales)); ?>,
        series: <?php echo json_encode(array_values($weekday_sales)); ?>
      };

      var options = {
        donut: true,
        donutWidth: 25,
        labelInterpolationFnc: function(value) {
          return value[0]
        }
      };

      var responsiveOptions = [
        ['screen and (min-width: 640px)', {
          chartPadding: 30,
          labelOffset: 100,
          labelDirection: 'explode',
          labelInterpolationFnc: function(value) {
            return value;
          }
        }],
        ['screen and (min-width: 1024px)', {
          labelOffset: 80,
          chartPadding: 20
        }]
      ];

      new Chartist.Pie('#chart-sales-weekday', data, options);
    </script>
  </div>
</div>
<?php
    cache::end_capture($widget_sales_cache_id);
  }
?>