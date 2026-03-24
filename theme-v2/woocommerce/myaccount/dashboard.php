<?php
/**
 * My Account Dashboard - Barel Ofir v2 Custom
 */
defined("ABSPATH") || exit;

$current_user = wp_get_current_user();
$orders = wc_get_orders(["customer"=>get_current_user_id(),"limit"=>5,"orderby"=>"date","order"=>"DESC"]);
?>

<p style="font-size:15px;color:#444;margin-bottom:20px">
שלום <strong><?php echo esc_html($current_user->display_name); ?></strong>, ברוך השב!
</p>

<?php if ($orders): ?>
<div style="margin-bottom:24px">
  <div style="font-size:14px;font-weight:700;color:#111;margin-bottom:12px">הזמנות אחרונות</div>
  <table style="width:100%;border-collapse:collapse;font-size:13px">
    <thead>
      <tr>
        <th style="text-align:right;padding:8px 12px;font-size:11px;font-weight:800;color:#777;text-transform:uppercase;background:#fafafa;border-bottom:1px solid #e5e5e5">הזמנה</th>
        <th style="text-align:right;padding:8px 12px;font-size:11px;font-weight:800;color:#777;text-transform:uppercase;background:#fafafa;border-bottom:1px solid #e5e5e5">תאריך</th>
        <th style="text-align:right;padding:8px 12px;font-size:11px;font-weight:800;color:#777;text-transform:uppercase;background:#fafafa;border-bottom:1px solid #e5e5e5">סטטוס</th>
        <th style="text-align:right;padding:8px 12px;font-size:11px;font-weight:800;color:#777;text-transform:uppercase;background:#fafafa;border-bottom:1px solid #e5e5e5">סכום</th>
        <th style="text-align:right;padding:8px 12px;font-size:11px;font-weight:800;color:#777;text-transform:uppercase;background:#fafafa;border-bottom:1px solid #e5e5e5">פעולה</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $status_labels = ["wc-pending"=>"ממתין","wc-processing"=>"בטיפול","wc-on-hold"=>"בהמתנה","wc-completed"=>"הושלם","wc-cancelled"=>"בוטל","wc-refunded"=>"הוחזר","wc-failed"=>"נכשל"];
    $status_colors = ["wc-pending"=>"#fff8e1;color:#f57c00","wc-processing"=>"#e3f2fd;color:#1565c0","wc-on-hold"=>"#fff3e0;color:#e65c00","wc-completed"=>"#e8f5e9;color:#1a7a3a","wc-cancelled"=>"#ffebee;color:#c62828","wc-refunded"=>"#f3e5f5;color:#6a1b9a","wc-failed"=>"#ffebee;color:#c62828"];
    foreach ($orders as $order):
      $status = "wc-" . $order->get_status();
      $status_label = $status_labels[$status] ?? $order->get_status();
      $bg = $status_colors[$status] ?? "#f4f4f4;color:#444";
    ?>
    <tr style="border-bottom:1px solid #f0f0f0">
      <td style="padding:12px"><a href="<?php echo esc_url($order->get_view_order_url()); ?>" style="color:#c0001a;font-weight:700">#<?php echo $order->get_order_number(); ?></a></td>
      <td style="padding:12px;color:#444"><?php echo date_i18n("d/m/Y", strtotime($order->get_date_created())); ?></td>
      <td style="padding:12px"><span style="display:inline-block;padding:3px 10px;border-radius:999px;font-size:11px;font-weight:700;background:<?php echo $bg; ?>"><?php echo esc_html($status_label); ?></span></td>
      <td style="padding:12px;font-weight:700"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></td>
      <td style="padding:12px"><a href="<?php echo esc_url($order->get_view_order_url()); ?>" style="font-size:12px;font-weight:700;color:#c0001a">צפה</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <div style="text-align:left;margin-top:12px"><a href="<?php echo esc_url(wc_get_account_endpoint_url("orders")); ?>" style="font-size:13px;color:#c0001a;font-weight:700">כל ההזמנות ←</a></div>
</div>
<?php else: ?>
<div style="text-align:center;padding:40px 20px;color:#777">
  <div style="font-size:48px;margin-bottom:12px">📦</div>
  <p>אין הזמנות עדיין. <a href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>" style="color:#c0001a;font-weight:700">לחנות →</a></p>
</div>
<?php endif; ?>
