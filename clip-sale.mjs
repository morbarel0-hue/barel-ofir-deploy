import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const sale = await page.$('section.section--sale');
if (sale) {
  const box = await sale.boundingBox();
  await page.screenshot({ path: 'temporary screenshots/section-sale.png', clip: { x: 0, y: box.y - 10, width: 1440, height: Math.min(box.height + 20, 700) } });
  const count = await sale.$$eval('li.product', els => els.length);
  console.log('Sale section found, products:', count, 'height:', box.height);
} else {
  console.log('Sale section not found');
}

await browser.close();
