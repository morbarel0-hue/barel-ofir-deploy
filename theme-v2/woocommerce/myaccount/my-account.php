<?php
/**
 * My Account page - Custom Barel Ofir v2 Template
 *
 * @package barel-v2
 */
defined("ABSPATH") || exit;

$current_user = wp_get_current_user();
$user_registered = date_i18n("Y", strtotime($current_user->user_registered));

// Get order count and total
$customer_orders = wc_get_orders(["customer" => get_current_user_id(), "limit" => -1, "return" => "ids"]);
$order_count = count($customer_orders);
$total_spent = wc_price(wc_get_customer_total_spent(get_current_user_id()));

// Wishlist count
$wishlist = WC()->session ? (WC()->session->get("barel_wishlist") ?: []) : [];
$wish_count = count($wishlist);
?>

<style>
.account-wrap{max-width:1280px;margin:28px auto 56px;padding:0 20px;display:grid;grid-template-columns:260px 1fr;gap:24px;align-items:start;direction:rtl}
.account-sidebar{}
.user-card{background:#fff;border:1.5px solid #e5e5e5;border-radius:14px;padding:24px;text-align:center;margin-bottom:16px;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.user-avatar{width:72px;height:72px;background:#fff5f5;border:3px solid #c0001a;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 12px}
.user-name{font-family:"Rubik",sans-serif;font-weight:800;font-size:17px;color:#111;margin-bottom:2px}
.user-email{font-size:12px;color:#777;margin-bottom:12px}
.user-since{font-size:11px;color:#777;background:#f4f4f4;border-radius:999px;padding:3px 10px;display:inline-block}
.account-nav{background:#fff;border:1.5px solid #e5e5e5;border-radius:14px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.account-nav-item{display:flex;align-items:center;gap:12px;padding:14px 18px;font-size:14px;font-weight:600;color:#444;border-bottom:1px solid #e5e5e5;text-decoration:none;transition:all .2s}
.account-nav-item:last-child{border-bottom:none}
.account-nav-item:hover{background:#fafafa;color:#c0001a}
.account-nav-item.active{background:#fff5f5;color:#c0001a;border-right:3px solid #c0001a}
.account-nav-item .nav-icon{font-size:18px;flex-shrink:0}
.dashboard-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px}
.stat-card{background:#fff;border:1.5px solid #e5e5e5;border-radius:14px;padding:20px;text-align:center;transition:border-color .2s,transform .2s;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.stat-card:hover{border-color:#c0001a;transform:translateY(-2px)}
.stat-icon{font-size:32px;margin-bottom:8px}
.stat-num{font-family:"Rubik",sans-serif;font-weight:900;font-size:28px;color:#111}
.stat-num .red{color:#c0001a}
.stat-label{font-size:12px;color:#777;margin-top:2px}
.content-box{background:#fff;border:1.5px solid #e5e5e5;border-radius:14px;overflow:visible;margin-bottom:20px;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.content-box-head{padding:16px 20px;border-bottom:1px solid #e5e5e5;display:flex;align-items:center;justify-content:space-between}
.content-box-title{font-family:"Rubik",sans-serif;font-weight:800;font-size:16px;color:#111;display:flex;align-items:center;gap:8px}
.content-box-title::before{content:"";display:block;width:4px;height:18px;background:#c0001a;border-radius:2px}
.content-box-link{font-size:13px;font-weight:700;color:#c0001a;text-decoration:none}
.content-box-body{padding:20px}
@media(max-width:900px){.account-wrap{grid-template-columns:1fr;gap:16px}.dashboard-stats{grid-template-columns:1fr 1fr}}
@media(max-width:600px){.dashboard-stats{grid-template-columns:1fr}.account-nav{display:flex;overflow-x:auto;border-radius:10px}.account-nav-item{white-space:nowrap;border-bottom:none;border-left:1px solid #e5e5e5}.account-nav-item:last-child{border-left:none}.account-nav-item.active{border-right:none;border-bottom:3px solid #c0001a}}
</style>

<div class="account-wrap">
  <!-- SIDEBAR -->
  <aside class="account-sidebar">
    <div class="user-card">
      <div class="user-avatar">👤</div>
      <div class="user-name"><?php echo esc_html($current_user->display_name); ?></div>
      <div class="user-email"><?php echo esc_html($current_user->user_email); ?></div>
      <div class="user-since">לקוח מאז <?php echo esc_html($user_registered); ?></div>
    </div>
    <nav class="account-nav">
      <?php foreach (wc_get_account_menu_items() as $endpoint => $label):
        $icons = ["dashboard"=>"🏠","orders"=>"📦","edit-address"=>"📍","edit-account"=>"⚙️","customer-logout"=>"🚪"];
        $icon = $icons[$endpoint] ?? "📋";
        $classes = wc_get_account_menu_item_classes($endpoint);
        $is_active = strpos($classes, "is-active") !== false;
      ?>
      <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="account-nav-item<?php echo $is_active ? " active" : ""; ?>">
        <span class="nav-icon"><?php echo $icon; ?></span>
        <span><?php echo esc_html($label); ?></span>
      </a>
      <?php endforeach; ?>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="account-content">
    <?php if (is_wc_endpoint_url("dashboard") || (!is_wc_endpoint_url("orders") && !is_wc_endpoint_url("edit-address") && !is_wc_endpoint_url("edit-account") && !is_wc_endpoint_url("view-order"))): ?>
    <!-- STATS ROW -->
    <div class="dashboard-stats">
      <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-num"><?php echo esc_html($order_count); ?></div>
        <div class="stat-label">הזמנות סה"כ</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-num" style="font-size:20px"><?php echo $total_spent; ?></div>
        <div class="stat-label">סכום כולל</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">❤️</div>
        <div class="stat-num"><?php echo esc_html($wish_count); ?></div>
        <div class="stat-label">מועדפים</div>
      </div>
    </div>
    <?php endif; ?>

    <div class="content-box">
      <div class="content-box-head">
        <div class="content-box-title">
          <?php
          $section_titles = ["dashboard"=>"לוח בקרה","orders"=>"ההזמנות שלי","edit-address"=>"כתובות","edit-account"=>"הגדרות חשבון"];
          $current = "dashboard";
          foreach (array_keys($section_titles) as $ep) { if (is_wc_endpoint_url($ep)) { $current = $ep; break; } }
          echo esc_html($section_titles[$current] ?? "החשבון שלי");
          ?>
        </div>
      </div>
      <div class="content-box-body">
        <?php do_action("woocommerce_account_content"); ?>
      </div>
    </div>
  </div>
</div>
