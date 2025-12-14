# My Collections

A lightweight PHP and Tailwind (DaisyUI) web app for organizing, cleaning, and displaying your personal collections such as Blu-rays, CDs, books, or comics. No database required.

This project began as a small tool to turn messy Obsidian HTML exports into something clean and easy to browse. It automatically processes exported files, extracts tables, counts items, and calculates total MSRP values.

## Features

- Automatic HTML cleanup  
  Processes raw Obsidian HTML exports and extracts only the relevant table content.

- Manifest system  
  Keeps track of processed files in a JSON file and rebuilds only when source files change.

- No database required  
  Runs entirely from flat files for simplicity and performance.

- MSRP calculation  
  Reads category prices from a JSON configuration file (prices.json) and totals your collection value.

- Responsive interface  
  Built with Tailwind CSS and DaisyUI, styled for a clean dark mode layout.

- Automatic navigation  
  Lists all available collection files and generates a simple navigation menu.

## Project Structure

```
collections/
├── app/
│   ├── css/
│   ├── fonts/
│   ├── js/
│   └── php/
│       └── engine.php
├── html/
│   ├── processed/        # Auto-generated clean tables
│   └── raw files (.html) # Original Obsidian exports
├── index.php
├── nav.php
├── content.php
├── footer.php
├── prices.json           # MSRP values per category
├── tailwind-input.css
├── LICENSE
└── README.md
```

## How It Works

1. Place your exported HTML files from Obsidian in the html directory.  
2. When you open the site, PHP automatically:
   - Scans all files  
   - Extracts the table content  
   - Saves a cleaned version in html/processed  
   - Updates the manifest.json file  
3. Each processed file is displayed as a simple, readable collection page.  
4. MSRP totals are calculated from prices.json and displayed in the footer.

## Example prices.json

```json
{
  "Arkas":   { "label": "Arkas Collection", "MSRP": 10 },
  "Blu-Ray": { "label": "Blu-Rays", "MSRP": 15 },
  "Books":   { "label": "Books", "MSRP": 20 },
  "CDs":     { "label": "CDs", "MSRP": 15 }
}
```

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/tomgineer/collections.git
   cd collections
   ```
2. Make sure PHP 8.1 or higher is installed.
3. Run a local PHP server:
   ```bash
   php -S localhost:8000
   ```
4. Open your browser and visit:
   ```
   http://localhost:8000
   ```

## Requirements

- PHP 8.1 or newer  
- No database  
- Tailwind CSS and DaisyUI included  

## License

This project is licensed under the MIT License. See the LICENSE file for details.
