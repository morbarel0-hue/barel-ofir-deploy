<?php get_header();
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$is_shop  = function_exists('is_shop') && is_shop();
$queried  = get_queried_object();
$term     = ($queried instanceof WP_Term) ? $queried : null;
$title    = $is_shop ? 'כל הכלים' : ($term ? $term->name : 'מוצרים');
global $wp_query; ?>
<div class="breadcrumb"><div class="breadcrumb-inner">
  <a href="<?php echo esc_url(home_url('/')); ?>">בית</a><span>&rsaquo;</span>
  <?php if ($term): $ancs=get_ancestors($term->term_id,'product_cat'); foreach(array_reverse($ancs) as $ai): $an=get_term($ai,'product_cat'); ?>
    <a href="<?php echo esc_url(get_term_link($an)); ?>"><?php echo esc_html($an->name); ?></a><span>&rsaquo;</span>
  <?php endforeach; endif; ?>
  <strong><?php echo esc_html($title); ?></strong>
</div></div>
<div class="cat-header"><div class="cat-header-inner">
  <div><h1 class="cat-title"><?php echo esc_html($title); ?></h1></div>
  <span class="cat-count"><?php echo $wp_query->found_posts; ?> מוצרים</span>
</div></div>
<?php $subcats=$term?get_terms(['taxonomy'=>'product_cat','parent'=>$term->term_id,'hide_empty'=>true]):get_terms(['taxonomy'=>'product_cat','parent'=>0,'hide_empty'=>true,'number'=>12,'orderby'=>'count','order'=>'DESC']);
if(!is_wp_error($subcats)&&count($subcats)>0): ?>
<div class="subcats-section"><div class="subcats-inner">
  <div class="subcats-label">קטגוריות</div>
  <div class="subcats-row">
  <?php foreach($subcats as $sub): if($sub->slug==='uncategorized') continue;
    $tu=($tid=get_term_meta($sub->term_id,'thumbnail_id',true))?wp_get_attachment_image_url($tid,'thumbnail'):'';
    $act=($term&&$term->term_id===$sub->term_id)?' active':'';
    $sub_emoji_map = ['kley-avoda-hashmaliyim'=>'⚡','kley-avoda-yadaniyim'=>'🔧','kley-ginun-hashmaliyim'=>'🌿','kley-ginun-yadaniyim'=>'🪴','avizarim'=>'🔩','tamboria'=>'🪣','mevragot'=>'🪛','masarim-hashmal'=>'🪚','mekonot-shetifa'=>'💦'];
    $sub_emoji = $sub_emoji_map[$sub->slug] ?? '🔧'; ?>
    <a href="<?php echo esc_url(get_term_link($sub)); ?>" class="subcat-item<?php echo $act; ?>">
      <div class="subcat-img-wrap"><?php if($tu): ?><img src="<?php echo esc_url($tu); ?>" alt="<?php echo esc_attr($sub->name); ?>" loading="lazy" /><?php else: ?><span class="subcat-emoji"><?php echo $sub_emoji; ?></span><?php endif; ?></div>
      <div class="subcat-name"><?php echo esc_html($sub->name); ?></div>
      <div class="subcat-count"><?php echo $sub->count; ?></div>
    </a>
  <?php endforeach; ?>
  </div></div></div>
