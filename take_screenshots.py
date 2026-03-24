from playwright.sync_api import sync_playwright
import os, glob

DESKTOP_DIR = r'screenshots/desktop'
MOBILE_DIR = r'screenshots/mobile'
ORIGINAL_DIR = r'screenshots/original'

os.makedirs(DESKTOP_DIR, exist_ok=True)
os.makedirs(MOBILE_DIR, exist_ok=True)
os.makedirs(ORIGINAL_DIR, exist_ok=True)

pages_to_check = [
    ('homepage', 'https://barelofir.co.il/'),
    ('shop', 'https://barelofir.co.il/shop/'),
    ('category', 'https://barelofir.co.il/product-category/%d7%9b%d7%9c%d7%99-%d7%a2%d7%91%d7%95%d7%93%d7%94-%d7%97%d7%a9%d7%9e%d7%9c%d7%99%d7%99%d7%9d/'),
    ('cart', 'https://barelofir.co.il/cart/'),
    ('checkout', 'https://barelofir.co.il/checkout/'),
    ('myaccount', 'https://barelofir.co.il/my-account/'),
]

html_files = glob.glob(r'C:\Users\morba\Downloads\barel-files\*.html')

with sync_playwright() as p:
    # Desktop screenshots of live site
    browser = p.chromium.launch()
    page = browser.new_page(viewport={'width': 1280, 'height': 900})
    for name, url in pages_to_check:
        try:
            page.goto(url, wait_until='networkidle', timeout=20000)
            page.screenshot(path=f'{DESKTOP_DIR}/{name}.png', full_page=True)
            print(f'OK Desktop: {name}')
        except Exception as e:
            print(f'ERR {name}: {e}')
    browser.close()

    # Mobile screenshots of live site
    browser = p.chromium.launch()
    iphone = p.devices['iPhone 13']
    context = browser.new_context(**iphone)
    page = context.new_page()
    for name, url in pages_to_check:
        try:
            page.goto(url, wait_until='networkidle', timeout=20000)
            page.screenshot(path=f'{MOBILE_DIR}/{name}.png', full_page=True)
            print(f'OK Mobile: {name}')
        except Exception as e:
            print(f'ERR Mobile {name}: {e}')
    browser.close()

    # Original HTML files
    browser = p.chromium.launch()
    page = browser.new_page(viewport={'width': 1280, 'height': 900})
    for f in html_files:
        name = os.path.basename(f).replace('.html', '')
        try:
            page.goto('file:///' + f.replace('\\', '/'), wait_until='networkidle', timeout=15000)
            page.screenshot(path=f'{ORIGINAL_DIR}/{name}.png', full_page=True)
            print(f'OK Original: {name}')
        except Exception as e:
            print(f'ERR Original {name}: {e}')
    browser.close()

print('Done!')
