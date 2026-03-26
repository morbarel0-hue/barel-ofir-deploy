import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });

const pages = [
  { url: 'https://barelofir.co.il/shop/', label: 'shop' },
  { url: 'https://barelofir.co.il/product/מקדח-hss-טיטניום-2-0-מ-מ-2-יח-בבליסטר-the-hardware-company/', label: 'single-product' },
  { url: 'https://barelofir.co.il/product-category/כלי-עבודה/', label: 'category' },
  { url: 'https://barelofir.co.il/cart/', label: 'cart' },
];

for (const { url, label } of pages) {
  try {
    await page.goto(url, { waitUntil: 'networkidle2', timeout: 25000 });
    await page.screenshot({ path: `temporary screenshots/page-${label}.png`, fullPage: false });
    console.log(`${label}: done`);
  } catch(e) {
    console.log(`${label}: error - ${e.message}`);
  }
}

await browser.close();
