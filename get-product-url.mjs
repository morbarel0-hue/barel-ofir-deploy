import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il/shop/', { waitUntil: 'networkidle2', timeout: 30000 });

// Get product URLs and grid info
const info = await page.evaluate(() => {
  const links = Array.from(document.querySelectorAll('li.product a.woocommerce-loop-product__link'));
  const ul = document.querySelector('ul.products');
  const style = ul ? window.getComputedStyle(ul) : {};
  return {
    productUrls: links.slice(0, 5).map(a => a.href),
    gridCols: style.gridTemplateColumns,
    colCount: links.length
  };
});
console.log(JSON.stringify(info, null, 2));
await browser.close();
