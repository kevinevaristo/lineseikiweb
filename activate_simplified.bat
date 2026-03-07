@echo off
REM ================================================================
REM News & Events - Activate Simplified Version
REM ================================================================
echo.
echo ========================================================
echo   News ^& Events - Simplified Version Installer
echo ========================================================
echo.
echo This script will:
echo   1. Backup your original files
echo   2. Activate the simplified version
echo.
echo Your original files will be saved with _BACKUP suffix
echo.
pause

cd /d "%~dp0application\views\admin"

echo.
echo [1/3] Backing up original files...
if exist "news_and_events.php" (
    copy /Y "news_and_events.php" "news_and_events_BACKUP.php" >nul
    echo   ✓ Backed up: news_and_events.php
)
if exist "create_event_views.php" (
    copy /Y "create_event_views.php" "create_event_views_BACKUP.php" >nul
    echo   ✓ Backed up: create_event_views.php
)
if exist "edit_event_views.php" (
    copy /Y "edit_event_views.php" "edit_event_views_BACKUP.php" >nul
    echo   ✓ Backed up: edit_event_views.php
)

echo.
echo [2/3] Activating simplified versions...
if exist "news_and_events_simplified.php" (
    copy /Y "news_and_events_simplified.php" "news_and_events.php" >nul
    echo   ✓ Activated: news_and_events.php
)
if exist "create_event_simplified.php" (
    copy /Y "create_event_simplified.php" "create_event_views.php" >nul
    echo   ✓ Activated: create_event_views.php
)
if exist "edit_event_simplified.php" (
    copy /Y "edit_event_simplified.php" "edit_event_views.php" >nul
    echo   ✓ Activated: edit_event_views.php
)

echo.
echo [3/3] Verifying installation...
if exist "news_and_events.php" (
    echo   ✓ Main page: OK
) else (
    echo   ✗ Main page: MISSING
)
if exist "create_event_views.php" (
    echo   ✓ Create page: OK
) else (
    echo   ✗ Create page: MISSING
)
if exist "edit_event_views.php" (
    echo   ✓ Edit page: OK
) else (
    echo   ✗ Edit page: MISSING
)

echo.
echo ========================================================
echo   Installation Complete!
echo ========================================================
echo.
echo Next steps:
echo   1. Open your browser
echo   2. Go to your admin panel
echo   3. Navigate to News ^& Events
echo   4. Enjoy the simplified interface!
echo.
echo To restore original files:
echo   Run: restore_original.bat
echo.
pause