<?php endif; ?>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
<div class="shop-layout">
<aside class="sidebar" id="sidebar">
  <div class="sidebar-close"><span class="sidebar-close-title">סינון מוצרים</span><button onclick="closeSidebar()">&times;</button></div>
  <div class="filter-group">
    <div class="filter-group-title">סינון לפי מחיר</div>
    <form method="get">
      <?php foreach($_GET as $k=>$v){if($k==='min_price'||$k==='max_price')continue;echo '<input type="hidden" name="'.esc_attr($k).'" value="'.esc_attr($v).'">';} ?>
      <div class="price-inputs">
        <div class="price-input-wrap"><label class="price-label">מינימום</label><div class="price-input-inner"><span class="currency-sign">&#8362;</span><input type="number" name="min_price" class="price-input" value="<?php echo esc_attr($_GET['min_price']??''); ?>" placeholder="0" min="0" /></div></div>
        <div class="price-sep">&ndash;</div>
        <div class="price-input-wrap"><label class="price-label">מקסימום</label><div class="price-input-inner"><span class="currency-sign">&#8362;</span><input type="number" name="max_price" class="price-input" value="<?php echo esc_attr($_GET['max_price']??''); ?>" placeholder="5000" min="0" /></div></div>
      </div>
      <?php $presets=[['עד &#8362;200',0,200],['&#8362;200-500',200,500],['&#8362;500-1000',500,1000],['&#8362;1000+',1000,'']];
      echo '<div class="price-presets">';
      foreach($presets as $p){$u=add_query_arg(['min_price'=>$p[1],'max_price'=>$p[2]]);$ac=(isset($_GET['min_price'])&&$_GET['min_price']==$p[1]&&isset($_GET['max_price'])&&$_GET['max_price']==$p[2])?' active':'';echo '<a href="'.esc_url($u).'" class="price-preset'.$ac.'">'.$p[0].'</a>';}
      echo '</div>'; ?>
      <button type="submit" class="price-apply-btn">החל סינון</button>
    </form>
  </div>
  <div class="filter-group"><div class="filter-group-title">מיון</div><div class="sort-options">
    <?php $sorts=[''=>'מומלצים','popularity'=>'פופולריים','price'=>'מחיר עולה','price-desc'=>'מחיר יורד','date'=>'חדש','rating'=>'דירוג גבוה'];
    $curr=$_GET['orderby']??'';
    foreach($sorts as $v=>$l){$u=$v?add_query_arg('orderby',$v):remove_query_arg('orderby');$ac=($curr===$v)?' active':'';echo '<a href="'.esc_url($u).'" class="sort-btn'.$ac.'">'.esc_html($l).'</a>';}?>
  </div></div>
  <?php $tc=get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'number'=>12,'orderby'=>'count','order'=>'DESC']);
  if(!is_wp_error($tc)&&count($tc)): ?>
  <div class="filter-group"><div class="filter-group-title">קטגוריות</div><div class="filter-cats">
    <a href="<?php echo esc_url($shop_url); ?>" class="filter-cat<?php echo $is_shop?' active':''; ?>">כל הכלים</a>
    <?php foreach($tc as $fc):if($fc->slug==='uncategorized')continue;$fa=($term&&$term->term_id===$fc->term_id)?' active':''; ?>
    <a href="<?php echo esc_url(get_term_link($fc)); ?>" class="filter-cat<?php echo $fa; ?>"><?php echo esc_html($fc->name); ?> <span>(<?php echo $fc->count; ?>)</span></a>
    <?php endforeach; ?>
  </div></div>
  <?php endif; ?>
</aside>
<div class="products-main">
  <div class="mobile-toolbar">
    <button class="filter-toggle-btn" onclick="openSidebar()">&#128269; סינון</button>
    <select class="mobile-sort" onchange="window.location=this.value">
      <?php foreach($sorts as $v=>$l){$u=$v?add_query_arg('orderby',$v):remove_query_arg('orderby');$sel=($curr===$v)?' selected':'';echo '<option value="'.esc_url($u).'"'.$sel.'>'.esc_html($l).'</option>';} ?>
    </select>
  </div>
  <?php if(have_posts()): ?>
    <div class="products-grid" id="productsGrid">
      <?php while(have_posts()):the_post();barel_render_product_card(get_the_ID());endwhile; ?>
    </div>
    <div id="infiniteScrollSentinel" style="height:1px;"></div>
    <div id="infiniteSpinner" class="infinite-spinner" style="display:none;"><div class="spinner-ring"></div></div>
  <?php else: ?>
    <div class="no-products"><div class="no-products-icon">&#128269;</div><h2>לא נמצאו מוצרים</h2><a href="<?php echo esc_url($shop_url); ?>" class="btn-primary">לכל המוצרים</a></div>
  <?php endif; ?>
</div></div>
<?php if($term&&$term->description): ?>
<div class="cat-description-bottom">
  <div class="seo-box"><?php echo wp_kses_post($term->description); ?></div>
</div>
<?php endif; ?>
<script>
function openSidebar(){document.getElementById('sidebar').classList.add('open');document.getElementById('sidebarOverlay').classList.add('show');document.body.style.overflow='hidden';}
function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sidebarOverlay').classList.remove('show');document.body.style.overflow='';}
</script>
<?php get_footer(); ?>
