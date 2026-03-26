import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const info = await page.evaluate(() => {
  const sale = document.querySelector('section.section--sale');
  if (!sale) return 'sale section not found';
  const ul = sale.querySelector('ul.products');
  if (!ul) return 'ul not found';
  const style = window.getComputedStyle(ul);
  return {
    className: ul.className,
    gridCols: style.gridTemplateColumns,
    width: ul.getBoundingClientRect().width,
    productCount: ul.children.length
  };
});
console.log(JSON.stringify(info, null, 2));
await browser.close();
