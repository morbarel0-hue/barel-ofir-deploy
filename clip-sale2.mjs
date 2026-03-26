import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const sale = await page.$('section.section--sale');
const box = await sale.boundingBox();
console.log('Sale section box:', JSON.stringify(box));

// Full height screenshot
await page.screenshot({ 
  path: 'temporary screenshots/section-sale-full.png', 
  clip: { x: 0, y: box.y, width: 1440, height: box.height }
});
console.log('done, height:', box.height);
await browser.close();
