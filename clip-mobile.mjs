import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 390, height: 844 });
await page.goto('https://barelofir.co.il', { waitUntil: 'networkidle2', timeout: 30000 });
await page.screenshot({ path: 'temporary screenshots/mobile-homepage.png', fullPage: true });
console.log('mobile screenshot done');
await browser.close();
