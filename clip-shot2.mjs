import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });

// Screenshot shop page top
await page.goto('https://barelofir.co.il/shop/', { waitUntil: 'networkidle2', timeout: 30000 });
await page.screenshot({ path: 'temporary screenshots/shop-top.png', clip: { x: 0, y: 0, width: 1440, height: 900 } });
console.log('shop top done');

// Screenshot a single product
const links = await page.$$('li.product a.woocommerce-loop-product__link');
if (links.length > 0) {
  const href = await page.evaluate(el => el.href, links[0]);
  console.log('First product:', href);
  await page.goto(href, { waitUntil: 'networkidle2', timeout: 30000 });
  await page.screenshot({ path: 'temporary screenshots/single-product.png', fullPage: false });
  console.log('single product done');
}

await browser.close();
