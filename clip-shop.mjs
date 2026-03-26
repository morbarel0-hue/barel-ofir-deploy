import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il/shop/', { waitUntil: 'networkidle2', timeout: 30000 });

// Get the ul.products element
const ul = await page.$('ul.products');
if (ul) {
  const box = await ul.boundingBox();
  console.log('ul.products box:', JSON.stringify(box));
  await page.screenshot({ path: 'temporary screenshots/shop-products-grid.png', clip: { x: 0, y: box.y - 20, width: 1440, height: Math.min(box.height, 600) } });
}

// Check column count from computed style
const cols = await page.evaluate(() => {
  const ul = document.querySelector('ul.products');
  if (!ul) return 'not found';
  const style = window.getComputedStyle(ul);
  return {
    display: style.display,
    gridTemplateColumns: style.gridTemplateColumns,
    className: ul.className,
    childCount: ul.children.length
  };
});
console.log('Grid info:', JSON.stringify(cols, null, 2));

await browser.close();
