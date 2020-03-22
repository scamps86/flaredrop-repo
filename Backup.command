rsync -avz --delete -e 'ssh -p 8306' root@flaredrop.com:/backup ~/Documents/REPOSITORY/_SERVER_BACKUP/
zip -r Desktop/BACKUPS/Backup_$(date +%Y_%m_%d).zip ~/Documents/REPOSITORY/