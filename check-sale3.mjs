import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const info = await page.evaluate(() => {
  const sale = document.querySelector('section.section--sale');
  const ul = sale.querySelector('ul.products');
  const children = Array.from(ul.children);
  return children.map((el, i) => ({
    i,
    tag: el.tagName,
    className: el.className,
    x: Math.round(el.getBoundingClientRect().x),
    y: Math.round(el.getBoundingClientRect().y),
    w: Math.round(el.getBoundingClientRect().width),
    display: window.getComputedStyle(el).display
  }));
});
console.log(JSON.stringify(info, null, 2));
await browser.close();
