import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const info = await page.evaluate(() => {
  const sale = document.querySelector('section.section--sale');
  const items = sale.querySelectorAll('li.product');
  const result = [];
  items.forEach((item, i) => {
    const box = item.getBoundingClientRect();
    result.push({ i, x: Math.round(box.x), y: Math.round(box.y), w: Math.round(box.width), h: Math.round(box.height) });
  });
  return result;
});
console.log('Product positions:', JSON.stringify(info, null, 2));
await browser.close();
