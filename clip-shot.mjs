import puppeteer from 'puppeteer';
import fs from 'fs';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });

const clips = [
  { name: 'cats', selector: 'section.section--cats' },
  { name: 'featured', selector: 'section.section--featured' },
  { name: 'new-arrivals', selector: 'section.section--new' },
  { name: 'why', selector: 'section.section--why' },
];

for (const { name, selector } of clips) {
  const el = await page.$(selector);
  if (el) {
    const box = await el.boundingBox();
    if (box) {
      await page.screenshot({
        path: `temporary screenshots/section-${name}.png`,
        clip: { x: 0, y: Math.max(0, box.y - 10), width: 1440, height: Math.min(box.height + 20, 800) }
      });
      console.log(`${name}: ${Math.round(box.width)}x${Math.round(box.height)}`);
    }
  } else {
    console.log(`${name}: not found`);
  }
}

await browser.close();
