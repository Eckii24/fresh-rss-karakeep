# Installation Guide

## Prerequisites

Before installing this extension, ensure you have:

- FreshRSS 1.20.0 or later installed and running
- Access to your FreshRSS server's file system
- A Karakeep instance (self-hosted or cloud)
- A Karakeep API token

## Step 1: Install the Extension

Choose one of the following methods:

### Option A: Using Git (Recommended)

```bash
# Navigate to FreshRSS extensions directory
cd /path/to/FreshRSS/extensions

# Clone the repository
git clone https://github.com/Eckii24/fresh-rss-karakeep.git Karakeep
```

### Option B: Manual Installation

1. Download the latest release from GitHub
2. Extract the archive
3. Rename the extracted folder to `Karakeep`
4. Upload the folder to your FreshRSS extensions directory: `/path/to/FreshRSS/extensions/Karakeep`

### Option C: Using FreshRSS Web Interface (if available)

1. Log in to FreshRSS
2. Navigate to **Settings → Extensions**
3. Click **Add extension from Git**
4. Enter: `https://github.com/Eckii24/fresh-rss-karakeep.git`
5. Click **Submit**

## Step 2: Enable the Extension

1. In FreshRSS, go to **Settings → Extensions**
2. Find **Karakeep** in the extensions list
3. Click the **Enable** button

## Step 3: Configure Karakeep Settings

1. Click the ⚙️ (gear) icon next to the Karakeep extension
2. Fill in the configuration:
   - **Karakeep URL**: Your Karakeep instance URL
     - For cloud: `https://try.karakeep.app`
     - For self-hosted: `https://your-domain.com` (no trailing slash)
   - **Karakeep API Token**: Your API token from Karakeep
3. Click **Save Configuration**

## Step 4: Get Your Karakeep API Token

1. Open your Karakeep instance
2. Log in to your account
3. Go to **Settings** or **Account**
4. Find the **API** or **Integrations** section
5. Click **Generate New Token** or **Create API Token**
6. Copy the generated token
7. Paste it into the FreshRSS Karakeep extension configuration

## Step 5: Verify Installation

1. Go to your FreshRSS feed view
2. Open any article
3. You should see an "🔖 Add to Karakeep" button at the top of the article
4. Click it to test - it should save the article to Karakeep

## Troubleshooting

### Extension doesn't appear in the list
- Verify the folder is named exactly `Karakeep` (case-sensitive)
- Check file permissions: `chmod -R 755 /path/to/FreshRSS/extensions/Karakeep`
- Refresh the FreshRSS extensions page

### Button doesn't appear on articles
- Make sure the extension is enabled
- Clear browser cache and reload
- Check browser console (F12) for JavaScript errors

### API errors when clicking the button
- Verify your Karakeep URL is correct (no trailing slash)
- Check that your API token is valid and hasn't expired
- Ensure your FreshRSS server can reach your Karakeep instance
- Check Karakeep API logs if you're self-hosting

### Permission denied errors
- Ensure the web server has read access to all extension files
- Set appropriate permissions: `chown -R www-data:www-data /path/to/FreshRSS/extensions/Karakeep`

## Updating the Extension

### If installed via Git:

```bash
cd /path/to/FreshRSS/extensions/Karakeep
git pull origin main
```

### If installed manually:
1. Download the latest release
2. Back up your current installation
3. Replace the files with the new version
4. Your configuration will be preserved

## Uninstalling

1. In FreshRSS, go to **Settings → Extensions**
2. Find **Karakeep** and click **Disable**
3. Optionally, delete the extension folder:
   ```bash
   rm -rf /path/to/FreshRSS/extensions/Karakeep
   ```

## Support

If you encounter issues:
1. Check the troubleshooting section above
2. Review the [README.md](README.md)
3. Open an issue on GitHub: https://github.com/Eckii24/fresh-rss-karakeep/issues
