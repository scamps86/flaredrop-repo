@echo off

winscp /console /command "open root:.k0rgtr1n1tye!f14r3dr0pd3v310pm3nt#@flaredrop.com:8306" "synchronize local -delete ""C:\REPOSITORY\_SERVER_BACKUP\"" /backup" "exit"

rd C:\REPOSITORY\target_release /s /q
rd C:\REPOSITORY\target_release_temp /s /q
IF NOT DEFINED BAR (
   set FILENAME=Backup_%date:/=_%.7z
)
cd "C:\REPOSITORY"
echo on
"C:\Program Files\7-Zip\7za" a -t7z "%FILENAME%"
move "%FILENAME%" "Z:\Desktop\"

pause