@echo off
REM ================================================================
REM News & Events - Restore Original Version
REM ================================================================
echo.
echo ========================================================
echo   News ^& Events - Restore Original Version
echo ========================================================
echo.
echo This script will restore your original files
echo from the backups created during installation.
echo.
pause

cd /d "%~dp0application\views\admin"

echo.
echo [1/2] Checking for backup files...
if exist "news_and_events_BACKUP.php" (
    echo   ✓ Found: news_and_events_BACKUP.php
) else (
    echo   ✗ Missing: news_and_events_BACKUP.php
)
if exist "create_event_views_BACKUP.php" (
    echo   ✓ Found: create_event_views_BACKUP.php
) else (
    echo   ✗ Missing: create_event_views_BACKUP.php
)
if exist "edit_event_views_BACKUP.php" (
    echo   ✓ Found: edit_event_views_BACKUP.php
) else (
    echo   ✗ Missing: edit_event_views_BACKUP.php
)

echo.
echo [2/2] Restoring original files...
if exist "news_and_events_BACKUP.php" (
    copy /Y "news_and_events_BACKUP.php" "news_and_events.php" >nul
    echo   ✓ Restored: news_and_events.php
)
if exist "create_event_views_BACKUP.php" (
    copy /Y "create_event_views_BACKUP.php" "create_event_views.php" >nul
    echo   ✓ Restored: create_event_views.php
)
if exist "edit_event_views_BACKUP.php" (
    copy /Y "edit_event_views_BACKUP.php" "edit_event_views.php" >nul
    echo   ✓ Restored: edit_event_views.php
)

echo.
echo ========================================================
echo   Restoration Complete!
echo ========================================================
echo.
echo Your original files have been restored.
echo Refresh your admin panel to see the changes.
echo.
echo To re-activate simplified version:
echo   Run: activate_simplified.bat
echo.
pause
