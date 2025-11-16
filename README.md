# FreshRSS Karakeep Extension

This extension adds Karakeep integration to FreshRSS, allowing you to save articles directly to your Karakeep bookmark manager with a single click.

## Features

- 🔖 Add articles to Karakeep with one click
- ✅ Automatic bookmark creation with article URL and title
- 🔄 Visual feedback on success/error states
- 🌙 Full dark mode support
- 🔒 Secure API token storage

## Requirements

- FreshRSS 1.20.0 or later
- A Karakeep instance (self-hosted or https://try.karakeep.app)
- Karakeep API token

## Installation

### Method 1: Git Clone

1. Navigate to your FreshRSS extensions directory:
   ```bash
   cd /path/to/FreshRSS/extensions
   ```

2. Clone this repository:
   ```bash
   git clone https://github.com/Eckii24/fresh-rss-karakeep.git Karakeep
   ```

### Method 2: Manual Download

1. Download the latest release
2. Extract the archive
3. Rename the folder to `Karakeep`
4. Move it to your FreshRSS extensions directory: `/path/to/FreshRSS/extensions/`

### Method 3: FreshRSS Extension Manager

1. In FreshRSS, go to Settings → Extensions
2. Click on "Add extension from Git"
3. Enter the repository URL: `https://github.com/Eckii24/fresh-rss-karakeep.git`

## Configuration

1. In FreshRSS, go to **Settings → Extensions**
2. Find **Karakeep** in the list and enable it
3. Click on the ⚙️ (gear) icon to configure:
   - **Karakeep URL**: Enter your Karakeep instance URL (e.g., `https://try.karakeep.app` or your self-hosted URL)
   - **Karakeep API Token**: Generate an API token from your Karakeep account settings and paste it here
4. Click **Save Configuration**

## Usage

1. Browse your RSS feeds in FreshRSS
2. When viewing an article, you'll see an "🔖 Add to Karakeep" button at the top
3. Click the button to save the article to Karakeep
4. The article will be:
   - Saved as a bookmark in Karakeep with the article's URL and title
   - Marked as read in FreshRSS
   - The button will show a success message with the bookmark ID

## Getting a Karakeep API Token

1. Log in to your Karakeep instance
2. Go to your account settings
3. Navigate to the API section
4. Generate a new API token
5. Copy the token and paste it in the FreshRSS extension configuration

## Troubleshooting

### "Missing Karakeep configuration" error
- Make sure you've configured both the Karakeep URL and API token in the extension settings

### "Karakeep API Error" messages
- Verify your API token is correct and hasn't expired
- Check that your Karakeep instance URL is correct (no trailing slash)
- Ensure your Karakeep instance is accessible from your FreshRSS server

### Button not appearing
- Make sure the extension is enabled in FreshRSS settings
- Clear your browser cache
- Check browser console for JavaScript errors

## Development

This extension follows the FreshRSS extension structure:

- `extension.php` - Main extension class
- `Controllers/KarakeepController.php` - API interaction controller
- `configure.phtml` - Configuration UI
- `static/script.js` - JavaScript for button functionality
- `static/style.css` - CSS styles
- `metadata.json` - Extension metadata

## License

MIT License - See LICENSE file for details

## Credits

Inspired by [fresh-rss-notion](https://github.com/Eckii24/fresh-rss-notion)
