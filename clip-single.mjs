import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il/product/%d7%9e%d7%a7%d7%93%d7%97-hss-%d7%98%d7%99%d7%98%d7%a0%d7%99%d7%95%d7%9d-2-0-%d7%9e%d7%9e-2-%d7%99%d7%97-%d7%91%d7%91%d7%9c%d7%99%d7%a1%d7%98%d7%a8-the-hardware-company/', { waitUntil: 'networkidle2', timeout: 30000 });

const info = await page.evaluate(() => {
  const product = document.querySelector('div.product');
  const gallery = document.querySelector('.woocommerce-product-gallery');
  const summary = document.querySelector('.summary');
  const wooMain = document.querySelector('.woo-main');
  
  return {
    productStyle: product ? window.getComputedStyle(product).gridTemplateColumns : 'N/A',
    productWidth: product ? product.getBoundingClientRect().width : 'N/A',
    galleryWidth: gallery ? gallery.getBoundingClientRect().width : 'N/A',
    summaryWidth: summary ? summary.getBoundingClientRect().width : 'N/A',
    wooMainGrid: wooMain ? window.getComputedStyle(wooMain).gridTemplateColumns : 'N/A',
    bodyClass: document.body.className
  };
});
console.log('Single product info:', JSON.stringify(info, null, 2));

await page.screenshot({ path: 'temporary screenshots/single-product-full.png', fullPage: true });
console.log('screenshot done');
await browser.close();
