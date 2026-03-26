import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const info = await page.evaluate(() => {
  const sale = document.querySelector('section.section--sale');
  const ul = sale.querySelector('ul.products');
  const first = ul.children[0];
  const style = window.getComputedStyle(first);
  return {
    gridColumn: style.gridColumn,
    gridRow: style.gridRow,
    gridColumnStart: style.gridColumnStart,
    gridColumnEnd: style.gridColumnEnd,
    float: style.float,
    clear: style.clear,
    width: style.width,
    marginLeft: style.marginLeft,
    marginRight: style.marginRight,
    // ul computed style
    ulDir: window.getComputedStyle(ul).direction
  };
});
console.log(JSON.stringify(info, null, 2));
await browser.close();
